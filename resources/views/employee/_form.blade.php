@extends('utils.modal')
@section('input-form')
<div class="form-group">
    <div class="form-line">
        <label for="name">Nama Lengkap</label>
        <input type="text" minlength="3" name="name" class="form-control" required>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">NIP</label>
        <input type="number"  name="nip" class="form-control" required>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">Nama Bank</label>
        <input type="text"  name="bank_account" class="form-control">
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">Nomor Rekening</label>
        <input type="number"  name="bank_number" class="form-control">
    </div>
</div>
  <div class="form-group">
    <label for="type">Pilih Pangkat</label>
    <br>
    <select class="form-control select-2" name="grade_id"  required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($grades as $item)
        <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="type">Pilih Golongan</label>
    <br>
    <select class="form-control select-2" name="group_id"  required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($groups as $item)
        <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="type">Pilih Jabatan</label>
    <br>
    <select class="form-control select-2" name="position_id"  required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($positions as $item)
        <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="type">Pilih Akun (Boleh Kosong)</label>
    <br>
    <select class="form-control " id="select-2-user" name="user_id" required>
      <option selected value disabled>---- Pilih Salah Satu ----</option>
      <option value="">Tidak Ada Akun</option>
    </select>
  </div>
  <div class="form-group" id="disableInput">

  </div>
@endsection
