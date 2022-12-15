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
                                <h3 class="card-title">Payment List</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Ref. No</th>
                                        <th>Title</th>
                                        <th>Amount</th>
                                        <th style="width: 130px">Payment Date</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                       $total = 0; 
                                    @endphp
                                    @if ($SingleReceipt->count())
                                        @foreach ($SingleReceipt as $key => $notice)
                                            @php
                                                $total += $notice->amt_paid;
                                            @endphp
                                            <tr>
                                                <td>{{ $notice->id }}</td>
                                                <td>{{ $notice->pr->ref_no??'-' }}</td>
                                                <td>
                                                    {{ $notice->pr->singlePayment->title ?? '-' }}
                                                </td>
                                                <td>{{ $notice->amt_paid }}</td>
                                                <td style="width: 130px">
                                                    {{ $notice->created_at ? $notice->created_at->format('d M, Y') : '-' }}
                                                </td>
                                                <td class="d-flex">
                                                    <a target="_blank" href="{{ route('payments.receipts', Qs::hash($notice->pr_id)) }}" class="btn btn-sm btn-success">
                                                        <i class="icon-printer"></i> Show
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($Receipt as $key => $notice)
                                            @php
                                                $total += $notice->amt_paid;
                                            @endphp
                                            <tr>
                                                <td>{{ $notice->id }}</td>
                                                <td>{{ $notice->pr->ref_no??'-' }}</td>
                                                <td>
                                                    {{ $notice->pr->payment->title ?? '-' }}
                                                </td>
                                                <td>{{ $notice->amt_paid }}</td>
                                                <td style="width: 130px">
                                                    {{ $notice->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="d-flex">
                                                    <a target="_blank" href="{{ route('payments.receipts', Qs::hash($notice->pr_id)) }}" class="btn btn-sm btn-success">
                                                        <i class="icon-printer"></i> Show
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h5 class="text-center">No Receipt found.</h5>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($total != 0)
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total: {{ $total }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            {{-- {{ $SingleReceipt->links() }} --}}
                            @php
                                $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                            @endphp
                            @if ($SingleReceipt->lastPage() > 1)
                            <nav aria-label="Page navigation example mt-4">
                               <ul class="pagination">
                                  <li class="page-item {{ ($SingleReceipt->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $SingleReceipt->url(1) }}">First</a>
                                     </li>
                                  @for ($i = 1; $i <= $SingleReceipt->lastPage(); $i++)
                                        <?php
                                        $half_total_links = floor($link_limit / 2);
                                        $from = $SingleReceipt->currentPage() - $half_total_links;
                                        $to = $SingleReceipt->currentPage() + $half_total_links;
                                        if ($SingleReceipt->currentPage() < $half_total_links) {
                                           $to += $half_total_links - $SingleReceipt->currentPage();
                                        }
                                        if ($SingleReceipt->lastPage() - $SingleReceipt->currentPage() < $half_total_links) {
                                           $from -= $half_total_links - ($SingleReceipt->lastPage() - $SingleReceipt->currentPage()) - 1;
                                        }
                                        ?>
                                        @if ($from < $i && $i < $to)
                                           <li class="page-item {{ ($SingleReceipt->currentPage() == $i) ? ' active' : '' }}">
                                              <a class="page-link" href="{{ $SingleReceipt->url($i) }}">{{ $i }}</a>
                                           </li>
                                        @endif
                                  @endfor
                                  <li class="page-item {{ ($SingleReceipt->currentPage() == $SingleReceipt->lastPage()) ? ' disabled' : '' }}">
                                        <a  class="page-link" href="{{ $SingleReceipt->url($SingleReceipt->lastPage()) }}">Last</a>
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
