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
                <th>Pangkat</th>
                <th>Golongan</th>
                <th>Jabatan</th>
                <th>Akun</th>
                <th width="10%">Action</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

    </div>
    @include($modul . '._form')
  </div>
@endsection

@push('js')
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('script')
  @include('utils.js')
  <script>
    $('.select-2').select2();


    $("#select-2-user").select2({
      ajax: {
		url: "{{ route('employees.get.users') }}",
		data: function (params) {
			var q = {
				q: params.term
			}
			return q;
		},
		processResults: function (data) {
			console.log(data)
			return {
				results: $.map(data,function (item) {
					return {
						text: item.name + ' - ' + item.email,
						id: item.id,
					}
				})
			}
		}
	},
	placeholder: "--- Pilih Akun ---",
	allowClear: true
    });
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
          data: 'grade.name',
          orderable: true
        },
        {
          data: 'group.name',
          orderable: true
        },
        {
          data: 'position.name',
          orderable: true
        },
        {
          data: 'email',
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
      $('#disableInput').empty();
      $('#select-2-user').val(null).trigger('change');

      setForm('create', 'POST', ('Tambah {{ $title }}'), true)
      $('select[name="province_id"]').trigger('change');
    }

    function editItem(id) {
      $('#select-2-user').val(null).trigger('change');

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
      $('input[name=nip]').val(result.nip);
      $('input[name=bank_account]').val(result.bank_account);
      $('input[name=bank_number]').val(result.bank_number);
      $('select[name=group_id]').val(result.group_id).trigger('change');
      $('select[name=position_id]').val(result.position_id).trigger('change');
      $('select[name=grade_id]').val(result.grade_id).trigger('change');
      $('#disableInput').empty();
      if(result.user_id){
        $('#disableInput').append('<label for="type">Akun Saat Ini</label><input type="text" class="form-control" value="'+ (result.user? (result.user.name + ' - ' + result.user.email ):'Tidak Ada Akun') +'" disabled>')
      }
    }


    /** reload dataTable Setelah mengubah data**/
    function reloadDatatable() {
      dataTable.ajax.reload();
    }

    function formatCurrency(num) {
      return num.split("").reverse().reduce(function(acc, num, i, orig) {
        return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
      }, "");
    }

    $('.cost').on('focusout', function() {
      var value = $(this).val();
      var result = formatCurrency(value);
      $(this).val(result);
    });

    $('.cost').on('focus', function() {
      var value = $(this).val().replaceAll('.', '');
      $(this).val(value);
    });
  </script>
@endpush
