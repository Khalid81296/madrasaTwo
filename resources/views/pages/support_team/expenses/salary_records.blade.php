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
                                <h3 class="card-title">Salary Lists</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Salary</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                       $total = 0; 
                                    @endphp
                                    @if ($users->count())
                                        @foreach ($users as $key => $value)
                                            @php
                                                $total += $value->amt_paid;
                                            @endphp
                                            <tr id="sl_{{ $value->id }}">
                                                <td>{{ ($users->currentPage()-1) * $users->perPage() + $key +1  }}</td>
                                                <td>{{ $value->name??'-' }}</td>
                                                    @if ($value->salaries != null)
                                                        <td id="designation">
                                                            <input readonly type="text" class="text-black  border-danger form-control border-0" name="designation" value="{{ $value->salaries->designation??'-' }}" placeholder="Enter Designation">
                                                        </td>
                                                        <td id="amount">
                                                            {{-- {{ number_format($value->salaries->amount, 2)??'-' }} &nbsp; BDT. --}}
                                                            <input readonly type="number" class="form-control border-danger border-0"  name="salary" value="{{ $value->salaries->amount??'-' }}">
                                                        </td>
                                                        <td id="action" class="d-flex">
                                                            <a onclick="editSalary('{{ $value->id }}')" class="btn btn-sm btn-success text-white">
                                                                <i class="icon-pen"></i> Edit
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td id="designation"><input type="text" class="form-control border-danger" name="designation" placeholder="Enter Designation"></td>
                                                        <td id="amount"><input type="number" class="form-control border-danger"  name="salary" placeholder="Enter salar amount"></td>
                                                        <td id="action" class="d-flex">
                                                            <a onclick="updateSalary('{{ $value->id }}')" class="btn btn-sm btn-success text-white">
                                                                <i class="icon-add"></i> Add
                                                            </a>
                                                        </td>
                                                    @endif
                                                {{-- <td class="d-flex">
                                                    <a target="_blank" href="{{ route('payments.receipts', Qs::hash($value->pr_id)) }}" class="btn btn-sm btn-success">
                                                        <i class="icon-printer"></i> Show
                                                    </a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h5 class="text-center">No Record found.</h5>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            {{-- {{ $users->links() }} --}}
                            @php
                                $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                            @endphp
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
                </div>
            </div>
        </div>
    </div>
   
@endsection
@section('scripts')
    @include('components.Ajax')
    <script>
        function editSalary(id){
            // $('[disabled]').removeAttr('disabled');
            $('#sl_'+id + ' #designation input').removeAttr('readonly').removeClass('border-0');
            $('#sl_'+id + ' #amount input').removeAttr('readonly').removeClass('border-0');
            $('#sl_'+id + ' #action').html('<a onclick="updateSalary('+id+')" class="btn btn-sm btn-success mr-1 text-white"><i class="icon-add"></i> Update</ahref=><a onclick="cancelEdit('+id+')" class="btn btn-sm btn-danger text-white"><i class="icon-add"></i> Cancel</a>');
            console.log(id);
        }
        function cancelEdit(id){
            $('#sl_'+id + ' #designation input').attr('readonly', true).addClass('border-0');
            $('#sl_'+id + ' #amount input').attr('readonly', true).addClass('border-0');
            $('#sl_'+id + ' #action').html('<a onclick="editSalary('+id+')" class="btn btn-sm btn-success text-white"> <i class="icon-pen"></i> Edit </a>');
            console.log(id);
        }
        function updateSalary(id){
            var designation = $('#sl_'+id + ' #designation input').val();
            var amount = $('#sl_'+id + ' #amount input').val();
            var params = $.extend({}, doAjax_params_default);
                params['url'] = "{{ url('updateSalary')}}/" + id;
                params['requestType'] = "POST";
                params['data'] = {
                    designation : designation,
                    amount : amount,
                    user_id : id,
                };
                params['successCallbackFunction'] = success;
                params['errorCallBackFunction'] = error;
                if (confirm("Are you sure you want to update this information from database?") == true) {
                    doAjax(params);
                }
            function success(data){
                console.log(data);
            }
            function error(data){
                console.log(data);
            }

            $('#sl_'+id + ' #designation input').attr('readonly', true).addClass('border-0');
            $('#sl_'+id + ' #amount input').attr('readonly', true).addClass('border-0');
            $('#sl_'+id + ' #action').html('<a onclick="editSalary('+id+')" class="btn btn-sm btn-success text-white"> <i class="icon-pen"></i> Edit </a>');
            // console.log(id);
        }

    </script>
@endsection
