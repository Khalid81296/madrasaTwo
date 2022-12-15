@extends('layouts.master')
@section('page_title', 'Income Details ')
@section('content')

<div class="card">
    <div class="card-header row">
        <div class="col-md-10"><h3>Details </h3></div>
        <div class="float: right">
            {{-- <a href="{{ route('incomes.receipt', Qs::hash($income->id)) }}"><input class="btn btn-primary" type="button"  value="Print Invoice" /></a> --}}
            <a href="#"><input class="btn btn-primary" type="button"  value="Print Invoice" /></a>
        </div>

    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $payment->id ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Income Category
                        </th>
                        <td>
                            {{ $payment->badrin->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date
                        </th>
                         <td>
                            {{ date( 'Y-m-d', strtotime($payment->entry_date)) ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount
                        </th>
                        <td>
                            {{ $payment->amt_paid ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                Back To List
            </a>
        </div>


    </div>
</div>
@endsection