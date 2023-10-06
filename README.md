## Setup
1. Requirements: php8.2, composer, git.
2. Clone the repository.
3. Run `composer install`.
4. Copy `.env.example` to `.env` and fill the required values.
5. Execute `php artisan key:generate` and `php artisan migrate --seed`.
6. Run `php artisan serve` to start the server.


## Usage
1. Seeding the DB adds users and products.
2. The API requires authorization via Bearer token, so you need to add the token to the request header.
   1. In terminal run `php artisan user:generate-token` to generate a token for whoever you want.
   2. In your requests add it as: `Authorization: Bearer {GENERATED_TOKEN}`.
3. To access the API you need to make HTTP requests to some of the routes:
   1. `POST /api/v1/products` - create a product.
   2. `GET /api/v1/products/{id}` - get a product by id.
   3. `PUT /api/v1/products/{id}` - update a product by id.
   4. `DELETE /api/v1/products/{id}` - delete a product by id.
4. Testing - just run `php artisan test` in terminal. 
