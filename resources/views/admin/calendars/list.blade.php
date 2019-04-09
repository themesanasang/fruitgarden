@extends('layouts.app')

@section('head')
{!! Html::style('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') !!}
@stop

@section('script-footer')
{!! Html::script('https://code.jquery.com/jquery.js') !!}
{!! Html::script('https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js') !!}
{!! Html::script('public/js/sweetalert.min.js') !!}

<script>
$(function() {

    $.fn.dataTable.ext.classes.sPageButton = 'uk-button uk-button-default uk-button-small uk-margin-small-left';

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "uk-input uk-form-width-small uk-form-small",
        "sLengthSelect": "uk-select uk-form-width-xsmall uk-form-small"
    });

    var calendars_table = $('#calendars-table').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "pageLength": 10,
        "responsive": true,
        "pagingType": "simple",
        "info": true,
        "scrollX": true,
        "language": {
            "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "sSearch": "ค้นหา: ",
            "infoEmpty": "ไม่มีข้อมูล",
            //"infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "previous": "ก่อนหน้า",
                "next": "ถัดไป"
            },
        },
        ajax: {
          url: 'calendars',
          type: 'GET',
         },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false },
            { data: 'title'},
            { data: 'start_date'},
            { data: 'end_date'},
            { data: 'action', name: 'action', orderable: false,searchable: false }
        ]
    });// end calendars-table

});

/*
    * call delete calendars
    */
    function calendarsDelete(id)
    {
        swal({
            title: "คุณต้องการลบข้อมูล?",
            icon: "warning",
            buttons: true,
            buttons: ["ยกเลิก", "ตกลง"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'calendars/delete',
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'id='+id,
                    success: function (data) {
                        if (data['success']) {
                            location.reload(); 
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            } 
        });
    } 

</script>
@stop

@section('content')

<div uk-grid>
    <div class="uk-width-expand@m"><h3>จัดการ ปฏิทิน</h3></div>
    <div class="uk-width-auto@m">
        <a href="{{ url('calendars/full_calendar') }}" class="uk-button uk-button-default uk-width-auto@m"><span class="uk-margin-small-right" data-uk-icon="icon: calendar"></span> ดู ปฏิทิน</a>
        <a href="{{ route('calendars.create') }}" class="uk-button uk-button-primary uk-width-auto@m"><span class="uk-margin-small-right" data-uk-icon="icon: plus"></span> เพิ่ม ปฏิทิน</a>
    </div>
</div>
<hr>

<div class="uk-overflow-auto uk-margin-medium-top">
<table id="calendars-table" style="width:100%" class="uk-table uk-table-justify uk-table-small uk-table-striped uk-table-middle uk-table-hover uk-table-divider">
    <thead>
        <tr>
            <th>#</th>
            <th >ลำดับ</th>
            <th class="uk-table-expand">ชื่อกิจกรรม</th>
            <th class="uk-table-expand">วันที่เริ่ม</th>
            <th class="uk-table-expand">วันสิ้นสุด</th>
            <th class="uk-table-expand">จัดการ</th>
        </tr>
    </thead>
</table>
</div>


@endsection
