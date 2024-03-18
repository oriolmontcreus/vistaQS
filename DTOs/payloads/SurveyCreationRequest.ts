import QuestionDefinition from "@dto/types/Survey/QuestionDefinition";
import SurveyDefinition from "@dto/types/Survey/SurveyDefinition";

type SurveyCreationRequest = {
    survey: SurveyDefinition;
    questions: QuestionDefinition[];
    idSurveyors: number[];
};

export default SurveyCreationRequest;