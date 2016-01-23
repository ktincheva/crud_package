@extends('layouts.default')

@section('content-header')
	<section class="content-header">
	  <h1>
	    {{ trans('crud.preview') }} <span class="text-lowercase">{{ {{ $settings->title }} }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('/') }}">Admin</a></li>
	    <li><a href="{{ url($settings->route) }}" class="text-capitalize">{{{{ $settings->title }}}}</a></li>
	    <li class="active">{{ trans('crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<a href="{{ url(url($settings->route)) }}"><i class="fa fa-angle-double-left"></i> {{ trans('crud.back_to_all') }} <span class="text-lowercase">{{ $settings->title }}</span></a><br><br>
<!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('crud.preview') }} <span class="text-lowercase">{{ $settings->title }}</h3>
    </div>
    <div class="box-body">
      {{ dump($entry) }}
    </div><!-- /.box-body -->
  </div><!-- /.box -->
@endsection
