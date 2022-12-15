@extends('layouts.master')
@section('page_title', 'Badrins Payment List ')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('badrinPayment.create') }}">
                Add Badrin Payment
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        <h4>Badrins Payment List</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-button-html5-columns">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Badri Name
                        </th>
                        <th>
                            Entry Date
                        </th>
                        <th>
                            Month
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $key => $payment)

                        <tr data-entry-id="{{ $payment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $payment->id ?? '' }}
                            </td>
                            <td>
                                {{ $payment->badrin->name ?? '' }}
                            </td>
                            <td>
                                {{ date( 'Y-m-d', strtotime($payment->entry_date)) ?? '' }}
                            </td>
                            <td>
                                {{ $payment->month_name ?? '' }}
                            </td>
                            <td>
                                {{ $payment->amt_paid ?? '' }}
                            </td>
                            <td>
                                
                                    <a class="btn btn-xs btn-primary" href="{{ route('badrinPayment.show', $payment->id) }}">
                                        View
                                    </a>
                                

                                
                                    <a class="btn btn-xs btn-info" href="{{ route('badrinPayment.edit', $payment->id) }}">
                                        Edit
                                    </a>
                                

                                
                                    <form action="{{ route('badrinPayment.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-xs btn-danger" value="DELETE">
                                    </form>
                                

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="text-danger">No data found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('incomes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  // dtButtons.push(deleteButton)


  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Income:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection