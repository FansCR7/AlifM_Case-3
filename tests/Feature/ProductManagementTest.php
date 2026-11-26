<?php

use App\Livewire\Products\Index;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

test('a user can create, edit, soft delete, and restore their products', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('name', 'Kamera Digital')
        ->set('sku', 'CAM-001')
        ->set('category', 'Elektronik')
        ->set('description', 'Kamera untuk dokumentasi.')
        ->set('stock', '6')
        ->set('price', '2500000')
        ->call('save')
        ->assertHasNoErrors();

    $product = Product::query()->where('sku', 'CAM-001')->firstOrFail();
    expect($product->user_id)->toBe($user->id);

    Livewire::test(Index::class)
        ->call('editProduct', $product->id)
        ->set('name', 'Kamera Digital Pro')
        ->call('save')
        ->assertHasNoErrors();

    expect($product->fresh()->name)->toBe('Kamera Digital Pro');

    Livewire::test(Index::class)
        ->call('deleteProduct', $product->id)
        ->assertDontSee('Kamera Digital Pro');

    expect($product->fresh()->trashed())->toBeTrue();

    Livewire::test(Index::class)
        ->set('showTrash', true)
        ->call('restoreProduct', $product->id)
        ->assertHasNoErrors();

    expect($product->fresh()->trashed())->toBeFalse();
});

test('product actions cannot change another users products', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $product = Product::query()->create([
        'user_id' => $otherUser->id,
        'name' => 'Barang Pribadi',
        'sku' => 'OWN-001',
        'stock' => 1,
        'price' => 10000,
    ]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->call('deleteProduct', $product->id)
        ->assertStatus(404);

    expect($product->fresh()->trashed())->toBeFalse();
});

test('product changes invalidate the cached dashboard statistics', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $key = 'products:statistics:user:'.$user->id;
    Cache::put($key, ['total' => 0, 'stock' => 0, 'low_stock' => 0], now()->addMinutes(5));

    Livewire::test(Index::class)
        ->set('name', 'Buku')
        ->set('sku', 'BOOK-001')
        ->set('stock', '3')
        ->set('price', '15000')
        ->call('save')
        ->assertHasNoErrors();

    expect(Cache::get($key))->toMatchArray([
        'total' => 1,
        'stock' => 3,
        'low_stock' => 1,
    ]);
});
