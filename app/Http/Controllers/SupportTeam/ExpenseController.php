<?php

namespace App\Http\Controllers\SupportTeam;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    public function index()
    {
        $expensesd = Expense::all();

        return view('pages.support_team.admin.expenses.index', compact('expensesd'));
    }

    public function create()
    {

        $data['total_salary'] = DB::table('salaries')->sum('amount');
        $data['expense_categories'] = ExpenseCategory::all()->pluck('name', 'id')->prepend('Please Select','');

        return view('pages.support_team.admin.expenses.create')->with($data);
    }

    public function store(StoreExpenseRequest $request)
    {
        // return $request;
        $expense = Expense::create($request->all());

        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        $expense_categories = ExpenseCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $expense->load('expense_category', 'created_by');

        return view('pages.support_team.admin.expenses.edit', compact('expense_categories', 'expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->route('expenses.index');
    }

    public function show(Expense $expense)
    {
        $expense->load('expense_category', 'created_by');

        return view('pages.support_team.admin.expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseRequest $request)
    {
        Expense::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
