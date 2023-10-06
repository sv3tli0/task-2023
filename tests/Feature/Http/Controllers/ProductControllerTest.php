<?php

use App\Models\Product;

test('product can be found', function () {
    $response = $this->get('/api/products/1', requestHeaders(['read']));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'product' => [
            'id',
            'name',
            'description',
            'price',
        ],
    ]);
});

test('product can be created', function () {
    $productAttributes = [
        'name' => 'Product Two',
        'description' => 'Product Two Description',
        'price' => 12.34,
    ];

    $response = $this->post('/api/products', $productAttributes, requestHeaders(['read', 'write']));

    $response->assertJsonStructure([
        'id',
        'message',
    ]);

    $product = Product::find($response->json('id'));

    expect($product->name)->toBe($productAttributes['name']);
    expect($product->description)->toBe($productAttributes['description']);
    expect($product->price)->toBe($productAttributes['price']);
});

test('product can be updated', function () {
    $response = $this->put('/api/products/1', [
        'name' => 'New Name',
        'description' => 'New Description',
        'price' => 12.34,
    ], requestHeaders(['read', 'write']));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'message',
    ]);

    $product = Product::find(1);

    expect($product->name)->toBe('New Name');
    expect($product->description)->toBe('New Description');
    expect($product->price)->toBe(12.34);
});

test('user can delete product', function () {
    $response = $this->delete('/api/products/1', [], requestHeaders(['read', 'write', 'delete']));

    $response->assertStatus(200);

    expect(Product::find(1))->toBeNull();
});

test("user can't delete", function () {
    $response = $this->delete('/api/products/1', [], requestHeaders(['read', 'write']));

    $response->assertStatus(403);
});

test("user can't create", function () {
    $response = $this->post('/api/products', [], requestHeaders(['read']));

    $response->assertStatus(403);
});

test("user can't update", function () {
    $response = $this->put('/api/products/1', [], requestHeaders(['read']));

    $response->assertStatus(403);
});
