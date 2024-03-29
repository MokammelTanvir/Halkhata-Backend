<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSystemSettingRequest;
use App\Repositories\SystemSetting\SystemSettingInterface;

class SystemSettingController extends Controller
{
    use ApiResponse;

    private $systemSettingRepository;

    public function __construct(SystemSettingInterface $systemSettingRepository)
    {
        $this->systemSettingRepository = $systemSettingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->systemSettingRepository->all();
        if(!$data){
            return $this->ResponseError([],null, 'No data found!', 200, 'error');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemSettingRequest $request, string $id)
    {
        try {
            $data = $this->systemSettingRepository->update($request, $id);
            return $this->ResponseSuccess($data, null, 'Update Successfully!');
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }


}
