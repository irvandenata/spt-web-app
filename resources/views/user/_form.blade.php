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
        <label for="name">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">Jenis Akun</label>
        <select name="role" class="form-control" required>
            <option value="pegawai">Pegawai</option>
            <option value="pimpinan">Pimpinan</option>
            <option value="admin">Admin</option>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">Password</label>
        <input type="password" minlength="6" name="password" class="form-control" required>
        <div id="error-password" >

        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="name">Masukkan Kembali Password</label>
        <input type="password" minlength="6" name="password_confirmation" class="form-control" required>
    </div>
</div>
@endsection
