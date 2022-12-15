@extends('layouts.master')
@section('page_title', $page_title)

@section('content')

<style>
header
{
	font-family: 'Lobster', cursive;
	text-align: center;
	font-size: 25px;
}

#info
{
	font-size: 18px;
	color: #555;
	text-align: center;
	margin-bottom: 25px;
}

a{
	color: #074E8C;
}

.scrollbar
{
	/* margin-left: 30px; */
	float: left;
	height: 300px;
	/* width: 65px; */
	width: 100%;
	/* background: #F5F5F5; */
	overflow-y: scroll;
    overflow-x: hidden;
	/* margin-bottom: 25px; */
}

.force-overflow
{
	min-height: 100%;;
}

#wrapper
{
	text-align: center;
	width: 500px;
	margin: auto;
}
#style-1::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	/* border-radius: 10px; */
	background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar
{
	width: 12px;
	height: 12px;
	background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar-thumb
{
	/* border-radius: 10px; */
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	/* background-color: #555; */
	background-color: #949494;
}

</style>
    <!--begin::Card-->
    <div class="card card-custom">
        {{-- <div class="card-header flex-wrap">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
            </div>
        </div> --}}
        <div class="card-body p-0">
            <form action="{{ route('messages_send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="receiver[]" id="user_id" value="{{ $user->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                {{-- <legend>বার্তা প্রেরণ</legend> --}}
                                <div class=" col-12 row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name" class=" form-control-label">Create Message <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="messages" id="" class="form-control form-control-sm" rows="10"></textarea>
                                            <span style="color: red">
                                                {{ $errors->first('message') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">Send</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6 ">
                            <div class="border overflow-hidden">
                                <table class="table table-hover mb-0 font-size-h6" style="">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>
                                                @if ($user->profile_pic != null)
                                                    <img style="width: 40px; border-radius: 60%;"
                                                        src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}" alt="">
                                                @else
                                                @php
                                                    $str = $user->name;
                                                @endphp
                                                <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                                                    {{-- <img style="width: 40px; border-radius: 60%;"
                                                        src="{{ url('/') }}/uploads/profile/default.jpg" alt=""> --}}
                                                @endif
                                                {{ $user->name }},
                                                <span class="text-primary">{{ $user->user_type }}</span>
                                            </th>
                                            <th><a id="refresh" class="btn btn-sm btn-primary right" >Refresh</a></th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="scrollbar" id="style-1">
                                    <div class="force-overflow">
                                        <table class="table table-hover font-size-h6 mb-0">
                                            <tbody id="tableBody">
                                                @foreach ($messages as $key => $row)
                                                    @if ($row->user_sender == Auth::user()->id)
                                                        <tr align="right">
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        @if($row->msg_remove != 1)
                                                                            {{-- @if (strlen($row->messages) < 50) --}}
                                                                            <p class="d-inline-flex"><span class="bg-primary text-light rounded-left px-2 p-1">
                                                                                {!! nl2br($row->messages) !!}
                                                                            </span></p>
                                                                            {{-- @else
                                                                            <p class="d-inline-flex bg-primary text-light rounded-left px-2 p-1">
                                                                                {{ $row->messages }}
                                                                            </p>
                                                                            @endif --}}
                                                                        @else
                                                                            <p><span class="text-muted text-light rounded border px-2 p-1">
                                                                                <em><small>Message Removed </small></em>
                                                                            </span></p>
                                                                        @endif
                                                                        <p class="h6 text-muted">
                                                                            @if($row->msg_remove != 1)
                                                                                <em><small>
                                                                                    <a class="text-muted" onclick="return confirm('Are you want to remove this message?')" href="{{ route('messages_remove', Qs::hash($row->id))}}">Remove</a>
                                                                                </small>
                                                                                </em>
                                                                                |
                                                                            @endif
                                                                            <em><small>
                                                                                {{ $row->created_at }}
                                                                            </small>
                                                                            </em>
                                                                        </p>

                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        @if (Auth::user()->profile_pic != null)
                                                                            <img style="width: 50px; border-radius: 50%;"
                                                                                src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}"
                                                                                alt="">
                                                                        @else
                                                                        @php
                                                                            $str = Auth::user()->name;
                                                                        @endphp
                                                                        <span class="badge badge-danger rounded-circle text-capitalize h1 mr-3">{{ substr($str, 0, 1) }}</span>

                                                                            {{-- <img style="width: 50px; border-radius: 50%;"
                                                                                src="{{ url('/') }}/uploads/profile/default.jpg" alt=""> --}}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-2 col-sm-2">
                                                                        @if ($user->profile_pic != null)
                                                                            <img style="width: 50px; border-radius: 50%;"
                                                                                src="{{ url('/') }}/uploads/profile/{{ $user->profile_pic }}"
                                                                                alt="">

                                                                        @else
                                                                        @php
                                                                            $str = $user->name;
                                                                        @endphp
                                                                        <span class="badge badge-danger rounded-circle text-capitalize h1 mr-3">{{ substr($str, 0, 1) }}</span>

                                                                            {{-- <img style="width: 50px; border-radius: 50%;"
                                                                                src="{{ url('/') }}/uploads/profile/default.jpg" alt=""> --}}
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-10 col-sm-10">
                                                                        @if($row->msg_remove != 1)
                                                                            {!! nl2br($row->messages) !!}
                                                                        @else
                                                                            <p><span class="text-muted text-light rounded border px-2 p-1">
                                                                                <em><small>Message Removed </small></em>
                                                                            </span></p>
                                                                        @endif
                                                                        <p class="h6 text-muted"><em><small>
                                                                            {{ $row->created_at }}</small></em>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                            <tr id="mk"></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <script>

        var pages = '{{ $messages->LastPage() }}';
        var count = 1;
        var scrollFlag = true;
        var user_id = $('#user_id').val();
        $('#style-1').scroll(function () {
            if (scrollFlag && pages > 1 && this.scrollHeight - $(this).scrollTop() - $(this).offset().top - $(this).height() <= 0) {
                $('#mk').html('<td class="text-center"><div class="loadersmall"></div></td>');
                scrollFlag = false;
                count++;
                $.ajax({
                //   url : '{{url("/")}}/messages/' + user_id +'?page=' + count,
                  url : '{{url("/")}}/messages/{{ Qs::hash($user->id) }}' +'?page=' + count,
                  type : "GET",
                  dataType : "json",
                  success:function(data)
                  {
                    setTimeout(function (){
                        console.log(count);
                        console.log('{{url("/")}}/messages/ajaxMsg/' + user_id +'?page=' + count);
                        $("#tableBody").append(data);
                        scrollFlag = true;
                        if (count >= pages) scrollFlag = false;
                        $('.loadersmall').remove();
                    }, 200);
                  }
               });

            }
        });

        //for page refresh
        $('#refresh').click(function() {
            location.reload();
        });
        //for Message scrollbar inteface change
        $(document).ready(function () {
            if (!$.browser.webkit) {
                $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
            }
        });
        //scroll from bottom
        var element = $("#style-1");
        element.scrollTop = element.scrollHeight;

    </script>
@endsection
{{-- <!--end::Page Scripts--> --}}
