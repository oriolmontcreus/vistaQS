## API Endpoints | VistaQs

### User Related

- `POST /auth/register`: Register a new user.
- `POST /auth/login`: Log in a user.
- `POST /auth/logout`: Log out a user. Requires authentication.
- `GET /user`: Get information about the currently authenticated user. Requires authentication.
- `POST /auth/validate-token`: Validate the current user's authentication token. Requires authentication.

### Surveyors Related

- `GET /surveyors`: Get a list of available surveyors. Requires authentication.

### Surveys Related

- `GET /surveys`: Get a list of surveys for the currently authenticated user. Requires authentication.
- `GET /survey/{id}`: Get a specific survey by its ID. Requires authentication.
- `POST /survey/answers`: Submit answers for a survey. Requires authentication.
- `POST /survey`: Create a new survey. Requires authentication.

### Statistics Related

- `GET /statistics/surveys`: Get the total number of surveys. Requires authentication.
- `GET /statistics/answered-questions`: Get the total number of answered questions. Requires authentication.
- `GET /statistics/answered-surveys`: Get the total number of answered surveys. Requires authentication.