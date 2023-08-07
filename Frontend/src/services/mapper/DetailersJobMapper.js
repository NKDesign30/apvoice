import get from 'lodash/get';

export default class DetailersJobMapper {
  static mapInformationalTrainings(allData) {
    return allData.map(data => DetailersJobMapper.mapInformationalTraining(data));
  }

  static mapInformationalTraining(data) {
    return {
      id: String(get(data, 'id', '')),
      title: get(data, 'title.rendered', ''),
      questions: DetailersJobMapper.mapInformationalTrainingQuestions(get(data, 'acf.informational_training.questions', [])),
      finishPage: DetailersJobMapper.mapInformationalTrainingFinishPage(get(data, 'acf.informational_training.finish_page', {})),
    };
  }

  static mapInformationalTrainingQuestions(allData) {
    return allData.map(data => DetailersJobMapper.mapInformationalTrainingQuestion(data));
  }

  static mapInformationalTrainingQuestion(data) {
    return {
      id: get(data, 'id', ''),
      question: get(data, 'question.question', ''),
      answerA: DetailersJobMapper.mapInformationalTrainingAnswer(get(data, 'question.answer_option_group_1', {})),
      answerB: DetailersJobMapper.mapInformationalTrainingAnswer(get(data, 'question.answer_option_group_2', {})),
    };
  }

  static mapInformationalTrainingAnswer(data) {
    return {
      id: get(data, 'answer_id', ''),
      answer: get(data, 'answer', ''),
      content: get(data, 'content', []),
      continuesTraining: get(data, 'is_true', false),
    };
  }

  static mapInformationalTrainingFinishPage(data) {
    return {
      content: get(data, 'finish_page', []),
    };
  }

  static mapSavedStates(allData) {
    return allData.map(data => DetailersJobMapper.mapSavedState(data));
  }

  static mapSavedState(data) {
    return {
      createdAt: get(data, 'created_at', ''),
      detailerUserId: String(get(data, 'detailer_user_id', '')),
      informationalTrainingId: String(get(data, 'informational_training_id', '')),
      lastQuestionId: String(get(data, 'last_question_id', '')),
      pharmacyId: String(get(data, 'pharmacy_id', '')),
      updatedAt: get(data, 'updated_at', ''),
    };
  }
}
