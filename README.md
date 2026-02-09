# News API

A Laravel-based RESTful API for news aggregation, user preferences, and authentication. Built with PHP 8.2 and Laravel 12, featuring Fortify for authentication and Sanctum for API token management.

## Features
- User registration and login
- Secure authentication with Laravel Sanctum
- Fetch authors, categories, and news sources
- Retrieve news articles (authenticated)
- Update user preferences (authenticated)

## Requirements
- PHP ^8.2
- Composer
- Node.js & npm
- SQLite (default, can be changed)

## Setup
1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd news-api
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy environment file and generate app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   ### Configure the Database
   By default, the project uses **SQLite**:
   - Create the database file:
     ```bash
     touch database/database.sqlite
     ```
   - Ensure these settings in `.env`:
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=./database/database.sqlite
     ```

   To use **MySQL** or another driver, update the following variables in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
   > ℹ️ Adjust values as needed for your environment.

4. Run database migrations:
   ```bash
   php artisan migrate
   ```
5. Install JS dependencies and build assets:
   ```bash
   npm install
   npm run build
   ```
6. Start the server:
   ```bash
   php artisan serve
   ```
   
   ```
7. Fetch News from external APIs:
   ```bash
   php artisan app:fetch-latest-news
   ```

## API Endpoints

### Auth
- `POST /api/register-user` — Register a new user
  - **Headers:** `Accept: application/json`
  - **Body (form-data):**
    - `name` (string, required)
    - `email` (string, required)
    - `password` (string, required)
    - `password_confirmation` (string, required)
  - **Example:**
    ```bash
    curl -X POST http://localhost:8000/api/register-user \
         -F "name=ahmed" \
         -F "email=ahmedtaweel96@gmail.com" \
         -F "password=12345678" \
         -F "password_confirmation=12345678" \
         -H "Accept: application/json"
    ```

- `POST /api/login` — Login and receive token
  - **Headers:** `Accept: application/json`
  - **Body (form-data):**
    - `email` (string, required)
    - `password` (string, required)
  - **Example:**
    ```bash
    curl -X POST http://localhost:8000/api/login \
         -F "email=ahmedtaweel96@gmail.com" \
         -F "password=12345678" \
         -H "Accept: application/json"
    ```

### User
- `PUT /api/user/preferences` — Update user preferences
  - **Authentication:** Bearer token required
  - **Headers:** `Accept: application/json`, `Content-Type: application/json`
  - **Body (JSON):**
    - `preferred_sources` (array of strings)
    - `preferred_categories` (array of integers)
    - `preferred_authors` (array of integers)
  - **Example:**
    ```bash
    curl -X PUT http://localhost:8000/api/user/preferences \
         -H "Authorization: Bearer <token>" \
         -H "Accept: application/json" \
         -H "Content-Type: application/json" \
         -d '{
             "preferred_sources": ["bbc_api", "news_api"],
             "preferred_categories": [1],
             "preferred_authors": [1]
         }'
    ```

### News
- `GET /api/authors` — List authors
  - **Example:**
    ```bash
    curl http://localhost:8000/api/authors
    ```

- `GET /api/categories` — List categories
  - **Example:**
    ```bash
    curl http://localhost:8000/api/categories
    ```

- `GET /api/news-sources` — List news sources
  - **Example:**
    ```bash
    curl http://localhost:8000/api/news-sources
    ```

- `GET /api/news` — List news articles
  - **Authentication:** Bearer token required
  - **Headers:** `Accept: application/json`
  - **Query Parameters:**
    - `sources[0]` (string, e.g. `bbc_api`, `news_api`, `guardian_api`)
    - `per_page` (integer, optional)
    - `page` (integer, optional)
    - `categories[0]` (integer, optional)
    - `with_preferences` (0 or 1, optional)
    - `date_from` (YYYY-MM-DD, optional)
    - `date_to` (YYYY-MM-DD, optional)
  - **Example:**
    ```bash
    curl -H "Authorization: Bearer <token>" \
         -H "Accept: application/json" \
         "http://localhost:8000/api/news?sources[0]=guardian_api&per_page=100&with_preferences=0&date_from=2026-01-01&date_to=2026-01-30"
    ```
## License
MIT

## Maintainer
Innoscripta

_Last updated: February 9, 2026_
