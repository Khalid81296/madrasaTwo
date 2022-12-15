@extends('layouts.master')
@section('page_title', $page_title)

@section('content')
<!-- Content Header (Page header) -->
{{-- <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create SMS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sms.index') }}">sms list</a></li>
                    <li class="breadcrumb-item active">Create sms</li>
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
                            <h3 class="card-title">Create sms</h3>
                            <a href="{{ route('sms.index') }}" class="btn btn-primary">Go Back to SMS List</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <form  action="{{ route('sms.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        {{-- @include('includes.errors') --}}
                                        <div class="form-group">
                                            <label for="group_id">SMS For</label>
                                            <select class="form-control select-search" name="group_id" id="group_id">
                                                <option value="">Select Group</option>
                                                <option value="1">Teachers</option>
                                                <option value="2">Students</option>
                                                <option value="3">Badrin</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="class_type" style="display: none;">
                                            <label for="my_class">Class <span class="text-danger">*</span></label>
                                            <select class="form-control select-search" name="my_class" id="my_class">
                                                <option value="">Select Class</option>
                                                @foreach($my_classes as $c)
                                                    <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">SMS Title</label>
                                            <input type="name" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control"
                                                placeholder="Enter description">{{ old('description') }}</textarea>
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
        var type = $(this).find(":selected").val();
        if(type == 2){
            $('#class_type').show()
        }else{
            $('#class_type').hide()
        }
            // alert(type);
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
