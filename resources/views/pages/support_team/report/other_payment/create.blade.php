@extends('layouts.master')
@section('page_title', 'Create Payment')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Create Payment</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="" method="post" action="{{ route('other_payment.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="name" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Abdul Karim">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_type_id" class="col-lg-3 col-form-label font-weight-semibold">Payment Purpose </label>
                            <div class="col-lg-9">
                                <select class="form-control select-search" name="payment_type_id" id="payment_type_id">
                                    <option value="">---- select one ----</option>
                                    @foreach($payment_types as $c)
                                        <option {{ old('my_class_id') == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="method" class="col-lg-3 col-form-label font-weight-semibold">Payment Method</label>
                            <div class="col-lg-9">
                                <select class="form-control select" name="method" id="method">
                                    <option selected value="Cash">Cash</option>
                                    <option disabled value="Online">Online</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-lg-3 col-form-label font-weight-semibold">Amount (<i>BDT.</i>) <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" value="{{ old('amount') }}" required name="amount" id="amount" type="number">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-lg-3 col-form-label font-weight-semibold">Description</label>
                            <div class="col-lg-9">
                                <input class="form-control" value="{{ old('description') }}" name="description" id="description" type="text">
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="submit" class="btn btn-primary" value="Pay" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Payment Create Ends--}}

@endsection
