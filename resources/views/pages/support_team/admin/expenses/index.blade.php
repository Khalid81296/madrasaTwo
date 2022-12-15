@extends('layouts.master')
@section('page_title', 'Expence List ')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('expenses.create') }}">
               Add Expence
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        <h3>Expence List</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-button-html5-columns">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Expence Category
                        </th>
                        <th>
                            Entry Date
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expensesd as $key => $expense)
                        <tr data-entry-id="{{ $expense->id }}">
                            <td>
                                {{ $expense->id ?? '' }}
                            </td>
                            <td>
                                {{ $expense->expense_category->name }}
                            </td>
                            <td>
                                {{ date( 'Y-m-d', strtotime($expense->entry_date)) }}
                            </td>
                            <td>
                                {{ $expense->amount ?? '' }}
                            </td>
                            <td>
                                {{ $expense->description ?? '' }}
                            </td>
                            <td>
                                
                                    <a class="btn btn-xs btn-primary" href="{{ route('expenses.show', $expense->id) }}">
                                        View
                                    </a>
                                

                                
                                    <a class="btn btn-xs btn-info" href="{{ route('expenses.edit', $expense->id) }}">
                                        Edit
                                    </a>
                                

                                
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="DELETE">
                                    </form>
                                

                            </td>

                        </tr>
                    @endforeach
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
    url: "{{ route('expenses.massDestroy') }}",
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
  $('.datatable-Expense:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection