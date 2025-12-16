# Connectin - professional Networking for Bangladesh

Connectin is a LinkedIn clone tailored for the Bangladeshi market, built with Laravel. It features user authentication, professional profiles, a social feed with posts/likes/comments, network management, and a job board.

## Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL

## Installation

1.  **Clone the repository** (if applicable) or navigate to the project directory.

2.  **Install PHP Dependencies**:
    ```bash
    composer install
    ```

3.  **Install Node Dependencies**:
    ```bash
    npm install
    ```

4.  **Environment Setup**:
    -   Copy `.env.example` to `.env`.
    -   Update database credentials in `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=connectin
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations**:
    ```bash
    php artisan migrate
    ```

7.  **Link Storage**:
    ```bash
    php artisan storage:link
    ```

## Running the Application

1.  **Start the Local Server**:
    ```bash
    php artisan serve
    ```

2.  **Compile Assets (Vite)**:
    ```bash
    npm run dev
    ```
    Or for production build:
    ```bash
    npm run build
    ```

3.  Access the application at `http://localhost:8000`.

## Features

-   **User Profiles**: Edit headline, about, experience, education. Upload avatar/banner.
-   **Networking**: Send/Accept friend requests. View "My Network".
-   **Social Feed**: Create posts with images. Like and comment on posts.
-   **Job Board**: Post jobs and search for openings.
-   **Search**: Find people by name or keyword.
