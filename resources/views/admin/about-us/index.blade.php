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

@endpush

@section('content')

  <div class="row">
    <div class="col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('about-us.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Company Name</label>
                  <input type="text" name="company_name" class="form-control" value="{{ (isset($aboutUs->company_name)?$aboutUs->company_name:'') }}" required>
                </div>
              </div>

              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Motto</label>
                  <input type="text" name="motto" value="{{ (isset($aboutUs->motto)?$aboutUs->motto:'') }}" class="form-control">
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Address</label>
                  <input type="text" name="address" value="{{ (isset($aboutUs->address)?$aboutUs->address:'') }}" class="form-control">
                </div>
              </div>
               <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Whatsapp</label>
                  <input type="text" name="whatsapp" value="{{ (isset($aboutUs->whatsapp)?$aboutUs->whatsapp:'') }}" oninput="this.value=this.value.replace(/[^0-9.]/g, ''
                  ).replace(/(\..*)\./g, '$1' );" class="form-control" placeholder="Example : 628123456">
                  <small>Whatsapp number must include national code. Example: 62</small>
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Email</label>
                  <input type="email" name="email" value="{{ (isset($aboutUs->email)?$aboutUs->email:'') }}" class="form-control">
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Description</label>
                  <textarea name="description" id="myeditorinstance" class="form-control" id="description" rows="4">{!!  (isset($aboutUs->description)?$aboutUs->description:'') !!}</textarea>
                </div>
              </div>
              <div class="form-group mb-3 col-12">
                <div class="form-line">
                  <label for="name">Main Image</label>
                  <p>File Name : <b class="file-name">Nothing Image Selected</b></p>
                  <div class="row">
                    <div id="preview" class="pb-2 mr-2 col-4">
                      <img src="{{ (isset($aboutUs->image)?'/storage/'.$aboutUs->image:asset('assets/img/no-image.png')) }}" class="" height="200px"  style="object-fit:contain;  max-width: 320px !important;"  alt="">
                    </div>
                    <div class="block-input-image col-7">
                      <div class="drop-image text-center ">
                        <div class="button-inside">Drop Image Here <br>or<br>
                          <div class="btn btn-primary">Select File</div>
                        </div>
                        <input type="file" name="image" accept="image/png, image/gif, image/jpeg"
                          class="form-control file-input" onchange="preview(this)">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="mt-4">
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

    @if (session('error'))
        @foreach (session('error') as $error )
            Toast.fire({
                icon: 'error',
                title: '{{ $error }}'
            })
        @endforeach
      @endif

      @if (session('success'))
      Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
      })
    @endif
  </script>
   <script>
     tinymce.init({
       selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
       plugins: 'code table lists',
       toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
     });
   </script>
@endpush
