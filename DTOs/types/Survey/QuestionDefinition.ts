type QuestionDefinition = {
    id: number;
    question: string;
    type: string;
    options?: string[];
    min?: number;
    max?: number;
};
export default QuestionDefinition;