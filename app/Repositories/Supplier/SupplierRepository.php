<?php

namespace App\Repositories\Supplier;

use Illuminate\Support\Str;
use App\Models\User as Supplier;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class SupplierRepository implements SupplierInterface
{
    private $file_path = "public/supplier";
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data = Supplier::create([
            'role_id' => Supplier::SUPPLIER,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
            'nid' =>  $request_data->nid,
            'address' =>$request_data->address,
            'company_name' =>  $request_data->company_name,
            'password' => Hash::make(1234),
        ]);

        /* image upload */
        $file_path = (new FileUploadService())->fileUpload($request_data, $data, $this->file_path);

        /* Update file stage */
        $data->update([
            'file' => 'http://localhost:8000'.$file_path
        ]);
        return $this->show($data->id);
    }

    /*
    * @retun mixed|void
    */

    public function all()
    {
        $data = Supplier::supplier()
        ->latest('id')
        ->get();
        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Supplier::supplier()
        ->latest('id')
        ->when(request('search'), function($query){
            $query->where('name', 'like', '%'.request('search').'%')
                ->orWhere('phone', 'like', '%'.request('search').'%')
                ->orWhere('email', 'like', '%'.request('search').'%')
                ->orWhere('nid', 'like', '%'.request('search').'%')
                ->orWhere('company_name', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function show($id)
    {
        return Supplier::findOrFail($id);
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'role_id' => Supplier::SUPPLIER,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
            'nid' =>  $request_data->nid,
            'address' =>$request_data->address,
            'company_name' =>  $request_data->company_name,
        ]);
        /* image upload */
        $image_path = (new FileUploadService())->imageUpload($request_data, $data, $this->file_path);

        /* Update file stage */
        $data->update([
            'file' => 'http://localhost:8000'.$image_path
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
