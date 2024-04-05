<?php

namespace App\Repositories\Customer;

use Illuminate\Support\Str;
use App\Models\User as Customer;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class CustomerRepository implements CustomerInterface
{
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data = Customer::create([
            'role_id' => Customer::CUSTOMER,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
            'password' => Hash::make(1234),
        ]);

        return $this->show($data->id);
    }

    /*
    * @retun mixed|void
    */

    public function all()
    {
        $data = Customer::customer()
        ->latest('id')
        ->get();
        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Customer::customer()
        ->latest('id')
        ->when(request('search'), function($query){
            $query->where('name', 'like', '%'.request('search').'%')
                ->orWhere('phone', 'like', '%'.request('search').'%')
                ->orWhere('email', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function show($id)
    {
        return Customer::findOrFail($id);
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'role_id' => Customer::CUSTOMER,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
        ]);

        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();
        return true;
    }

    /*
    * @retun mixed|void
    */

    public function status($id)
    {
        $data = $this->show($id);
        if($data->is_active == 1){
            $data->is_active = 0;
        }elseif($data->is_active == 0){
            $data->is_active = 1;
        }
        $data->save();
        return $data;
    }

}
