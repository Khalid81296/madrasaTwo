@extends('layouts.master')
@section('page_title', $page_title)

@section('content')
<!-- Content Header (Page header) -->
{{-- <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create notice</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notice.index') }}">notice list</a></li>
                    <li class="breadcrumb-item active">Create notice</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div> --}}
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create notice</h3>
                            <a href="{{ route('notice.index') }}" class="btn btn-primary">Go Back to notice List</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <form  action="{{ route('notice.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        {{-- @include('includes.errors') --}}
                                        <div class="form-group">
                                            <label for="group_id">Notice For</label>
                                            <select class="form-control select-search" name="group_id" id="group_id">
                                                <option value="">Select Group</option>
                                                <option value="1">Teachers</option>
                                                <option value="2">Students</option>
                                                <option value="3">Others</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Notice Title</label>
                                            <input type="name" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control"
                                                placeholder="Enter description">{{ old('description') }}</textarea>
                                        </div>
                                    
                                        <div class="tile-body">
                                            <div class="row">
                                                {{-- <div class="col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="fimage" style="width: 80px; height: auto;">
                                                </div> --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Notice File</label>
                                                        <input value="{{ old('file') }}" class="form-control @error('file') is-invalid @enderror" type="file" name="file" onchange="loadFile(event,'ffile')"/>
                                                        @error('file')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @push('scripts')
                                        <script>
                                            loadFile = function(event, id) {
                                                var output = document.getElementById(id);
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                            };
                                        </script>
                                        @endpush
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="reporter">Reporter (Optional)</label>
                                        <input type="name" name="reporter" value="{{ old('reporter') }}" class="form-control" placeholder="Enter reporter">
                                    </div> --}}

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
     $('#group_id').change(function() {
            // alert(1);
            console.log(1);
        });
</script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/admin/css/summernote-bs4.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('/admin/js/summernote-bs4.min.js') }}"></script>
    <script>
        $('#description').summernote({
            placeholder: 'notice Description...',
            tabsize: 2,
            height: 300
        });
    </script>
    <script>
        $('.district').change(function() {
            var id = $(this).val();
            $('#upazila').empty();
            $.ajax({
                url: "",
                type: "notice",
                cache: false,
                data:{
                    id:id
                },

                success: data => {
                    $('#upazila').append(`<option value=""> --- Select upazila --- </option>`)
                    data.upazilas.forEach(upazila =>
                        $('#upazila').append(`<option value="${upazila.id}">${upazila.bn_name}</option>`)
                    )
                }
            });
        });
    </script>
@endsection
