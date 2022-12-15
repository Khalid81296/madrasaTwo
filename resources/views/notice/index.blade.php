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
                                        <th>File</th>
                                        <th style="width: 130px">Created Date</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($notices->count())
                                        @foreach ($notices as $key => $notice)
                                            <tr>
                                                <td>{{ $notice->id }}</td>
                                                <td>
                                                    {{ $notice->description }}
                                                </td>
                                                <td>{{ $notice->title }}</td>
                                                <td>{{ $notice->user ? $notice->user->name :'-' }}</td>
                                                <td>
                                                    <a target="_blank" class="btn btn-success" href="{{ asset($notice->file) }}">Show</a>

                                                </td>
                                                <td style="width: 130px">{{ $notice->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="d-flex">

                                                    <a href="{{ route('notice.show', [$notice->id]) }}"
                                                        class="btn btn-sm btn-success mr-1">
                                                        Show
                                                    </a>
                                                    @if (Auth::user()->user_type != 'student')
                                                    <a href="{{ route('notice.edit', [$notice->id]) }}"
                                                        class="btn btn-sm btn-primary mr-1">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('notice.destroy', [$notice->id]) }}"
                                                        class="mr-1" method="notice">
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
                                                <h5 class="text-center">No notices found.</h5>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $notices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
