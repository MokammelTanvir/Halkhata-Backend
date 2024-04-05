<?php

namespace App\Repositories\Product;

use Illuminate\Support\Str;
use App\Models\Product;
use App\Service\BarCodeService;
use App\Service\FileUploadService;
use App\Service\QrCodeService;

class ProductRepository implements ProductInterface
{
    private $file_path = "public/product";
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data = Product::create([
            'name' => $request_data->name,
            'slug' => Str::slug($request_data->name),
            'code' =>  $request_data->code,
            'category_id' =>  $request_data->category_id,
            'brand_id' =>  $request_data->brand_id,
            'supplier_id' =>$request_data->supplier_id,
            'original_price' =>  $request_data->original_price,
            'sell_price' =>  $request_data->sell_price,
            'stock' =>  $request_data->stock,
            'description' =>  $request_data->description,
        ]);

        /* image upload */
        $image_path = (new FileUploadService())->imageUpload($request_data, $data, $this->file_path);

        /* qrcode generate */
        $qr_path = (new QrCodeService())->generateQrCode($data, $this->file_path);


        /* bar code generate */
        $bar_path = (new BarCodeService())->generateBarCode($data, $this->file_path);


        /* Update file stage */
        $data->update([
            'file' => 'http://localhost:8000'.$image_path,
            'barcode' => 'http://localhost:8000'.$bar_path,
            'qrcode' => 'http://localhost:8000'.$qr_path,
        ]);
        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */

    public function all()
    {
        $data = Product::latest('id')
        ->with([
            'category:id,name,code',
            'brand:id,name,code',
            'supplier:id,name,phone,email,company_name'
        ])
        ->get();
        return $data;
    }

    /*
    * @return mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Product::latest('id')
        ->when(request('search'), function($query){
            $query->where('name', 'like', '%'.request('search').'%')
                ->orWhere('code', 'like', '%'.request('search').'%');
        })
        ->when(request('category_id'), function($query){
            $query->where(['category_id' => request('category_id')]);
        })
        ->when(request('brand_id'), function($query){
            $query->where(['brand_id' => request('brand_id')]);
        })
        ->with([
            'category:id,name,code',
            'brand:id,name,code',
            'supplier:id,name,phone,email,company_name'
        ])
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */

    public function show($id)
    {
        return Product::with([
            'category:id,name,code',
            'brand:id,name,code',
            'supplier:id,name,phone,email,company_name'
        ])->findOrFail($id);
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'name' => $request_data->name,
            'slug' => Str::slug($request_data->name),
            'code' =>  $request_data->code,
            'category_id' =>  $request_data->category_id,
            'brand_id' =>  $request_data->brand_id,
            'supplier_id' =>$request_data->supplier_id,
            'original_price' =>  $request_data->original_price,
            'sell_price' =>  $request_data->sell_price,
            'stock' =>  $request_data->stock,
            'description' =>  $request_data->description,
        ]);

        /* image upload */
        $image_path = (new FileUploadService())->imageUpload($request_data, $data, $this->file_path);

        /* qrcode generate */
        $qr_path = (new QrCodeService())->generateQrCode($data, $this->file_path);

        /* bar code generate */
        $bar_path = (new BarCodeService())->generateBarCode($data, $this->file_path);

        /* Update file stage */
        $data->update([
            'file' => 'http://localhost:8000'.$image_path,
            'barcode' => 'http://localhost:8000'.$bar_path,
            'qrcode' => 'http://localhost:8000'.$qr_path,
        ]);

        return $data;
    }

    /*
    * @return mixed|void
    */

    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();
        return true;
    }

    /*
    * @return mixed|void
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
