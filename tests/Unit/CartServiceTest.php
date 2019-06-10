<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $user = Mockery::mock('StdClass');
        $user->id = 1;

        Auth::shouldReceive('user')->andReturn($user);

        $user->shouldReceive('favorites')->andReturn(collect([]));

        factory(\SierraTecnologia\Commerce\Models\Cart::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Product::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Plan::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Variant::class)->create();

        $this->cartService = app(\SierraTecnologia\Commerce\Services\CartService::class);
        $this->cartRepo = app(\SierraTecnologia\Commerce\Repositories\CartRepository::class);
        $this->productRepo = app(\SierraTecnologia\Commerce\Repositories\ProductRepository::class);
    }

    public function testAddBtn()
    {
        $object = (object) ['id' => 1];
        $response = $this->cartService->addToCartBtn($object, 'product', 'cool');
        $this->assertEquals('<button class="cool" onclick="store.addToCart(1, 1, \'product\')">product</button>', $response);
    }

    public function testFavoriteToggleBtn()
    {
        $object = (object) ['id' => 1];
        $response = $this->cartService->favoriteToggleBtn($object, 'Favorite', 'heart-sad', 'heart-happy', 'nada');
        $this->assertEquals('<button class="nada" onclick="store.favoriteToggle(1, this, \'Favorite\', \'heart-happy\', \'heart-sad\')" data-url="http://localhost/store/favorites/add/1">Favorite heart-sad</button>', $response);
    }

    public function testRemoveBtn()
    {
        $response = $this->cartService->removeFromCartBtn(1, 'product', 'cool');
        $this->assertEquals('<button type="button" class="cool" onclick="store.removeFromCart(1, \'product\')">product</button>', $response);
    }

    public function testItemCount()
    {
        $response = $this->cartService->itemCount();
        $this->assertEquals(1, $response);
    }

    public function testDoesNotHaveContents()
    {
        $response = $this->cartService->contents();

        $this->assertTrue(is_array($response));
    }

    public function testHasContents()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'large(+2)[+2]',
            ],
        ]));

        $response = $this->cartService->contents();

        $this->assertTrue(is_array($response));
        $this->assertEquals('dumb', $response[0]->name);
    }

    public function testProductHasVariants()
    {
        $response = $this->cartService->productHasVariants(1);
        $this->assertTrue($response);
    }

    public function testPriceVariants()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'small',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);
        $product = $this->productRepo->find(1);

        $response = $this->cartService->priceVariants($item, $product);

        $this->assertEquals(99.99, $product->price);
    }

    public function testPriceVariantsAgain()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'large(+2)[+2]',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);

        $product = $this->productRepo->find(1);

        $response = $this->cartService->priceVariants($item, $product);

        $this->assertEquals(101.99, $product->price);
    }

    public function testPriceWeight()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'large(+2)[+2]',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);
        $product = $this->productRepo->find(1);
        $response = $this->cartService->weightVariants($item, $product);
        $this->assertEquals(2.0, $response);
    }

    public function testPriceWeightAgain()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'small',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);
        $product = $this->productRepo->find(1);
        $response = $this->cartService->weightVariants($item, $product);
        $this->assertEquals(0, $response);
    }

    public function testAddToCart()
    {
        $response = $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'small',
            ],
        ]));

        $this->assertTrue(is_object($response));
        $this->assertEquals('product', $response->entity_type);
    }

    public function testGetDefaultValue()
    {
        $variant = factory(\SierraTecnologia\Commerce\Models\Variant::class)->make([
            'id' => 4,
        ]);
        $response = $this->cartService->getDefaultValue($variant);
        $this->assertEquals('small', $response);
    }

    public function testGetVariantId()
    {
        $variant = factory(\SierraTecnologia\Commerce\Models\Variant::class)->make([
            'id' => 4,
        ]);

        $response = $this->cartService->getId($variant);
        $this->assertEquals(4, $response);
    }

    public function testChangeItemQuantity()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'small',
            ],
        ]));

        $response = $this->cartService->changeItemQuantity(2, 4);
        $this->assertTrue($response);
    }

    public function testRemoveFromCart()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variant' => 1,
                'value' => 'small',
            ],
        ]));

        $response = $this->cartService->removeFromCart(2, 'product');
        $this->assertTrue($response);
    }
}
