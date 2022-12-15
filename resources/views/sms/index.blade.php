@extends('layouts.master')
@section('page_title', $page_title)

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">notice List</h3>
                                @if (Auth::user()->user_type != 'student')
                                <a href="{{ route('notice.create') }}" class="btn btn-primary">Create notice</a>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th style="width: 130px">Created Date</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($smses->count())
                                        @foreach ($smses as $key => $sms)
                                            <tr>
                                                <td>{{ $sms->id }}</td>
                                                <td>
                                                    {{ $sms->description }}
                                                </td>
                                                <td>{{ $sms->title }}</td>
                                                <td>{{ $sms->user_id ? $sms->user->name :'-' }}</td>
                                                <td style="width: 130px">{{ $sms->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="d-flex">

                                                    <a href="{{ route('sms.show', [$sms->id]) }}"
                                                        class="btn btn-sm btn-success mr-1">
                                                        Show
                                                    </a>
                                                    @if (Auth::user()->user_type != 'student')
                                                    <a href="{{ route('sms.edit', [$sms->id]) }}"
                                                        class="btn btn-sm btn-primary mr-1">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('sms.destroy', [$sms->id]) }}"
                                                        class="mr-1" method="sms">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger"> Delete </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h5 class="text-center">No SMS found.</h5>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $smses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
