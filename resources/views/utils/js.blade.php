<script>
    const child_url = "{!! Request::url() !!}";


    function setForm(saved, method, title) {
        save_method = saved;
        $('input[name=_method]').val(method);
        $('#modalForm form')[0].reset();
        $(':input[name=id]').val('');
        $('#modalFormTitle').text(title);
        $('.select-2').trigger('change');
        $('#modalForm').modal('show');
    }

    function editData(id) {
        $.ajax({
            url: child_url + "/" + id + "/edit",
            type: "GET",
            dataType: "json",
            success: function (result) {

                setData(result);
            },
            error: function (result) {
                console.log(result);
            }
        })
    }

    function setUrl() {
        var id = $('#id').val();
        if (save_method == "create") url = child_url;
        else url = child_url + '/' + id;

        return url;
    }

    /** ambil data error**/
    function getError(errors) {
        $.each(errors, function (index, value) {
            toastr.error(value, 'Error', {
                closeButton: true,
                progressBar: true,
            });
        });
    }

    /** save data onsubmit**/
    $(function () {
        $('#modalForm form').on('submit', function (e) {
            if (!e.isDefaultPrevented()) {
                saveAjax(setUrl(),e);
                return false;
            }
        });
    });

    function saveAjax(url,e) {
        e.preventDefault();
        Swal.fire({
            type: 'warning',
            text: 'Please wait.',
            showCancelButton: false,
            confirmButtonText: "ok",
            allowOutsideClick: false,
            allowEscapeKey: false
        })
        Swal.showLoading()

        $.ajax({
            url: url,
            type: "post",
            cache: false,
            dataType: 'json',
            data: new FormData($('#modalForm form')[0]),
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('#modalForm').modal('hide');
                reloadDatatable();
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                // toastr.success('Berhasil Disimpan', 'Success');
            },
            error: async function (result) {
                $('#modalForm').modal('hide');
                Swal.fire({
                    icon: 'error',
                    text: 'Terjadi Kesalahan !',
                    showCancelButton: false,
                }).then(() => {
                    if (result.responseJSON) {
                        console.log(result.responseJSON)
                        getError(result.responseJSON);
                    } else {
                        console.log(result);
                    }
                })

            },
        })
    }

    /** konfirmasi hapus data **/
    function deleteConfirm(id) {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are You Sure ?',
            text: "You will delete this data!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'No, Quit!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                deleteData(id).then((result) => {

                    if (result) {

                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Data Has Been Deleted',
                            'success'
                        ).then(() => {
                            reloadDatatable();

                        })
                    }
                });


            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancel',
                    'Process Has Been Canceled',
                    'error'
                )
            }
        })
    }

    /** hapus data dari database **/
    function deleteData(id) {

        return new Promise((resolve, reject) => {
            var url = child_url + '/' + id;
            let result = false;
            Swal.fire({
                type: 'warning',
                text: 'Please wait.',
                showCancelButton: false,
                confirmButtonText: "ok",
                allowOutsideClick: false,
                allowEscapeKey: false
            })
            Swal.showLoading()
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    resolve(true)
                    // toastr.success('Berhasil Dihapus', 'Success');
                },
                error: function (errors) {

                    getError(errors.responseJSON);
                    Swal.fire({
                        icon: 'error',
                        text: 'Terjadi Kesalahan !',
                        showCancelButton: false,
                    })
                    reject(false)
                }
            })
        })

    }

</script>
