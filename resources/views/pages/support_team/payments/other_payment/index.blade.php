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
                                <h3 class="card-title">Payment Lists</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Payment Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                       $total = 0; 
                                    @endphp
                                    @if ($other_payments->count())
                                        @foreach ($other_payments as $key => $value)
                                            @php
                                                $total += $value->amount;
                                            @endphp
                                            <tr>
                                                <td>{{ ($other_payments->currentPage()-1) * $other_payments->perPage() + $key +1  }}</td>
                                                <td>{{ $value->name??'-' }}</td>
                                                <td>{{ $value->paymentType->name??'-' }}</td>
                                                <td>{{ $value->description??'-' }}</td>
                                                <td>{{ $value->amount??'-' }} &nbsp; .BDT</td>
                                                <td>{{ $value->created_at??'-' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-dark">
                                            <td class="text-right" colspan="4">Total</td>
                                            <td class="" colspan="5">{{ $total }} &nbsp; .BDT</td>
                                        </tr>
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
                            {{-- {{ $other_payments->links() }} --}}
                            @php
                                $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                            @endphp
                            @if ($other_payments->lastPage() > 1)
                            <nav aria-label="Page navigation example mt-4">
                               <ul class="pagination">
                                  <li class="page-item {{ ($other_payments->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $other_payments->url(1) }}">First</a>
                                     </li>
                                  @for ($i = 1; $i <= $other_payments->lastPage(); $i++)
                                        <?php
                                        $half_total_links = floor($link_limit / 2);
                                        $from = $other_payments->currentPage() - $half_total_links;
                                        $to = $other_payments->currentPage() + $half_total_links;
                                        if ($other_payments->currentPage() < $half_total_links) {
                                           $to += $half_total_links - $other_payments->currentPage();
                                        }
                                        if ($other_payments->lastPage() - $other_payments->currentPage() < $half_total_links) {
                                           $from -= $half_total_links - ($other_payments->lastPage() - $other_payments->currentPage()) - 1;
                                        }
                                        ?>
                                        @if ($from < $i && $i < $to)
                                           <li class="page-item {{ ($other_payments->currentPage() == $i) ? ' active' : '' }}">
                                              <a class="page-link" href="{{ $other_payments->url($i) }}">{{ $i }}</a>
                                           </li>
                                        @endif
                                  @endfor
                                  <li class="page-item {{ ($other_payments->currentPage() == $other_payments->lastPage()) ? ' disabled' : '' }}">
                                        <a  class="page-link" href="{{ $other_payments->url($other_payments->lastPage()) }}">Last</a>
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
    