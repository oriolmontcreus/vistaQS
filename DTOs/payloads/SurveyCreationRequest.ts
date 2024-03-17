type SurveyCreationRequest = {
    survey: {
        descr: string;
        startDate: string;
        endDate: string;
    };
    questions: {
        question: string;
        idQuestionType: number;
        options?: {
            idAnswer: number;
            descr: string;
        }[];
    }[];
    idSurveyor: number;
};

export default SurveyCreationRequest;