<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->beforeEach(function () {
    // Fixed first product.
    \App\Models\Product::create([
        'name' => 'Product Name',
        'description' => 'Product Description.',
        'price' => 10.00,
    ]);

    \App\Models\User::factory(5)->create();
    \App\Models\Product::factory(20)->create();
})->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function takeBearToken(array $abilities = []): string
{
    $user = \App\Models\User::factory()->create();

    return $user->createToken('test', $abilities)
        ->plainTextToken;
}

function requestHeaders(array $abilities = [], bool $acceptJson = true): array
{
    $headers = [
        'Authorization' => 'Bearer '.takeBearToken($abilities),
    ];

    if ($acceptJson) {
        $headers['Accept'] = 'application/json';
    }

    return $headers;
}
