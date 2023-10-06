<?php

use App\Models\Product;

test('products can be created', function () {
    $product = Product::factory()->create();

    expect($product)->toBeObject('Product object');
    expect($product->name)->toBeString('Name string');
    expect($product->description)->toBeString('Description string');
    expect($product->price)->toBeFloat('Price float');
});

test('products can be updated', function () {
    $product = Product::factory()->create();

    $product->update([
        'name' => 'New Name',
        'description' => 'New Description',
        'price' => 10.00,
    ]);

    expect($product->name)->toBe('New Name');
    expect($product->description)->toBe('New Description');
    expect($product->price)->toBe(10.00);
});

test('products can be deleted', function () {
    $product = Product::factory()->create();

    $product->delete();

    expect(Product::find($product->id))->toBeNull();
});
