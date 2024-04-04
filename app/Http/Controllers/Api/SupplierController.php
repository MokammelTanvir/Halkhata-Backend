<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Repositories\Supplier\SupplierInterface;

class SupplierController extends Controller
{
    use ApiResponse;

    private $supplierRepository;

    public function __construct(SupplierInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allSupplier()
    {
        $data = $this->supplierRepository->all();
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(SupplierResource::collection($data), $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page');
        $data = $this->supplierRepository->allPaginate($perPage);
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            $data = $this->supplierRepository->store($request);
            return $this->ResponseSuccess(new SupplierResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
           return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->supplierRepository->show($id);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new SupplierResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, string $id)
    {
        try {
            $data = $this->supplierRepository->update($request, $id);
            return $this->ResponseSuccess(new SupplierResource($data), null, 'Data Updated Successfully!', 200);
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
            $data = $this->supplierRepository->delete($id);
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
            $data = $this->supplierRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Exception $e) {
           return $this->ResponseError($e->getMessage());
        }
    }
}
