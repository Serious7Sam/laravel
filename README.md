# Laravel

Installation
------------

1. Install composer dependencies: `composer install`
2. Copy `.env.example` file to `.env` file with right credentials
3. Run DB migration: `php artisan migrate`
4. Seed DB: `php artisan db:seed`

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
