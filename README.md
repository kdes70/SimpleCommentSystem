# Система комментариев

Это простая система комментариев, которая позволяет пользователям просматривать статью и оставлять комментарии.
Комментарии сохраняются в базе данных совместно с датой их публикации.

## Requirements

- Docker
- Docker Compose

## Installation

1. Clone the repository::

- `git clone git@github.com:kdes70/SimpleCommentSystem.git`

2. Navigate to the project directory:

- `cd comment-system`

3. Build and start the Docker containers:

- `docker-compose up -d`

4. Install the PHP dependencies:

- `docker-compose exec app composer install`

5. Install the JavaScript dependencies:

- `docker-compose exec app npm install`

6. Build the JavaScript assets:

- `docker-compose exec app npm run dev`

The application should now be accessible at `http://localhost:8000`.

## Usage

To add a new comment, fill out the form on the homepage and submit it. The comment will be added asynchronously without
reloading the page.

## Development

During development, you can run the following command to watch for changes in JavaScript files and automatically rebuild
the assets:

If you make changes to PHP files, you will need to restart the Docker containers:

## License

This project is licensed under the [MIT License](LICENSE).
