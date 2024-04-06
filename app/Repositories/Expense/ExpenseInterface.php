<?php

namespace App\Repositories\Expense;

interface ExpenseInterface
{
    public function all();
    public function allExpenseCategory();
    public function allPaginate($perPage);
    public function store($data);
    public function show($id);
    public function update($data, $id);
}
