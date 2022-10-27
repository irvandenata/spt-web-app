@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('style')
  <style>
    #datatable_filter {
      margin-bottom: 10px !important;
    }

    #preview {
      margin-right: 10px;
    }

    .drop-image {
      width: 100%;
      height: 200px;
      display: inline-block;
      object-fit: cover;
      border: 2px dashed #ccc;
      position: relative;
    }

    .file-input {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
    }

    .button-inside {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
  <style>
    .img-new {
      cursor: pointer;
    }

    .move {
      /* border: 3px solid #666;
                background-color: #ddd;
                border-radius: .5em;
                padding: 10px; */
      cursor: move;
    }

    .move-image {

      cursor: move;
    }

    .move.over {
      border: 3px dotted #666;
    }

    .move-image.over {
      border: 3px dotted #666;
    }


    .box-header {
      color: #444;
      display: block;
      padding: 10px;
      position: relative;
      border-bottom: 1px solid #f4f4f4;
      margin-bottom: 10px;
    }

    .box-tools {
      position: absolute;
      right: 10px;
      top: 5px;
    }

    .dropzone-wrapper {
      border: 2px dashed #91b0b3;
      color: #92b0b3;
      position: relative;
      height: 150px;
    }

    .dropzone-desc {
      position: absolute;
      margin: 0 auto;
      left: 0;
      right: 0;
      text-align: center;
      width: 40%;
      top: 50px;
      font-size: 16px;
    }

    .dropzone,
    .dropzone:focus {
      position: absolute;
      outline: none !important;
      width: 100%;
      height: 150px;
      cursor: pointer;
      opacity: 0;
    }

    .dropzone-wrapper:hover,
    .dropzone-wrapper.dragover {
      background: #ecf0f5;
    }

    .preview-zone {
      text-align: center;
    }

    .preview-zone .box {
      box-shadow: none;
      border-radius: 0;
      margin-bottom: 0;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card">
        <h5 class="card-header">
          Create Project
        </h5>
        <div class="card-body">
          <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group mb-3 col-6">
                <div class="form-line">
                  <label for="name">Title</label>
                  <input type="text" name="title" class="form-control" required>
                </div>
              </div>
              <div class="form-group mb-3 col-6">
                <div class="form-line">
                  <label for="name">Order</label>
                  <input type="number" name="order" class="form-control" min="0" value="{{ $order }}" required>
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Subtitle</label>
                  <input type="text" name="subtitle" class="form-control">
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Description</label>
                  <textarea name="description" id="myeditorinstance" class="form-control" id="description" rows="4"></textarea>
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Main Image</label>
                  <p>File Name : <b class="file-name">Nothing Image Selected</b></p>
                  <div class="row">
                    <div id="preview" class="pb-2 mr-2 col-4">
                      <img src="" class="d-none" height="200px" style="object-fit:contain;  max-width: 320px !important;" alt="">
                    </div>
                    <div class="block-input-image col-12">
                      <div class="drop-image text-center ">
                        <div class="button-inside">Drop Image Here <br>or<br>
                          <div class="btn btn-primary">Select File</div>
                        </div>
                        <input type="file" name="image" accept="image/png, image/gif, image/jpeg"
                          class="form-control file-input" onchange="preview(this)" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12">
                <label for="title">Detail Image</label>
                <table class="table table-bordered" id="additionalImageTabel">
                  <thead>
                    <tr>
                      <th scope="col" width="5%">Sort</th>
                      <th scope="col" width="5%">#</th>
                      <th scope="col" width="20%">image</th>
                      <th scope="col" width="40%">Caption</th>
                      <th scope="col" width="5%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id="image-1" draggable="true">
                      <td class="box-move">
                        <div class="move-image text-center">
                          <svg xmlns="http://www.w3.org/200/svg" width="15" viewBox="0 0 320 512">
                            <path
                              d="M40 352c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zm192 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zM40 320l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40zM232 192c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zM40 160l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40L40 32C17.9 32 0 49.9 0 72l0 48c0 22.1 17.9 40 40 40zM232 32c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0z" />
                          </svg>
                        </div>
                      </td>
                      <th scope="row">1<input type="hidden" class="indextd" draggable="true" value="1"></th>
                      <td>
                        <img src="" alt="image" class="img-thumbnail w-25 h-25  mb-3 cursor-pointer"
                          onClick="showImage(this)" style='display:none'>
                        <div class="container-img">
                          <input type="file" onChange="filePreview(this)" class="form-control additional_image"
                            accept="image/jpg, image/png" name="multi_image[]" id="additional_image"
                            placeholder="Enter Image">
                        </div>
                      </td>
                      <td><input type="text" class="form-control caption" name="caption[]" id="caption"
                          value="" placeholder="Enter Caption"></td>
                      </td>

                      <td>
                        <input type="hidden" class="idRow" value="1">
                        <div class="btn btn-sm btn-danger "onclick="deleteRowImage(this)"><i class="fa fa-trash"></i>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="btn btn-warning btn-sm mt-2" id="addAdditionalImage">+ Add New </div>
                <div class="mt-4">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-2">Back</a>
                  <button type="submit" class="btn btn-success mt-2" id="submit">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection

@push('js')
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/i1nnds4l5jeoaufjhsu6l45pa8zxzdwc4vwh9dktv8d5gig4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

@endpush

@push('script')
  <script>
    function preview(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#preview>img').attr('src', e.target.result);
        }

        $('.file-name').text(e.files[0].name);
        reader.readAsDataURL(e.files[0]);
        $('#preview>img').removeClass('d-none');
        $('.block-input-image').removeClass('col-12').addClass('col-7');
      }
    }
  </script>
   <script>
     tinymce.init({
       selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
       plugins: 'code table lists',
       toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
     });
   </script>
  <script>
    let previousId;
    let component;
    let id;
    let statusChange = false;
    let lengthOptList =
      "1";
    let idRowImage =
      "1";

    $("#addAdditionalImage").on('click', function() {
      let list = $('#additionalImageTabel tbody tr').length + 1;
      let opt = '';
      for (let index = 1; index <= list; index++) {
        opt = opt + '<option value="' + (index) + '" ' + ((index == list) ? "selected" : '') +
          '>' + (
            index) + '</option>';
      }
      let html = `<tr id="image-` + list + `" draggable="true">

            <td class="box-move">
                                  <div class="move-image text-center">
                                    <svg xmlns="http://www.w3.org/200/svg" width="15" viewBox="0 0 320 512">
                                      <path
                                        d="M40 352c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zm192 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zM40 320l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40zM232 192c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0zM40 160l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40L40 32C17.9 32 0 49.9 0 72l0 48c0 22.1 17.9 40 40 40zM232 32c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0z" />
                                    </svg>
                                  </div>
                                </td>
                            <th scope="row">` + list +
        ` <input type="hidden" class="indextd" draggable="true" value="` +
        list + `"></th><td>
                                <img  src=""
                                    alt="image" class="img-thumbnail w-25 h-25  mb-3 cursor-pointer" onClick="showImage(this)" style='display:none'>
                            <div class="container-img">
                                        <input type="file" onChange="filePreview(this)" class="form-control additional_image"
                                        accept="image/jpg, image/png" name="multi_image[]" id="additional_image"
                                        placeholder="Enter Image">
                                    </div></td>
                            <td><input type="text" class="form-control caption" name="caption[]" id="caption" value=""
                                    placeholder="Enter Caption"></td>
                            </td>

                            <td>
                                <input type="hidden" class="idRow" value="` + list + `">
                                <div class="btn btn-sm btn-danger "onclick="deleteRowImage(this)"><i class="fa fa-trash"></i></div>
                            </td>
                        </tr>`
      $("#additionalImageTabel>tbody").append(html)
      let itemsImage = document.querySelectorAll('.box-move .move-image');
      itemsImage.forEach(function(item) {
        item = $(item).parent().parent()[0]
        item.addEventListener('dragstart', handleImageDragStart);
        item.addEventListener('dragover', handleDragOver);
        item.addEventListener('dragenter', handleDragEnter);
        item.addEventListener('dragleave', handleDragLeave);
        item.addEventListener('dragend', handleDragEnd);
        item.addEventListener('drop', handleImageDrop);
      });
    })


    $('.form-control').on('change', function() {
      statusChange = true;
    })

    function filePreview(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(input).parent().parent().find("img").attr('src', e.target.result);
          $(input).parent().parent().find("img").css('display', 'block');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function deleteRow(component) {
      statusChange = true;
      save = true
      let id = $(component).parent().parent().find('th .indextd').val();
      let row = $('#checklistTabel>tbody>#list-' + id);
      row.remove()
      $("#checklistTabel>tbody>tr").each(function(index) {
        $(this).find('th').html((index + 1) + ` <input type="hidden" class="indextd" value="` + (parseInt(index) +
          1) + `">`)
        $(this).attr("id", "list-" + (parseInt(index) + 1))
      })
    }




    function deleteRowImage(e) {
      statusChange = true;
      save = true
      let id = $(e).parent().parent().attr('id');
      let idImage = $(e).parent().parent().find('.idImage').val();
      let row = $('#additionalImageTabel>tbody>#' + id);
      row.remove()
      $("#additionalImageTabel>tbody>tr").each(function(index) {
        $(this).find('th').html((index + 1) + ` <input type="hidden" class="indextd" value="` + (parseInt(index) +
          1) + `">`)
        $(this).attr("id", "image-" + (parseInt(index) + 1))
      })
      if (idImage != null) {
        $("#delImage").append('<input type="hidden" name="delete_image[]" value="' + idImage + '">')
      }
    }

    let save = false;

    window.addEventListener("beforeunload", function(e) {
      if (statusChange && !save) {
        var confirmationMessage = "\o/";
        (e || window.event).returnValue = "";
        return confirmationMessage;
      }
    });

    let dragSrcEl = null;
    let dragSrcImgEl = null;
    let temp = null;

    let idImage = null;
    let imageValue = null;
    let captionValue = null;
    let img = null;
    let elementRow = null;

    function switchListImage(current, target) {
      statusChange = true;
      if (parseInt(current) < parseInt(target)) {
        for (let index = parseInt(current); index < target; index++) {
          let row = $('#image-' + index);
          let rowNext = $('#image-' + (index + 1));
          let image = row.find('td .idImage').val();
          let file = row.find('td .container-img .additional_image')[0].files
          let tempImg = $(row.find('td img')).attr('src')
          let caption = row.find('td .caption').val();

          let imageNext = rowNext.find('td .idImage').val();
          let fileNext = rowNext.find('td .container-img .additional_image')[0].files
          let tempImgNext = $(rowNext.find('td img')).attr('src')
          let captionNext = rowNext.find('td .caption').val();
          rowNext.find('td .idImage').val(image);

          rowNext.find('td .container-img .additional_image')[0].files = file
          $(rowNext.find('td img')).attr('src', tempImg)
          if (tempImg == null || tempImg == '') {
            $(rowNext.find('td img')).css('display', 'none')
          } else {
            $(rowNext.find('td img')).css('display', 'block')
          }
          rowNext.find('td .caption').val(caption);
          row.find('td .idImage').val(imageNext);
          row.find('td .container-img .additional_image')[0].files = fileNext
          $(row.find('td img')).attr('src', tempImgNext)
          if (tempImgNext == null || tempImgNext == '') {
            $(row.find('td img')).css('display', 'none')
          } else {
            $(row.find('td img')).css('display', 'block')
          }
          row.find('td .caption').val(captionNext);
        }
      } else if (parseInt(current) > parseInt(target)) {
        for (let index = parseInt(current); index > target; index--) {
          let row = $('#image-' + index);
          let rowNext = $('#image-' + (index - 1));
          let image = row.find('td .idImage').val();
          let file = row.find('td .container-img .additional_image')[0].files
          let tempImg = $(row.find('td img')).attr('src')
          let caption = row.find('td .caption').val();

          let imageNext = rowNext.find('td .idImage').val();
          let fileNext = rowNext.find('td .container-img .additional_image')[0].files
          let tempImgNext = $(rowNext.find('td img')).attr('src')
          let captionNext = rowNext.find('td .caption').val();

          rowNext.find('td .idImage').val(image);
          rowNext.find('td .container-img .additional_image')[0].files = file
          $(rowNext.find('td img')).attr('src', tempImg)
          if (tempImg == null || tempImg == '') {
            $(rowNext.find('td img')).css('display', 'none')
          } else {
            $(rowNext.find('td img')).css('display', 'block')
          }

          rowNext.find('td .caption').val(caption);

          row.find('td .idImage').val(imageNext);
          row.find('td .container-img .additional_image')[0].files = fileNext
          $(row.find('td img')).attr('src', tempImgNext)
          if (tempImgNext == null || tempImgNext == '') {
            $(row.find('td img')).css('display', 'none')
          } else {
            $(row.find('td img')).css('display', 'block')
          }
          row.find('td .caption').val(captionNext);
        }
      }
    }

    function handleImageDragStart(e) {
      dragSrcImgEl = $(this);
    }

    function handleDragEnd(e) {
      this.style.opacity = '1';
      itemsImage.forEach(function(item) {
        item.classList.remove('over');
      });
    }

    function handleDragOver(e) {
      e.preventDefault();
      return false;
    }

    function handleDragEnter(e) {
      this.classList.add('over');
    }

    function handleDragLeave(e) {
      this.classList.remove('over');
    }

    function handleImageDrop(e) {
      e.stopPropagation(); // stops the browser from
      if (dragSrcImgEl !== this) {
        let target = $(this).find('th .indextd').val();
        switchListImage(dragSrcImgEl.find('th .indextd').val(), target)
      }
      return false;
    }
    let itemsImage = document.querySelectorAll('.box-move .move-image');
    itemsImage.forEach(function(item) {
      item = $(item).parent().parent()[0]
      item.addEventListener('dragstart', handleImageDragStart);
      item.addEventListener('dragover', handleDragOver);
      item.addEventListener('dragenter', handleDragEnter);
      item.addEventListener('dragleave', handleDragLeave);
      item.addEventListener('dragend', handleDragEnd);
      item.addEventListener('drop', handleImageDrop);
    });

    $('#image').on('change', function() {
      save = true
      let file = this.files[0];
      let reader = new FileReader();
      reader.onloadend = function() {
        $('.main-image').attr('src', reader.result);
      }
      if (file) {
        reader.readAsDataURL(file);
      } else {
        $('.main-image').attr('src', '');
      }
    });

    // logic for validation Order
    let limitOrder = {{  $order }}
    $('input[name=order]').on('change', function() {
      if ($(this).val() > limitOrder) {
        $(this).val(limitOrder)
      }
    })


    $('#submit').on('click',function(){
         save = false;
        statusChange = false;
    })
    @if (session('error'))
        @foreach (session('error') as $error )
            Toast.fire({
                icon: 'error',
                title: '{{ $error }}'
            })
        @endforeach
      @endif
  </script>
@endpush
