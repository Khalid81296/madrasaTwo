@extends('layouts.master')
@section('page_title', 'Other Income Edit ')
@section('content')

<div class="card">
    <div class="card-header">
        EDIT
    </div>

    <div class="card-body">
        <form action="{{ route('incomes.update', [$income->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('income_category_id') ? 'has-error' : '' }}">
                <label for="income_category">Income Category</label>
                <select name="income_category_id" id="income_category" class="form-control select2">
                    @foreach($income_categories as $id => $income_category)
                        <option value="{{ $id }}" {{ (isset($income) && $income->income_category ? $income->income_category->id : old('income_category_id')) == $id ? 'selected' : '' }}>{{ $income_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('income_category_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('income_category_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">Entry Date*</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{ old('entry_date', isset($income) ? $income->entry_date : '') }}" required>
                @if($errors->has('entry_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('entry_date') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">Amount*</label>
                <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($income) ? $income->amount : '') }}" step="0.01" required>
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('entry_month_id') ? 'has-error' : '' }}">
                <label for="entry_month_id">Entry Month*</label>
                    <select class="form-control select-search" name="entry_month_id" id="entry_month_id">
                        <option value="">Select Month</option>
                        <option value="1"<?=$income->entry_month_id == '1' ? ' selected="selected"' : '';?>>January</option>
                        <option value="2"<?=$income->entry_month_id == '2' ? ' selected="selected"' : '';?>>February</option>
                        <option value="3"<?=$income->entry_month_id == '3' ? ' selected="selected"' : '';?>>March</option>
                        <option value="4"<?=$income->entry_month_id == '4' ? ' selected="selected"' : '';?>>April</option>
                        <option value="5"<?=$income->entry_month_id == '5' ? ' selected="selected"' : '';?>>May</option>
                        <option value="6"<?=$income->entry_month_id == '6' ? ' selected="selected"' : '';?>>June</option>
                        <option value="7"<?=$income->entry_month_id == '7' ? ' selected="selected"' : '';?>>July</option>
                        <option value="8"<?=$income->entry_month_id == '8' ? ' selected="selected"' : '';?>>August</option>
                        <option value="9"<?=$income->entry_month_id == '9' ? ' selected="selected"' : '';?>>September</option>
                        <option value="10"<?=$income->entry_month_id == '10' ? ' selected="selected"' : '';?>>October</option>
                        <option value="11"<?=$income->entry_month_id == '11' ? ' selected="selected"' : '';?>>November</option>
                        <option value="12"<?=$income->entry_month_id == '12' ? ' selected="selected"' : '';?>>December</option>
                    </select>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">Name</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($income) ? $income->description : '') }}">
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                <label for="mobile_no">Mobile</label>
                <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="{{ old('mobile_no', isset($income) ? $income->mobile_no : '') }}">
                @if($errors->has('mobile_no'))
                    <em class="invalid-feedback">
                        {{ $errors->first('mobile_no') }}
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