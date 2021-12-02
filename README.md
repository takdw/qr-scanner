## Run

Install `composer` dependencies.

    composer install

Copy `.env.example` to `.env`

    cp .env.example .env

Generate application key:

    php artisan key:generate

Install assets and compile.

    npm install && npm run dev

Serve the application.

    php artisan serve
