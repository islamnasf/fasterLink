<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Shared\ImageService;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        if ($id) {
            $product = Product::where('store_id', $store->id)->where('id', $id)->first();
            return successResponse(data: ProductCollection::make($product));
        } else {

            $retult = Product::where('store_id', $store->id)->where('department_id', $request->department_id)->paginate(10);
            return successResponse(data: ProductCollection::collection($retult), pagination: $retult);
        }
    }

    public function store(ProductRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }

        if ($request->price < $request->basic_price) {
            $data['discount'] = (($request->basic_price - $request->price) / $request->basic_price) * 100;
        } else {
            $data['discount'] = 0;
        }

        if ($request->get('attributes')) {
            $attributes = json_decode($request->get('attributes'), true);
            foreach ($attributes as $index => $attribute) {
                $attributes[$index]['basic_price'] = number_format($attribute['basic_price'], 2, '.', '');
                $attributes[$index]['price'] = number_format($attribute['price'], 2, '.', '');
                if ($attribute['price'] < $attribute['basic_price']) {
                    $attributes[$index]['discount'] = number_format((($attribute['basic_price'] - $attribute['price']) / $attribute['basic_price'] * 100), 2, '.', '');
                } else {
                    $attributes[$index]['discount'] =  '0.00';
                }
            }
            $data['attributes'] = $attributes;
        }

        $data['image'] = ImageService::save($request, 'products', 'image');
        $data['store_id'] = $store->id;
        Product::create($data);
        return successResponse();
    }

    public function update(ProductRequest $request, $id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $product = Product::where('id', $id)->where('store_id', $store->id)->first();
        if (!$product) {
            return failResponse(__('messages.product_not_found'));
        }
        $data = $request->validated();
        if ($request->price < $request->basic_price) {
            $data['discount'] = (($request->basic_price - $request->price) / $request->basic_price) * 100;
        } else {
            $data['discount'] = 0;
        }
        if ($request->get('attributes')) {
            $attributes = json_decode($request->get('attributes'), true);
            foreach ($attributes as $index => $attribute) {

                $attributes[$index]['basic_price'] = number_format($attribute['basic_price'], 2, '.', '');
                $attributes[$index]['price'] = number_format($attribute['price'], 2, '.', '');
                if ($attribute['price'] < $attribute['basic_price']) {
                    $attributes[$index]['discount'] = number_format((($attribute['basic_price'] - $attribute['price']) / $attribute['basic_price'] * 100), 2, '.', '');
                } else {
                    $attributes[$index]['discount'] =  '0.00';
                }
            }
            $data['attributes'] = $attributes;
        }
        if ($request->hasFile('image')) {
            $data['image'] = ImageService::save($request, 'products', 'image');
        }
        $product->update($data);
        return successResponse();
    }

    public function delete($id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $product = Product::where('id', $id)->where('store_id', $store->id)->first();
        if (!$product) {
            return failResponse(__('messages.product_not_found'));
        }
        $product->delete();
        return successResponse();
    }
}
