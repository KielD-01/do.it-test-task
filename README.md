# DO IT Laravel Test Task

API Endpoint URI - `http://95.47.114.252/api/`

### How to run it?
1. Run `composer install`
2. Run `cp .env.example .env`
3. Create database `do_it_test`
4. Updated MySQL connection credentials in the `DB_*` from the `.env` file
5. Run `php artisan migrate; php artisan passport:install; php artisan key:generate; php artisan serve`
6. Open Postman or make a call as in the [API](./docs/api.md)
7. Enjoy!
