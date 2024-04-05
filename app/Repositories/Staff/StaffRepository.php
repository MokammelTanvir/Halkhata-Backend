<?php

namespace App\Repositories\Staff;

use Illuminate\Support\Str;
use App\Models\User as Staff;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Hash;

class StaffRepository implements StaffInterface
{
    private $file_path = "public/staff";
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data = Staff::create([
            'role_id' => Staff::STAFF,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
            'nid' =>  $request_data->nid,
            'address' =>$request_data->address,
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
        $data = Staff::Staff()
        ->latest('id')
        ->get();
        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Staff::staff()
        ->latest('id')
        ->when(request('search'), function($query){
            $query->where('name', 'like', '%'.request('search').'%')
                ->orWhere('phone', 'like', '%'.request('search').'%')
                ->orWhere('email', 'like', '%'.request('search').'%')
                ->orWhere('nid', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @retun mixed|void
    */

    public function show($id)
    {
        return Staff::findOrFail($id);
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'role_id' => Staff::STAFF,
            'name' => $request_data->name,
            'phone' =>  $request_data->phone,
            'email' =>  $request_data->email,
            'nid' =>  $request_data->nid,
            'address' =>$request_data->address,
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
