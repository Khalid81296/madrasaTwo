<?php

namespace App\Http\Controllers\SupportTeam;

use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseCategoryRequest;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::all();

        return view('pages.support_team.admin.expenseCategories.index', compact('expenseCategories'));
    }

    public function create()
    {
        return view('pages.support_team.admin.expenseCategories.create');
    }

    public function store(StoreExpenseCategoryRequest $request)
    {   
        $expenseCategory = ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->load('created_by');

        return view('pages.support_team.admin.expenseCategories.edit', compact('expenseCategory'));
    }

    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return redirect()->route('expense-categories.index');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->load('created_by');

        return view('pages.support_team.admin.expenseCategories.show', compact('expenseCategory'));
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseCategoryRequest $request)
    {
        ExpenseCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
