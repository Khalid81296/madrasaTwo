@extends('layouts.master')
@section('page_title', 'Expense Edit ')
@section('content')

<div class="card">
    <div class="card-header">
        EDIT
    </div>

    <div class="card-body">
        <form action="{{ route("expenses.update", [$expense->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('expense_category_id') ? 'has-error' : '' }}">
                <label for="expense_category">Expense Category</label>
                <select name="expense_category_id" id="expense_category" class="form-control select2">
                    @foreach($expense_categories as $id => $expense_category)
                        <option value="{{ $id }}" {{ (isset($expense) && $expense->expense_category ? $expense->expense_category->id : old('expense_category_id')) == $id ? 'selected' : '' }}>{{ $expense_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('expense_category_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('expense_category_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">Entry Date *</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{ old('entry_date', isset($expense) ? $expense->entry_date : '') }}" required>
                @if($errors->has('entry_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('entry_date') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('entry_year') ? 'has-error' : '' }}">
                <label for="entry_year">Entry Year*</label>
                <select data-placeholder="Select Year" required name="entry_year" id="entry_year" class="select-search form-control" required="required">
                        <option value="">Select Year</option>
                    @for($y=date('Y', strtotime('- 5 years')); $y<=date('Y', strtotime('+ 1 years')); $y++)
                        <option value="{{ $y }}" <?=$expense->entry_year == $y ? ' selected="selected"' : '';?>>{{ ($y) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group {{ $errors->has('entry_month_id') ? 'has-error' : '' }}">
                <label for="entry_month_id">Entry Month*</label>
                    <select class="form-control select-search" name="entry_month_id" id="entry_month_id">
                        <option value="">Select Month</option>
                        <option value="1"<?=$expense->entry_month_id == '1' ? ' selected="selected"' : '';?>>January</option>
                        <option value="2"<?=$expense->entry_month_id == '2' ? ' selected="selected"' : '';?>>February</option>
                        <option value="3"<?=$expense->entry_month_id == '3' ? ' selected="selected"' : '';?>>March</option>
                        <option value="4"<?=$expense->entry_month_id == '4' ? ' selected="selected"' : '';?>>April</option>
                        <option value="5"<?=$expense->entry_month_id == '5' ? ' selected="selected"' : '';?>>May</option>
                        <option value="6"<?=$expense->entry_month_id == '6' ? ' selected="selected"' : '';?>>June</option>
                        <option value="7"<?=$expense->entry_month_id == '7' ? ' selected="selected"' : '';?>>July</option>
                        <option value="8"<?=$expense->entry_month_id == '8' ? ' selected="selected"' : '';?>>August</option>
                        <option value="9"<?=$expense->entry_month_id == '9' ? ' selected="selected"' : '';?>>September</option>
                        <option value="10"<?=$expense->entry_month_id == '10' ? ' selected="selected"' : '';?>>October</option>
                        <option value="11"<?=$expense->entry_month_id == '11' ? ' selected="selected"' : '';?>>November</option>
                        <option value="12"<?=$expense->entry_month_id == '12' ? ' selected="selected"' : '';?>>December</option>
                    </select>
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">Amount *</label>
                <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}" step="0.01" required>
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($expense) ? $expense->description : '') }}">
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="Save">
            </div>
        </form>


    </div>
</div>
@endsection