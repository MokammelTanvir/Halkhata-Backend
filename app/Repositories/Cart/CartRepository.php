<?php

namespace App\Repositories\Cart;

use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\CartCategory;
use App\Models\Product;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class CartRepository implements CartInterface
{
    private $file_path = "public/Cart";
    /*
    * @param $data
    * @return mixed|void
    */

    public function addToCart($request_data)
    {
      $product_id = $request_data->product_id;
      $product = Product::find($product_id);

      /*Check if already product added on cart or not */
      $check = Cart::where(['product_id' => $product_id])->first();
      if($check){
        /* found -> increase cart qty */
        $check->increment('qty');
        $check->update([
            'subtotal' => $check->qty*$check->price
        ]);
        return $check;
      }else{
        $cart = Cart::create([
            'product_id' => $request_data->product_id,
            'product_name' => $request_data->product_name,
            'qty' => $request_data->qty,
            'price' =>$request_data->price,
            'subtotal' => $request_data->subtotal,
        ]);
        return $cart;
      }

    }

    /*
    * @return mixed|void
    */

    public function getCartItems()
    {
        $data = Cart::with(['product:id,name,code,sell_price'])->get();
        return $data;
    }

    /*
    * @return mixed|void
    */

    public function removeFromCart($id)
    {
        $data = Cart::findOrFail($id);
        $data->delete();
        return true;
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function incItemQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->increment('qty');
        $data->update([
            'subtotal' => $data->qty*$data->price
        ]);
        return $data;
    }

    public function decItemQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->decrement('qty');
        $data->update([
            'subtotal' => $data->qty*$data->price
        ]);

        return $data;
    }
}
