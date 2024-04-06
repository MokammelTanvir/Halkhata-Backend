<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Salary;
use App\Models\User;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = [];
        $months_list = [];

        $brand_count = Brand::count();
        $category_count = Category::count();
        $product_count = Product::count();
        $customer_count = User::customer()->count();
        $supplier_count = User::supplier()->count();
        $sales_count = Order::count();

        $data['brand_count'] = $brand_count;
        $data['category_count'] = $category_count;
        $data['product_count'] = $product_count;
        $data['customer_count'] = $customer_count;
        $data['supplier_count'] = $supplier_count;
        $data['sales_count'] = $sales_count;

        /* Month wise Expense */
        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1, date('Y')));
            array_push($months_list, $month);
        }

        $data['stats'] = [];

        foreach ($months_list as $key => $month) {
            $expense = Expense::whereMonth('created_at', $key+1)->sum('amount');
            $sales = Order::whereMonth('created_at', $key+1)->sum('total');
            $salary = Salary::whereMonth('created_at', $key+2)->sum('amount');

            array_push($data['stats'], [
                'month' => $month,
                'expense' => $expense,
                'sales' => $sales,
                'salary' => $salary,
            ]);
        }

        return $this->ResponseSuccess($data);
    }

    public function getNotifications()
    {
        $user = User::find(1);
        return $this->ResponseSuccess($user->notifications);
    }
    public function markAsReadAll()
    {
        $user = User::find(1);
        $user->unreadNotifications()->update(['read_at' => now()]);
        return $this->ResponseSuccess($user->unreadNotifications);
    }
}
