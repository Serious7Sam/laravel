# Laravel

Installation
------------

1. Install composer dependencies: `composer install`
2. Copy `.env.example` file to `.env` file and set credentials
3. Run DB migration: `php artisan migrate`
4. Seed DB: `php artisan db:seed`
5. Compile assets: `npm run dev`

REST API endpoints
------------------

- Add product:
    - root: `/api/v1/product/`
    - method: `POST`
    - data variables: `name`, `price`, `is_active`
- Add voucher bind to product:
    - root: `/api/v1/product/voucher/{productId}/{voucherId}/`
    - method: `GET`
- Remove voucher bind from product:
    - root: `/api/v1/product/voucher/{productId}/{voucherId}/`
    - method: `DELETE`
- Buy product:
    - root: `/api/v1/product/buy/{id}/`
    - method: `GET`
    
Testing
-------

1. Define environment DB variables in `.env` file: 
- `TEST_DB_CONNECTION`
- `TEST_DB_HOST`
- `TEST_DB_PORT`
- `TEST_DB_DATABASE`
- `TEST_DB_USERNAME`
- `TEST_DB_PASSWORD`

2. Run migration for test connection: `php artisan migrate --database='test'`
