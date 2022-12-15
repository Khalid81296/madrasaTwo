@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>Create Others Income</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required>
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
                        <option value="{{ $y }}">{{ ($y) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group {{ $errors->has('entry_month_id') ? 'has-error' : '' }}">
                <label for="entry_month_id">Entry Month*</label>
                    <select class="form-control select-search" name="entry_month_id" id="entry_month_id">
                        <option value="">Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
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
                <label for="mobile_no">Mobile No*</label>
                <input type="text" id="mobile_no" name="mobile_no" class="form-control" required>
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