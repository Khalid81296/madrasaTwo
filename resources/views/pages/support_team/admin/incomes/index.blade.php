@extends('layouts.master')
@section('page_title', 'Others Income List ')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('incomes.create') }}">
                Add Others Income
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        <h4>Others Income List</h4>
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
                            Income Category
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
                    @foreach($incomes as $key => $income)
                        <tr data-entry-id="{{ $income->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $income->id ?? '' }}
                            </td>
                            <td>
                                {{ $income->income_category->name ?? '' }}
                            </td>
                            <td>
                                {{ date( 'Y-m-d', strtotime($income->entry_date)) ?? '' }}
                            </td>
                            <td>
                                {{ $income->amount ?? '' }}
                            </td>
                            <td>
                                {{ $income->description ?? '' }}
                            </td>
                            <td>
                                
                                    <a class="btn btn-xs btn-primary" href="{{ route('incomes.show', $income->id) }}">
                                        View
                                    </a>
                                

                                
                                    <a class="btn btn-xs btn-info" href="{{ route('incomes.edit', $income->id) }}">
                                        Edit
                                    </a>
                                

                                
                                    <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" onsubmit="return confirm('Are You Sure');" style="display: inline-block;">
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