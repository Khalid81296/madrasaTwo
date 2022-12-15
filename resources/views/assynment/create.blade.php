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
                            <a href="{{ route('assynment.index') }}" class="btn btn-primary">Go Back to assynment List</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <form  action="{{ route('assynment.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        {{-- @include('includes.errors') --}}
                                        <div class="form-group">
                                            <label for="title">Assynment Title</label>
                                            <input type="name" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control"
                                                placeholder="Enter description">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="my_class_id">Class: <span class="text-danger">*</span></label>
                                            <select onchange="getClassSubjects(this.value)" data-placeholder="Choose..." name="my_class_id" id="my_class_id" class="select-search form-control">
                                                <option value=""></option>
                                                @foreach($my_classes as $c)
                                                    <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject_id" class="col-form-label font-weight-bold">Subject:</label>
                                            <select id="subject_id" name="subject_id" data-placeholder="Select Class First" class="form-control select-search">
                                              @if($selected)
                                                    @foreach($subjects->where('my_class_id', $my_class_id) as $s)
                                                        <option {{ $subject_id == $s->id ? 'selected' : '' }} value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                  @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="sub_date" class="col-form-label font-weight-bold">Last Submit Date:</label>
                                            <input name="sub_date" value="{{ old('sub_date') }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                                        </div>
                                        <div class="tile-body">
                                            <div class="row">
                                                {{-- <div class="col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="fimage" style="width: 80px; height: auto;">
                                                </div> --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">assynment File</label>
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
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/admin/css/summernote-bs4.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('/admin/js/summernote-bs4.min.js') }}"></script>
    <script>
        $('#description').summernote({
            placeholder: 'assynment Description...',
            tabsize: 2,
            height: 300
        });
        flash({msg : 'Download in Progress', type : 'info'});
    </script>
@endsection
