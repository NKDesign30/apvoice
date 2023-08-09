import get from "lodash/get";
import uniqueId from "lodash/uniqueId";
import { training } from "@/tailwind/Colors";

export default class TrainingMapper {
  static this(data) {
    return {
      id: get(data, "id", ""),
      slug: get(data, "slug", ""),
      title: get(data, "title.rendered", ""),
      informations: get(data, "acf.informations", {}),
      categories: get(data, "training-category", []),
      pghealth: get(data, "pghealth", 0),
      product: get(data, "product", 0),
      trainings: get(data, "trainings", []).map(training =>
        TrainingMapper.mapTrainingInSeries(training)
      ),
      /* TrainingMapper.sortTrainings(
        //  data
        get(data, "trainings", []).map(training => TrainingMapper.mapTrainingInSeries(training))
      ), */
      summaryPage: get(data, "acf.summary_page", {}),
      dutyText: get(data, "acf.duty_text", ""),
      boost: get(data, "acf.informations.boost", ""),
      finishPage: get(data, "acf.finish_page.success_page", {}),
      related: get(data, "acf.related_trainings", {})
    };
  }

  static mapTrainingInSeries(data) {
    const lessons = get(data, "lessons", []).map(lesson => ({
      trainingSeriesId: get(data, "training_series_id", null),
      training_id: get(data, "training.ID", null),
      ...TrainingMapper.mapLesson(lesson.lesson)
    }));

    return {
      trainingSeriesId: get(data, "training_series_id", null),
      id: get(data, "training.ID", null),
      slug: get(data, "training.post_name", null),
      globals: get(data, "globals", {}),
      isPremium: data.training.is_premium,
      year: get(data, "year", ""),
      lessons,
      storeEndpoint: get(data, "storeEndpoint", false)
    };
  }

  static mapChapter(chapter) {
    return {
      id: get(chapter, "chapter_id", uniqueId("tq-")),
      chapter_id: get(chapter, "chapter_id", uniqueId("tq-")),
      image: get(chapter, "image", {}),
      question: get(chapter, "question", ""),
      choices: get(chapter, "choices", []).map(choice => TrainingMapper.mapChoice(choice)),
      references: get(chapter, "references", "")
    };
  }

  static mapChoice(choice) {
    return {
      id: get(choice, "choice_id", uniqueId("choice-")),
      ...choice,
      validationClass: null
    };
  }

  static mapLesson(lesson) {
    return {
      ...lesson,
      quiz: {
        ...lesson.quiz,
        chapters: lesson.quiz.chapters.map(chapter => TrainingMapper.mapChapter(chapter))
      },
      productInformation: TrainingMapper.mapProductInformation(lesson)
    };
  }

  /* static sortTrainings(trainings) {
    return trainings.sort((a, b) => {
      if (a.boost > b.boost) {
        return 1;
      }
      return -1;
    });
  } */

  static createPayload(answers, additionalFields = {}) {
    return {
      result: [TrainingMapper.createResultPayload(answers, additionalFields)],
      ...additionalFields
    };
  }

  static createLikesPayload(likes = {}) {
    return {
      result: [TrainingMapper.createResultPayload(likes)]
    };
  }

  // eslint-disable-next-line camelcase
  static createResultPayload(answers, { training_id, lesson_id }) {
    const mappedAnswers = answers.map(answer => ({
      chapter: answer.chapter,
      choice: {
        id: answer.choice_id,
        value: answer.value,
        is_true: answer.is_true
      }
    }));

    return {
      training_id,
      lesson_id,
      answers: mappedAnswers
    };
  }

  static mapProductInformation(lesson) {
    return (get(lesson, "product_information", []) || [])
      .map(content => {
        if (!content.text_media_paragraph) {
          return null;
        }

        return {
          acf_fc_layout: "text-media_paragraph",
          ...content
        };
      })
      .filter(content => content !== null);
  }
}
