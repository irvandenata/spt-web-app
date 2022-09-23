@extends('layouts.template')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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
                            <th>Nama Golongan</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('group._form')
</div>
@endsection

@push('js')
 <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
@endpush

@push('script')


    @include('utils.js')
    <script>
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

        }

        function editItem(id) {
            setForm('update', 'PUT', 'Ubah {{ $title }}', true)
            editData(id)


        }

        function deleteItem(id) {
            deleteConfirm(id)

        }

    </script>

    <script>
        /** set data untuk edit**/
        function setData(result) {
            $('input[name=id]').val(result.id);
            $('input[name=name]').val(result.name);
        }


        /** reload dataTable Setelah mengubah data**/
        function reloadDatatable() {
            dataTable.ajax.reload();
        }
    </script>

@endpush
