<?php

namespace Yab\Hadron\Controllers;

use CryptoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yab\Hadron\Requests\CreateProductRequest;
use Yab\Hadron\Services\ProductService;
use Yab\Hadron\Repositories\ProductVariantRepository;

class TransactionController extends Controller
{
    public function __construct(ProductService $productService, ProductVariantRepository $productVariantRepository)
    {
        $this->service = $productService;
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->service->paginated();
        return view('hadron::products.index')
            ->with('pagination', $products->render())
            ->with('products', $products);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $products = $this->service->search($request->search);
        return view('hadron::products.index')
            ->with('term', $request->search)
            ->with('pagination', $products->render())
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hadron::products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect('quarx/products/'.CryptoService::encrypt($result->id).'/edit')->with('message', 'Successfully created');
        }

        return redirect('quarx/products')->with('message', 'Failed to create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->service->find($id);
        return view('hadron::products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $product = $this->service->find(CryptoService::decrypt($id));

        $productVariants = $this->productVariantRepository->getProductVariants($product->id)->get();

        $tabs = [
            'details' => $request->get('details'),
            'variants' => $request->get('variants'),
            'subscription' => $request->get('subscription'),
            'download' => $request->get('download'),
            'related' => $request->get('related'),
            'discount' => $request->get('discount'),
        ];

        if (empty($request->all())) {
            $tabs['details'] = true;
        }

        $data = [
            'product' => $product,
            'productVariants' => $productVariants,
            'tabs' => $tabs,
        ];

        return view('hadron::products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CreateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateProductRequest $request, $id)
    {
        $result = $this->service->update(CryptoService::decrypt($id), $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->with('message', 'Failed to update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy(CryptoService::decrypt($id));

        if ($result) {
            return redirect('quarx/products')->with('message', 'Successfully deleted');
        }

        return redirect('quarx/products')->with('message', 'Failed to delete');
    }
}
