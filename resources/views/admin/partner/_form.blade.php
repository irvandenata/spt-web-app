@extends('utils.modal')
@section('modal-size', 'modal-lg')
@section('input-form')
  <div class="row">
    <div class="form-group mb-1 col-6">
      <div class="form-line">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
    </div>
    <div class="form-group mb-1 col-6">
      <div class="form-line">
        <label for="name">Order</label>
        <input type="number" name="order" class="form-control" min="0" value="{{ $order+1 }}" required>
      </div>
    </div>
    <div class="form-group mb-1 col-12">
      <div class="form-line">
        <label for="name">Link</label>
        <input type="text" name="link" class="form-control">
      </div>
    </div>
    <div class="form-group mb-1 col-12">
      <div class="form-line">
        <label for="name">Image</label>
        <input type="file" name="image_url" accept="image/png, image/gif, image/jpeg" class="form-control" onchange="preview(this)">
      </div>
    </div>
    <div id="preview" class="col-12">
      <img src="" class="d-none" width="100%" alt="">
    </div>
  </div>
@endsection
