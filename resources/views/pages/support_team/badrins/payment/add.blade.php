@extends('layouts.master')
@section('page_title', 'Badrins Payment')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>Create Badrins Payment</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('badrinPayment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('entry_month_id') ? 'has-error' : '' }}">
                <label for="entry_month_id">Entry Month*</label>
                    <select class="form-control select-search" name="month_id" id="month_id" onchange="">
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
            <div class="form-group {{ $errors->has('income_category_id') ? 'has-error' : '' }}">
                <label for="badrin_id">Badrin Name</label>
                <select name="badrin_id" id="badrin_id" class="form-control select2">
                        <option value="">--Select Badrin Name--</option>
                    
                </select>
                @if($errors->has('badrin_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('badrin_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">Entry Date*</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required >
                @if($errors->has('entry_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('entry_date') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">Entry Year*</label>
                <input type="text" id="year" name="year" class="form-control date" value="{{Carbon\Carbon::now()->format('Y')}}" required readonly="readonly">
                @if($errors->has('entry_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('entry_date') }}
                    </em>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amt_paid">Amount*</label>
                <input type="number" id="amt_paid" name="amt_paid" class="form-control" step="0.01" required>
                @if($errors->has('amt_paid'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amt_paid') }}
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
@section('scripts')
    <script type="text/javascript">
        jQuery('select[name="month_id"]').on('change', function() {

                    console.log($('#month_id').val());

                    var monthID = jQuery(this).val();
                    jQuery("#badrin_id").after('<div class="loadersmall"></div>');

                    var url = '{{ url('/') }}/case/dropdownlist/getdependentbadrin?id=' + monthID;
                    console.log(url);

                    if (monthID) {
                        jQuery.ajax({
                            url: '{{ url('/') }}/case/dropdownlist/getdependentbadrin?id=' + monthID,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                jQuery('select[name="badrin_id"]').html(
                                    '<div class="loadersmall"></div>');

                                jQuery('select[name="badrin_id"]').html(
                                    '<option value="">--Select Badrin Name --</option>');
                                jQuery.each(data, function(key, value) {
                                    jQuery('select[name="badrin_id"]').append(
                                        '<option value="' + key +
                                        '">' + value + '</option>');
                                });
                                jQuery('.loadersmall').remove();
                            }
                        });
                    // alert(url);
                    } else {
                        $('select[name="badrin_id"]').empty();
                    }
                });
    </script>
@endsection
