<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\Product\ProductInterface;

class ProductController extends Controller
{
    use ApiResponse;

    private $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allProduct()
    {
        $data = $this->productRepository->all();
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(ProductResource::collection($data), $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page');
        $data = $this->productRepository->allPaginate($perPage);
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $this->productRepository->store($request);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->productRepository->show($id);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new ProductResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $data = $this->productRepository->update($request, $id);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Data Updated Successfully!', 200);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = $this->productRepository->delete($id);
            return $this->ResponseSuccess($data, null, 'Data Deleted Successfully!', 204);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }
    /**
     * Change Status of specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $data = $this->productRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }
}
