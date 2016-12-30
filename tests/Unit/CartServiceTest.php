<?php

class CartServiceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $user = Mockery::mock('StdClass');
        $user->id = 1;

        Auth::shouldReceive('user')->andReturn($user);

        factory(\Quarx\Modules\Hadron\Models\Cart::class)->create();
        factory(\Quarx\Modules\Hadron\Models\Product::class)->create();
        factory(\Quarx\Modules\Hadron\Models\Plan::class)->create();
        factory(\Quarx\Modules\Hadron\Models\Variant::class)->create();

        $this->cartService = app(\Quarx\Modules\Hadron\Services\CartService::class);
        $this->cartRepo = app(\Quarx\Modules\Hadron\Repositories\CartRepository::class);
        $this->productRepo = app(\Quarx\Modules\Hadron\Repositories\ProductRepository::class);
    }

    public function testAddBtn()
    {
        $response = $this->cartService->addToCartBtn(1, 'product', 'cool');
        $this->assertEquals('<button class="" onclick="store.addToCart(1, 1, \'product\')">cool</button>', $response);
    }

    public function testRemoveBtn()
    {
        $response = $this->cartService->removeFromCartBtn(1, 'product', 'cool');
        $this->assertEquals('<button class="" onclick="store.removeFromCart(1, \'product\')">cool</button>', $response);
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
        $product = $this->productRepo->findProductsById(1);

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

        $product = $this->productRepo->findProductsById(1);

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
        $product = $this->productRepo->findProductsById(1);
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
        $product = $this->productRepo->findProductsById(1);
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
        $variant = factory(\Quarx\Modules\Hadron\Models\Variant::class)->make([
            'id' => 4,
        ]);
        $response = $this->cartService->getDefaultValue($variant);
        $this->assertEquals('small', $response);
    }

    public function testGetVariantId()
    {
        $variant = factory(\Quarx\Modules\Hadron\Models\Variant::class)->make([
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
