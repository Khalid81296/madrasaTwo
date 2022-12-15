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
                                <h3 class="card-title">{{ $page_title }}</h3>
                                <a href="{{ route('notice.index') }}" class="btn btn-primary">Go Back to Assynment
                                    List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-pimary">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px">File</th>
                                        <td>
                                            <a target="_blank" class="btn btn-success"
                                                href="{{ asset($notice->file) }}">Show</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Title</th>
                                        <td>{{ $notice->title ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">description</th>
                                        <td>{{ $notice->description ?? '-' }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th style="width: 200px">Teacher</th>
                                        <td>{{ $notice->user ? $notice->user->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Author</th>
                                        <td>{{ $notice->user ? $notice->user->name : '-' }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th style="width: 200px">created_at</th>
                                        <td>{{ $notice->created_at ?? '-' }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th style="width: 200px">Class</th>
                                        <td>{{ $notice->my_class->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">subject</th>
                                        <td>{{ $notice->subject->name ?? '-' }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
