@extends('layouts.template')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('style')

@endpush

@section('content')
<div class="row container-fluid">
    <div class="col-12">
        <div class="card p-4">
            <div class="text-right">
                <div class="btn btn-success btn-sm mb-2" onclick="createItem()">Tambah Data</div>
                <div class="btn btn-warning btn-sm mb-2" onclick="reloadDatatable()">Reload Data</div>
            </div>
            <div class="table-responsive">

                <table id="datatable" class="table table-bordered  m-t-30">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Lengkap</th>
                            <th>E-mail</th>
                            <th>Jenis Akun</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include($modul.'._form')
</div>
@endsection

@push('js')
 <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('script')


    @include('utils.js')
    <script>
        $('.select-2').select2( );
        let dataTable = $('#datatable').DataTable({
            dom: 'lBfrtip',
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            pageLength: 5,
            lengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            ajax: {
                url: child_url,
                type: 'GET',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false
                },

                {
                    data: 'name',
                    orderable: true
                },
                {
                    data: 'email',
                    orderable: true
                },
                {
                    data: 'role',
                    orderable: true
                },

                {
                    data: 'action',
                    name: '#',
                    orderable: false
                },
            ]
        });

    </script>

<script>
    function createItem() {
        setForm('create', 'POST', ('Tambah {{ $title }}'), true)
        $('select[name="district_id"]').trigger('change');

    }

    function editItem(id) {
        setForm('update', 'PUT', 'Ubah {{ $title }}', true)
        editData(id)
    }

    function deleteItem(id) {
        deleteConfirm(id)
    }

    $('input[name="password_confirmation"]').on('change', function() {
        if ( $(this).val() != $('input[name="password"]').val()) {
            $('#error-password').empty()
            $('#error-password').append('<small class="text-danger mt-2">Password Tidak Sama !</small>')
        }else{
            $('#error-password').empty()
        }
    })

    $('#submit').click(function(e) {
        if($('input[name="password"]').val() != $('input[name="password_confirmation"]').val()){
            return false
        }
    })

</script>

<script>
    /** set data untuk edit**/
    function setData(result) {
        $('input[name=id]').val(result.id);
        $('input[name=email]').val(result.email);
        $('input[name=name]').val(result.name);
        $('select[name=role]').val(result.role).trigger('change');
        $('input[name=password]').attr('required', false);
        $('input[name=password_confirmation]').attr('required', false);
    }


    /** reload dataTable Setelah mengubah data**/
    function reloadDatatable() {
        dataTable.ajax.reload();
    }
    function formatCurrency(num) {
    return  num.split("").reverse().reduce(function(acc, num, i, orig) {
        return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
    }, "");
}

    $('.cost').on('focusout', function() {
        var value =  $(this).val();
        var result = formatCurrency(value);
        $(this).val(result);
    });

    $('.cost').on('focus', function() {
        var value =  $(this).val().replaceAll('.','');
        $(this).val(value);
    });
</script>

@endpush
