<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Repositories\Staff\StaffInterface;

class StaffController extends Controller
{
    use ApiResponse;

    private $staffRepository;

    public function __construct(StaffInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allStaff()
    {
        $data = $this->staffRepository->all();
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(StaffResource::collection($data), $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page');
        $data = $this->staffRepository->allPaginate($perPage);
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        try {
            $data = $this->staffRepository->store($request);
            return $this->ResponseSuccess(new StaffResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->staffRepository->show($id);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new StaffResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, string $id)
    {
        try {
            $data = $this->staffRepository->update($request, $id);
            return $this->ResponseSuccess(new StaffResource($data), null, 'Data Updated Successfully!', 200);
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
            $data = $this->staffRepository->delete($id);
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
            $data = $this->staffRepository->status($id);
            return $this->ResponseSuccess($data, null, 'Data Updated Successfully!', 204);
        } catch (\Exception $e) {
        return $this->ResponseError($e->getMessage());
        }
    }
}
