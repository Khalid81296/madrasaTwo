@extends('layouts.master')
@section('page_title', $page_title)

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">{{ $page_title }}</h3>
                                <a href="{{ route('student_assynment.create') . '?assy_id=' . $assynment->id}}" class="btn btn-primary">Create assynment</a>
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
                                        {{-- <th>Category</th>
                                    <th>Tags</th>
                                    <th>Reporter</th> --}}
                                        <th>Author</th>
                                        <th>File</th>
                                        <th style="width: 130px">Submitted Date</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($assynments->count())
                                        @foreach ($assynments as $key => $assynment)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    {{ $assynment->assynment->title }}
                                                </td>
                                                <td>{{ $assynment->assynment->description }}</td>
                                                <td>{{ $assynment->user ? $assynment->user->name :'-' }}</td>
                                                <td>
                                                    <a target="_blank" class="btn btn-success" href="{{ asset($assynment->file) }}">Show</a>

                                                </td>
                                                <td style="width: 130px">{{ $assynment->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="d-flex">

                                                    <a href="{{ route('student_assynment.show', [$assynment->id]) }}"
                                                        class="btn btn-sm btn-success mr-1">
                                                        Show
                                                    </a>

                                                    {{-- <a href="{{ route('assynment.edit', [$assynment->id]) }}"
                                                        class="btn btn-sm btn-primary mr-1">
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('assynment.destroy', [$assynment->id]) }}"
                                                        class="mr-1" method="assynment">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger"> Delete </button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h5 class="text-center">No assynments found.</h5>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $assynments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
