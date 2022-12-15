{{-- @extends('layouts.default') --}}
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
      {{-- @include('messages.inc.search') --}}
      <div class="overflow-auto">
      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">Name</th>
               <th scope="col">User</th>
               <th scope="col">User Role</th>
               {{-- <th scope="col">অফিসের নাম</th> --}}
               <th scope="col">Email</th>
               <th scope="col">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($users as $row)
                @if ($row->id != Auth::user()->id)
                    <tr>
                        {{-- <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th> --}}
                        <th scope="row" class="tg-bn">
                            @if ($row->profile_pic != null)
                            <div class="symbol symbol-circle symbol-40">
                                <img alt="Pic" src="{{ url('/') }}/uploads/profile/{{ $row->profile_pic }}"/>
                                {{-- <i class="symbol-badge bg-primary"></i> --}}
                            </div>
                           @else
                           @php
                              $str = $row->username;
                           @endphp
                            <div class="symbol symbol-circle symbol-40">
                                <span class="symbol-label bg-danger font-size-h4 text-capitalize text-light">{{ substr($str, 0, 1) }}</span>
                            </div>
                           @endif
                        </th>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->user_type }}</td>
                        {{-- <td>{{ $row->office_name_bn }}, {{ $row->upazila_name_bn }} {{ $row->district_name_bn }}</td> --}}
                        <td>{{ $row->email }}</td>
                        <td>
                            <a href="{{ route('messages_single', Qs::hash($row->id)) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">Message</a>
                        </td>
                    </tr>
                @endif
            @endforeach
         </tbody>
      </table>
    </div>
      {{-- {!! $users->links() !!} --}}
            <?php
      // config
      $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
      ?>

      @if ($users->lastPage() > 1)
      <nav aria-label="Page navigation example mt-4">
         <ul class="pagination">
            <li class="page-item {{ ($users->currentPage() == 1) ? ' disabled' : '' }}">
                  <a class="page-link" href="{{ $users->url(1) }}">First</a>
               </li>
            @for ($i = 1; $i <= $users->lastPage(); $i++)
                  <?php
                  $half_total_links = floor($link_limit / 2);
                  $from = $users->currentPage() - $half_total_links;
                  $to = $users->currentPage() + $half_total_links;
                  if ($users->currentPage() < $half_total_links) {
                     $to += $half_total_links - $users->currentPage();
                  }
                  if ($users->lastPage() - $users->currentPage() < $half_total_links) {
                     $from -= $half_total_links - ($users->lastPage() - $users->currentPage()) - 1;
                  }
                  ?>
                  @if ($from < $i && $i < $to)
                     <li class="page-item {{ ($users->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                     </li>
                  @endif
            @endfor
            <li class="page-item {{ ($users->currentPage() == $users->lastPage()) ? ' disabled' : '' }}">
                  <a  class="page-link" href="{{ $users->url($users->lastPage()) }}">Last</a>
            </li>
         </ul>
      </nav>
      @endif

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


