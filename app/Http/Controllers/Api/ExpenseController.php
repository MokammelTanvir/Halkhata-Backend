<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Repositories\Expense\ExpenseInterface;

class ExpenseController extends Controller
{
    use ApiResponse;

    private $expenseRepository;

    public function __construct(ExpenseInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allExpenseCategory()
    {
        $data = $this->expenseRepository->allExpenseCategory();
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function allExpense()
    {
        $data = $this->expenseRepository->all();
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(ExpenseResource::collection($data), $metadata);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page');
        $data = $this->expenseRepository->allPaginate($perPage);
        $metadata['count'] = count($data);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        try {
            $data = $this->expenseRepository->store($request);
            return $this->ResponseSuccess(new ExpenseResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
           return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->expenseRepository->show($id);
        if(!$data){
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new ExpenseResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, string $id)
    {
        try {
            $data = $this->expenseRepository->update($request, $id);
            return $this->ResponseSuccess(new ExpenseResource($data), null, 'Data Updated Successfully!', 200);
        } catch (\Exception $e) {
           return $this->ResponseError($e->getMessage());
        }
    }
}
