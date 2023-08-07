import get from 'lodash/get';
import uniqueId from 'lodash/uniqueId';

export default class SurveyMapper {
  static mapSurvey(data) {
    return {
      id: String(get(data, 'id', '')),
      slug: get(data, 'slug', ''),
      title: get(data, 'title.rendered', ''),
      description: get(data, 'acf.description', ''),
      points: parseInt(get(data, 'acf.points', 0), 10),
      duration: {
        time: parseInt(get(data, 'acf.duration.time', 0), 10),
        type: SurveyMapper.mapDurationType(get(data, 'acf.duration.type', 'sec')),
      },
      expires_at: get(data, 'acf.expires_at', null),
      status: get(data, 'meta.apo_status.0', null),
      chapters: get(data, 'acf.chapters', []).map(chapter => SurveyMapper.mapChapter(chapter)),
      meta: {
        storeEndpoint: get(data, 'storeEndpoint', ''),
      },
      isActivatable: !!parseInt(get(data, 'acf.training_relation.activatable', 0), 10),
      training_id: get(data, 'acf.training_relation.training', 0),
    };
  }

  static mapChapter(data) {
    // if there is an empty chapter the backend returns false,
    // to avoid 'map is not a function' conflicts,
    // catch it and return an empty array
    if (!data.chapter) return [];
    return {
      questions: get(data, 'chapter', []).map(question => SurveyMapper.mapQuestion(question)),
    };
  }

  static mapQuestion(data) {
    const question = {
      id: uniqueId('sq-'),
      type: get(data, 'acf_fc_layout', ''),
      question: get(data, 'question', ''),
      subheadline: get(data, 'subheadline', ''),
      isKeyQuestion: get(data, 'is_key_question', false),
      isOptional: get(data, 'is_optional', false),
      parentValue: get(data, 'parent_value', ''),
      isNested: get(data, 'is_nested', false),
    };

    if (question.isNested) {
      question.nestedQuestion = get(data, 'nested_question', []).map(item => SurveyMapper.mapQuestion(item));
    }

    if (question.type === 'rating') {
      question.value = [];
    } else if (question.type === 'matrix') {
      question.value = {};
    } else {
      question.value = '';
    }

    switch (question.type) {
      case 'rating':
        question.items = get(data, 'items', []).map(item => SurveyMapper.mapRatingItem(item));

        break;

      case 'rating_icons':
        question.ratingType = get(data, 'rating_type', '');

        break;

      case 'matrix':
        question.matrixType = get(data, 'type', '');
        question.sections = get(data, 'sections', []).map(section => ({ id: uniqueId('sq-sctn-'), sectionTitle: get(section, 'title', '') }));
        if (question.matrixType === 'single' || question.matrixType === 'multi') question.answers = get(data, 'answers', []).map(answer => ({ id: uniqueId('sq-answ-'), answerTitle: get(answer, 'answer', '') }));
        else question.answers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10].map(answer => ({ id: uniqueId('sq-answ-'), answerTitle: answer }));

        break;

      case 'question_cluster':
        question.clusterType = get(data, 'question_type', '');
        question.questions = get(data, `cluster_${question.clusterType}`, []).map(item => SurveyMapper.mapQuestion(item));

        break;

      case 'choice':
        question.choices = get(data, 'choices', []).map(choice => SurveyMapper.mapSingleChoice(choice));

        break;

      case 'choice-multi':
        question.choices = get(data, 'choices', []).map(choice => SurveyMapper.mapSingleChoice(choice));
        question.value = [];

        break;

      case 'answer-single-line':
      case 'answer-multi-line':
      case 'promoter_score':
        // left blank intentionally
        break;

      case 'text-paragraph':
        question.value = get(data, 'copy', '');
        break;

      default:
        console.log(`Unknown survey question type "${question.type}" discovered. Custom mapping logic required!`);
    }

    return question;
  }

  static mapRatingItem(data) {
    return {
      id: uniqueId('sq-opt-'),
      headline: get(data, 'headline', ''),
      options: get(data, 'options', []).map(option => SurveyMapper.mapRatingOption(option)),
    };
  }

  static mapRatingOption(data) {
    return {
      id: uniqueId('sq-opt-'),
      label: get(data, 'label', ''),
      tooltip: get(data, 'tooltip', ''),
    };
  }

  static mapDurationType(type) {
    const typeMap = {
      sec: 'seconds',
      min: 'minutes',
      hour: 'hours',
    };

    return typeMap[type];
  }

  static mapSingleChoice(data) {
    return {
      id: uniqueId('sq-sch-'),
      value: get(data, 'choice', ''),
      tooltip: get(data, 'tooltip', ''),
    };
  }

  static createSurveyPayload(survey, additionalFields = {}) {
    const result = survey.chapters
      .map((chapter, chapterIndex) => chapter.questions.flatMap(question => {
        const questionsResult = [];
        if (question.type !== 'text-paragraph') {
          questionsResult.push({
            chapter: chapterIndex + 1,
            is_key_question: question.isKeyQuestion,
            question: question.question,
            type: question.type,
            value: question.value,
            is_optional: question.isOptional,
          });
        }

        if (question.isNested) {
          question.nestedQuestion.forEach(nested => {
            if (nested.parentValue.split(',').find(e => e === question.value || (typeof question.value === 'object' && question.value.some(val => val.value === e || val === e)))) {
              if (question.type !== 'text-paragraph') {
                questionsResult.push({
                  chapter: chapterIndex + 1,
                  is_key_question: nested.isKeyQuestion,
                  question: nested.question,
                  type: nested.type,
                  value: nested.value,
                  is_optional: nested.isOptional,
                });
              }
            }
          });
        }

        if (question.type === 'question_cluster') {
          question.questions.forEach(clusterQuestion => {
            questionsResult.push({
              chapter: chapterIndex + 1,
              is_key_question: clusterQuestion.isKeyQuestion,
              question: clusterQuestion.question,
              parentQuestion: question.question,
              type: clusterQuestion.type,
              value: clusterQuestion.value,
              is_optional: clusterQuestion.isOptional,
            });
          });
        }

        return questionsResult;
      }), [])
      .reduce((accumulator, questions) => [...accumulator, ...questions], []);

    return {
      result,
      ...additionalFields,
    };
  }
}
