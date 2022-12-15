@extends('layouts.master')
@section('page_title', $page_title)

@section('content')


<!--begin::Card-->
<div class="card card-custom">
   {{-- <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
      </div>
   </div> --}}
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif
      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">Name</th>
               <th scope="col">User</th>
               <th scope="col">User Type</th>
               {{-- <th scope="col">অফিসের নাম</th> --}}
               <th scope="col">Email</th>
               <th scope="col">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($msg_request as $msg)
            @php
                $Ncount = App\Models\Message::select('id')
                ->where('user_sender', $msg->user_sender)
                ->where('user_receiver', Auth::user()->id)
                ->where('receiver_seen', 0)
                ->where('msg_reqest', 1)
                ->count();
            @endphp
                <tr>
                    <th scope="row" class="tg-bn">
                        @if ($msg->sender->profile_pic != null)
                        <img style="width: 40px; border-radius: 60%;"
                           src="{{ url('/') }}/uploads/profile/{{ $msg->sender->profile_pic }}" alt="">
                        @else
                        @php
                           $str = $msg->sender->name;
                        @endphp
                           <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                        @endif
                     </th>
                    <td>{{ $msg->sender->name ?? '' }} <span class="badge badge-danger">New {{ $Ncount }}</span></td>
                    <td>{{ $msg->sender->username ?? '' }}</td>
                    <td>{{ $msg->sender->user_type ?? '' }}</td>
                    {{-- <td>{{ $msg->sender->office->office_name_bn ?? '' }}, {{ $msg->sender->office->upazila->upazila_name_bn ?? '' }} {{ $msg->sender->office->district->district_name_bn ?? '' }}</td> --}}
                    <td>{{ $msg->sender->email ?? '' }}</td>
                    <td>
                    <a href="{{ route('messages_single', Qs::hash($msg->sender->id)) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">Message</a>
                    </td>
                </tr>
            @endforeach
            {{-- @forelse($msgs as $msg)
                @php
                    $Ncount = App\Models\Message::select('id')
                    ->where('user_sender', $msg->user_receiver)
                    ->where('user_receiver', Auth::user()->id)
                    ->where('receiver_seen', 0)
                    ->count();
                @endphp
                <tr>
                    <th scope="row" class="tg-bn">
                        @if ($msg->receiver->profile_pic != null)
                        <img style="width: 40px; border-radius: 60%;"
                           src="{{ url('/') }}/uploads/profile/{{ $msg->receiver->profile_pic }}" alt="">
                        @else
                        @php
                           $str = $msg->receiver->username;
                        @endphp
                           <span class="badge badge-danger rounded-circle text-capitalize h3 mr-3">{{ substr($str, 0, 1) }}</span>
                        @endif
                     </th>
                    <td>{{ $msg->receiver->name ?? '' }} <span class="badge badge-danger">{{ $Ncount != 0 ? $Ncount : ''  }}</span></td>
                    <td>{{ $msg->receiver->username ?? '' }}</td>
                    <td>{{ $msg->receiver->role->role_name ?? '' }}</td>
                    <td>{{ $msg->receiver->office->office_name_bn ?? '' }}, {{ $msg->receiver->office->upazila->upazila_name_bn ?? '' }} {{ $msg->receiver->office->district->district_name_bn ?? '' }}</td>
                    <td>{{ $msg->receiver->email ?? '' }}</td>
                    <td>
                    <a href="{{ route('messages_single', $msg->receiver->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">বার্তা পাঠান</a>
                    </td>
                </tr>
            @empty
            @endforelse --}}
         </tbody>
      </table>
      {!! $msg_request->links() !!}
   </div>
</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


