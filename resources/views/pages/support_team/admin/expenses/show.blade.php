@extends('layouts.master')
@section('page_title', 'Expense Details ')
@section('content')

<div class="card">
    <div class="card-header">
        Show
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
                            {{ $expense->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Expense Category
                        </th>
                        <td>
                            {{ $expense->expense_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Entry Date
                        </th>
                        <td>
                            {{ $expense->entry_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount
                        </th>
                        <td>
                            ${{ $expense->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Description
                        </th>
                        <td>
                            {{ $expense->description }}
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