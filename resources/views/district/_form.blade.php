@extends('utils.modal')
@section('input-form')
<div class="form-group">
    <div class="form-line">
        <label for="name">Nama Kabupaten / Kota</label>
        <input type="text" name="name" class="form-control" required>
    </div>
</div>
<div class="form-group">
   <label for="type">Pilih Provinsi</label>
   <br>
   <select class="form-control select-2" name="province_id" id="province" required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
@foreach($provinces as $item)
      <option value="{!! $item->id !!}">{!! $item->name !!}</option>
@endforeach
   </select>
</div>
@endsection
