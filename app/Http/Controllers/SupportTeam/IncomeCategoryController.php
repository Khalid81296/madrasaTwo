<?php

namespace App\Http\Controllers\SupportTeam;

use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeCategoryRequest;
use App\Http\Requests\StoreIncomeCategoryRequest;
use App\Http\Requests\UpdateIncomeCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::all();

        return view('pages.support_team.admin.incomeCategories.index', compact('incomeCategories'));
    }

    public function create()
    {
        return view('pages.support_team.admin.incomeCategories.create');
    }

    public function store(StoreIncomeCategoryRequest $request)
    {
        $incomeCategory = IncomeCategory::create($request->all());

        return redirect()->route('income-categories.index');
    }

    public function edit(IncomeCategory $incomeCategory)
    {
        $incomeCategory->load('created_by');

        return view('pages.support_team.admin.incomeCategories.edit', compact('incomeCategory'));
    }

    public function update(UpdateIncomeCategoryRequest $request, IncomeCategory $incomeCategory)
    {
        $incomeCategory->update($request->all());

        return redirect()->route('income-categories.index');
    }

    public function show(IncomeCategory $incomeCategory)
    {
        $incomeCategory->load('created_by');

        return view('pages.support_team.admin.incomeCategories.show', compact('incomeCategory'));
    }

    public function destroy(IncomeCategory $incomeCategory)
    {
        $incomeCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeCategoryRequest $request)
    {
        IncomeCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
