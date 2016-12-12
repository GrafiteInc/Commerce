<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class CartServiceTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->login();
        $this->migrateUp('quarx');

        factory(\Yab\Hadron\Models\Cart::class)->create();
        factory(\Yab\Hadron\Models\Products::class)->create();
        factory(\Yab\Hadron\Models\SubscriptionPlans::class)->create();
        factory(\Yab\Hadron\Models\Variants::class)->create();

        $this->cartService = new \Yab\Hadron\Services\CartService();
        $this->cartRepo = new \Yab\Hadron\Repositories\CartRepository();
        $this->productRepo = new \Yab\Hadron\Repositories\ProductsRepository();
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
        $this->assertEquals(0, $response);
    }

    public function testContents()
    {
        $this->call('GET', '/store/cart/add?id=1&type=product&quantity=1&variables=%7B%7D');
        $this->call('GET', '/store/cart/add?id=1&type=subscription&quantity=1&variables=%7B%7D');

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
                'variable' => 1,
                'value' => 'small',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);
        $product = $this->productRepo->findProductsById(1);

        $response = $this->cartService->priceVariants($item, $product);

        $this->assertEquals(99.99, $product->price());
    }

    public function testPriceVariantsAgain()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variable' => 1,
                'value' => 'large(+2)[+2]',
            ],
        ]));

        $item = $this->cartRepo->getItem(2);

        $product = $this->productRepo->findProductsById(1);

        $response = $this->cartService->priceVariants($item, $product);

        $this->assertEquals(101.99, $product->price());
    }

    public function testPriceWeight()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variable' => 1,
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
                'variable' => 1,
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
                'variable' => 1,
                'value' => 'small',
            ],
        ]));

        $this->assertTrue(is_object($response));
        $this->assertEquals('product', $response->entity_type);
    }

    public function testGetDefaultValue()
    {
        $variable = factory(\Yab\Hadron\Models\Variants::class)->make([
            'id' => 4,
        ]);
        $response = $this->cartService->getDefaultValue($variable);
        $this->assertEquals('small', $response);
    }

    public function testGetVariantId()
    {
        $variable = factory(\Yab\Hadron\Models\Variants::class)->make([
            'id' => 4,
        ]);
        $response = $this->cartService->getId($variable);
        $this->assertEquals(4, $response);
    }

    public function testChangeItemQuantity()
    {
        $this->cartService->addToCart(1, 'product', 1, json_encode([
            [
                'variable' => 1,
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
                'variable' => 1,
                'value' => 'small',
            ],
        ]));
        $response = $this->cartService->removeFromCart(2, 'product');
        $this->assertTrue($response);
    }
}
