@extends('utils.modal')
@section('input-form')
  <div class="form-group">
    <label for="type">Pilih Daerah Keberangkatan</label>
    <br>
    <select class="form-control select-2" name="arrival_id" id="province" required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($provinces as $item)
        <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="type">Pilih Daerah Tujuan</label>
    <br>
    <select class="form-control select-2" name="destination_id" id="province" required>
      <option disabled selected value>---- Pilih Salah Satu ----</option>
      @foreach ($provinces as $item)
        <option value="{!! $item->id !!}">{!! $item->name !!}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <div class="form-line">
      <label for="name">Jumlah Uang (Rp.)</label>
      <input type="text" name="cost"
        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control cost"
        placeholder="Masukkan Jumlah Uang" required>
    </div>
  </div>
@endsection
