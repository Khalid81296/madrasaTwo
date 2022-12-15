@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Post</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('website') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Post list</a></li>
                    <li class="breadcrumb-item active">Edit Post</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Edit Post - {{ $post->name }}</h3>
                            <a href="{{ route('post.index') }}" class="btn btn-primary">Go Back to Post List</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <div class="card-body">
                                    <form action="{{ route('post.update', [$post->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        @include('includes.errors')
                                        <div class="form-group">
                                            <label for="title">Post title</label>
                                            <input type="name" name="title" value="{{ $post->title }}" class="form-control" placeholder="Enter title">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="category">Post Category</label>

                                            <select name="category" id="category" class="form-control">
                                                <option value="" style="display: none" selected>Select Category</option>
                                                @foreach($categories as $c)
                                                <option value="{{ $c->id }}" @if($post->category_id == $c->id) selected @endif> {{ $c->name }} </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        {{-- <div class="form-group">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label for="image">Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input" id="image">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <div style="max-width: 100px; max-height: 100px;overflow:hidden; margin-left: auto">
                                                        <img src="{{ asset($post->image) }}" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-group">
                                            <label class="control-label" for="categories">Post Categories</label>
                                            <div class="flex-wrap border p-3" style="height: 200px; overflow: scroll;">
                                                @foreach($categories as $category)
                                                <div class="custom-control custom-checkbox" style="margin-right: 20px">
                                                    <input class="custom-control-input" name="categories[]" type="checkbox" id="category{{ $category->id}}" value="{{ $category->id }}" @foreach($post->categories as $cat)
                                                    @if($category->id == $cat->id) checked @endif @endforeach>
                                                    <label for="category{{ $category->id}}" class="custom-control-label">{{ $category->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label> Post Tags</label>
                                            <div class=" d-flex flex-wrap">
                                                @foreach($tags as $tag)
                                                <div class="custom-control custom-checkbox" style="margin-right: 20px">
                                                    <input class="custom-control-input" name="tags[]" type="checkbox" id="tag{{ $tag->id}}" value="{{ $tag->id }}"
                                                    @foreach($post->tags as $t)
                                                        @if($tag->id == $t->id) checked @endif
                                                    @endforeach
                                                    >
                                                    <label for="tag{{ $tag->id}}" class="custom-control-label">{{ $tag->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control"
                                                placeholder="Enter description">{{ $post->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="video">Video Link (Optional) <Small>(IF post type video than mandatory)</Small></label>
                                            <input type="name" name="video" value="{{ $post->video }}" class="form-control" placeholder="https://www.youtube.com/watch?v=SOlHkPrJBOU">
                                        </div>
                                        <div class="form-group">
                                            <label for="video">District (Optional) <Small>(IF district news)</Small></label>
                                            <select class="form-control district" name="district" id="district">
                                                    @if ($post->district_id == '')
                                                    <option value=""> {{ '--- Select district ---'}}</option>
                                                    @else
                                                    <option value="{{ $post->district_id }}"> {{ $post->district->bn_name }}</option>
                                                    <option value=""> {{ '--- Select district ---'}}</option>
                                                    @endif
                                                @foreach ($districts as $dis)
                                                    <option value="{{ $dis->id }}">{{ $dis->bn_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="video">Upazila (Optional) <Small>(IF upazila news)</Small></label>
                                            <select class="form-control" id="upazila" name="upazila" >
                                                @if ($post->upazila_id == '')
                                                <option value=""> {{ '--- Select upazila ---'}}</option>
                                                @else
                                                <option value="{{ $post->upazila_id }}"> {{ $post->upazila->bn_name }}</option>
                                                <option value=""> {{ '--- Select upazila ---'}}</option>
                                                @endif
                                                @foreach ($upazilas as $dis)
                                                    <option value="{{ $dis->id }}">{{ $dis->bn_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="tile-body">
                                            <div class="row">
                                                <div class="col-3">
                                                        <img src="{{ asset($post->image) }}" id="postImg" style="width: 80px; height: auto;">
                                                </div>
                                                <div class="col-9">
                                                    <div class="form-group">
                                                        <label class="control-label">Featured Image</label>
                                                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" onchange="loadFile(event,'postImg')"/>
                                                        @error('image')
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
                                        <div class="form-group">
                                            <label for="reporter">Reporter (Optional)</label>
                                            <input type="name" name="reporter" value="{{ old('reporter') ?? $post->reporter }}" class="form-control" placeholder="Enter reporter">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Update Post</button>
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
</div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/admin/css/summernote-bs4.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('/admin/js/summernote-bs4.min.js') }}"></script>
    <script>
        $('#description').summernote({
            placeholder: 'Hello Bootstrap 4',
            tabsize: 2,
            height: 300
        });
    </script>
    <script>
        $('.district').change(function() {
            var id = $(this).val();
            $('#upazila').empty();
            $.ajax({
                url: "{{ route('upazilas') }}",
                type: "post",
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
