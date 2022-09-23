@extends('layouts.template')

@section('title', $title)
@section('breadcrumb', $breadcrumb)
@section('content')
<div class="row" id="proBanner">
    <div class="col-12">
      <span class="d-flex align-items-center purchase-popup">
        <p>Like what you see? Check out our premium version for more.</p>
        <a href="https://github.com/BootstrapDash/ConnectPlusAdmin-Free-Bootstrap-Admin-Template" target="_blank" class="btn ml-auto download-button">Download Free Version</a>
        <a href="http://www.bootstrapdash.com/demo/connect-plus/jquery/template/" target="_blank" class="btn purchase-button">Upgrade To Pro</a>
        <i class="mdi mdi-close" id="bannerClose"></i>
      </span>
    </div>
  </div>
@endsection
