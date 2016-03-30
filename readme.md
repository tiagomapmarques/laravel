# LURK (Laravel Up and Running Kit)

[![Build Status](https://travis-ci.org/tiagomapmarques/lurk.svg?branch=lurk)](https://travis-ci.org/tiagomapmarques/lurk)

LURK is a Laravel fork that includes a bunch of other useful dependencies. Also linting. Beautiful code needs beautiful linting.

## Laravel

For Laravel specific documentation, please refer to the [Laravel website](http://laravel.com/docs) or their [Github page](https://github.com/laravel/laravel).

## Quick start
- Clone the repo
- Make sure composer and npm are installed and available from the root folder of your repo
- Install dependencies with "composer install && npm install"
- Compile assets with "node_modules/gulp/bin/gulp.js"
- Create a database with "touch database/database.sqlite && php artisan migrate && php artisan db:seed"
- Create an environment file with "cp .env.local .env"
- Generate a key for it with "php artisan key:generate"
- Run it with pride with "php artisan serve"

## Issues

If you discover any issues at all, please take a moment to analyse if it's a Laravel issue or a LURK issue. If indeed you found an issue with LURK (dependency issue, an introduced bug, ...), you are free to create an issue :)

## License

LURK, being based on the Laravel framework and its community, is also open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
