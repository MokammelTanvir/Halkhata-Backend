<?php

namespace App\Repositories\Salary;

use App\Models\Salary;
use App\Models\User;
use App\Notifications\SalaryDisburseNotification;
use Illuminate\Support\Facades\Notification;

class SalaryRepository implements SalaryInterface
{
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data = Salary::create([
            'staff_id' => $request_data->staff_id,
            'amount' =>  $request_data->amount,
            'date' =>  $request_data->date,
            'month' =>  $request_data->month,
            'year' =>  $request_data->year,
            'type' =>  $request_data->type,
        ]);

        /* Send Notifications to Staff and Admin */
        $staff = User::find($request_data->staff_id);
        $admins = User::admin()->get();

        $details = [
            'subject' => "Salary Disbursed for the $data->month / $data->year",
            'message' => "Dear $staff->name, your salary for the month: $data->month / $data->year has been disbursed.
            Please collect the cheque from accounts department"
        ];

        Notification::send($staff, new SalaryDisburseNotification($details));
        Notification::send($admins, new SalaryDisburseNotification($details));

        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */

    public function all()
    {
        $data = Salary::latest('id')
        ->with(['staff:id,name,email,phone'])
        ->get();
        return $data;
    }

    /*
    * @return mixed|void
    */

    public function allPaginate($perPage)
    {
        $data = Salary::latest('id')
        ->when(request('search'), function($query){
            $query->where('amount', 'like', '%'.request('search').'%')
                ->orWhere('month', 'like', '%'.request('search').'%')
                ->orWhere('year', 'like', '%'.request('search').'%');
        })
        ->with(['staff:id,name,email,phone'])
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */

    public function show($id)
    {
        return Salary::with(['staff:id,name,email,phone'])->findOrFail($id);
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = $this->show($id);
        $data->update([
            'staff_id' => $request_data->staff_id,
            'amount' =>  $request_data->amount,
            'date' =>  $request_data->date,
            'month' =>  $request_data->month,
            'year' =>  $request_data->year,
            'type' =>  $request_data->type,
        ]);

        /* Send Notifications to Staff and Admin */
        $staff = User::find($request_data->staff_id);
        $admins = User::admin()->get();

        $details = [
            'subject' => "Salary Disbursed for the $data->month / $data->year",
            'message' => "Dear $staff->name, your salary for the month: $data->month / $data->year has been disbursed.
            Please collect the cheque from accounts department"
        ];

        Notification::send($staff, new SalaryDisburseNotification($details));
        Notification::send($admins, new SalaryDisburseNotification($details));

        return $data;
    }

    public function delete($id)
    {
        $data = Salary::findOrFail($id);
        $data->delete();
        return true;
    }
}
