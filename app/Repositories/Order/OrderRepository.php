<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User as Customer;
use Illuminate\Support\Facades\Hash;

class OrderRepository implements OrderInterface
{
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {

        // Check Customer Already exists
        $customer_mobile = $request_data->customer_mobile;

        $customer = Customer::customer()->where(['phone' => $customer_mobile])->first();

        if(!$customer){
            $customer = Customer::create([
                'name' => $request_data->customer_name ?? 'walk in customer',
                'role_id' => Customer::CUSTOMER,
                'phone' => $customer_mobile,
                'password' => Hash::make(1234)
            ]);
        }

        $data = Order::create([
            'customer_id' => $customer->id,
            'pay_amount' => $request_data->pay_amount,
            'due_amount' => $request_data->due_amount,
            'subtotal' => $request_data->subtotal,
            'discount' => $request_data->discount,
            'total' => $request_data->total,
            'transaction_number' => $request_data->transaction_number,
            'payment_method' => $request_data->payment_method,
        ]);

        /* get all cart items */
        $cart_items = Cart::all();

        foreach ($cart_items as $key => $item) {
            OrderDetails::create([
                'order_id' => $data->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
            ]);

            /* decrease product stock from product table */
            Product::find($item->product_id)->decrement('stock', $item->qty);
            $item->delete();
        }

        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */

    public function all()
    {
        $data = Order::latest('id')
        ->with([
            'order_details',
            'customer'
        ])
        ->get();
        return $data;
    }

    /*
    * @return mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Order::latest('id')
        ->when(request('search'), function($query){
            $query->where('transaction_number', 'like', '%'.request('search').'%')
                ->orWhere('created_at', 'like', '%'.request('search').'%');
        })
        ->with([
            'order_details',
            'customer'
        ])
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */

    public function show($id)
    {
        return Order::with(['order_details', 'customer'])->findOrFail($id);
    }
}
