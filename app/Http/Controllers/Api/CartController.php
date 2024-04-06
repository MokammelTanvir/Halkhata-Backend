<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Repositories\Cart\CartInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    private $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartItems()
    {
        $data = $this->cartRepository->getCartItems();
        $metadata['total_items'] = count($data);
        $metadata['subtotal'] = Cart::sum('subtotal');
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200);
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    public function addToCart(StoreCartRequest $request)
    {
        try {
            $data = $this->cartRepository->addToCart($request);
            $metadata['subtotal'] = Cart::sum('subtotal');
            return $this->ResponseSuccess($data, $metadata, 'Cart Item added!');
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    public function removeFromCart($id)
    {
        try {
            $data = $this->cartRepository->removeFromCart($id);
            return $this->ResponseSuccess($data, null, 'Cart Item removed!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
    public function incItemQty($id)
    {
        try {
            $data = $this->cartRepository->incItemQty($id);
            return $this->ResponseSuccess($data, null, 'Cart Item incremented!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
    public function decItemQty($id)
    {
        try {
            $data = $this->cartRepository->decItemQty($id);
            return $this->ResponseSuccess($data, null, 'Cart Item decremented!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }


}
