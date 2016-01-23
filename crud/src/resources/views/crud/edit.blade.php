@extends('layouts.default')

@section('content-header')
<section class="content-header">
    <h1>
        {{ trans('crud.edit') }} <span class="text-lowercase">{{ $settings->title }}</span>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Admin</a></li>
        <li><a href="{{ url($settings->route) }}" class="text-capitalize">{{ $settings->route }}</a></li>
        <li class="active">{{ trans('crud.edit') }}</li>
    </ol>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <!-- Default box -->
        <a href="{{ url($settings->route)}}">
            <i class="fa fa-angle-double-left"></i> 
            {{ trans('crud.back_to_all') }} 
            <span class="text-lowercase">{{ $settings->title }}</span></a><br><br>
        {!! Form::open(array('url' => $settings->route.'/'.$entry->id, 'method' => 'put')) !!}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('crud.edit') }}</h3>
            </div>
            <div class="box-body">
                @if(view()->exists('crud::form'))
                @include('crud::form')
                @else
                @include('crud.form')
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">

                <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('crud.save') }}</span></button>
                <a href="{{ url($settings->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('crud.cancel') }}</span></a>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
        {!! Form::close() !!}
    </div>
</div>
@endsection
