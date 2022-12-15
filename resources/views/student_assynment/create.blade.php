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
                            <a href="{{ route('student_assynment.index').'?assy_id='.$assynment->id }}" class="btn btn-primary">Go Back to assynment List</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
                                <form  action="{{ route('student_assynment.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="assy_id" value="{{ $assynment->id }}">
                                    <div class="card-body">
                                        {{-- @include('includes.errors') --}}
                                        <div class="form-group">
                                            <label for="title">Assynment Title</label>
                                            <input type="name" name="title" value="{{ old('title') ?? $assynment->title }}" class="form-control" placeholder="Enter title">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control"
                                                placeholder="Enter description">{{ old('description') ?? $assynment->description }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="my_class_id">Class: <span class="text-danger">*</span></label>
                                            <select onchange="getClassSubjects(this.value)" data-placeholder="Choose..." name="my_class_id" id="my_class_id" class="select-search form-control">
                                                <option value="{{ $assynment->my_class_id }}">{{ $assynment->my_class->name }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject_id" class="col-form-label font-weight-bold">Subject:</label>
                                            <select readonly id="subject_id" name="subject_id" data-placeholder="Select Class First" class="form-control select-search">
                                                <option value="{{ $assynment->subject_id }}">{{ $assynment->subject->name }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject_id" class="col-form-label font-weight-bold">Message:</label>
                                            <textarea id="message" name="message" class="form-control"></textarea>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="sub_date" class="col-form-label font-weight-bold">Last Submit Date:</label>
                                            <input name="sub_date" value="{{ old('sub_date') ?? date('m/d/Y', strtotime($assynment->sub_date)); }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                                        </div> --}}
                                        <div class="tile-body">
                                            <div class="row">
                                                {{-- <div class="col-3">
                                                        <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="fimage" style="width: 80px; height: auto;">
                                                </div> --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Assynment File</label>
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
