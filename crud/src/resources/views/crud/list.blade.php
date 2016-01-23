@extends('layouts.default')

@section('head')
 
@endsection

@section('content-header')
<section class="content-header">
    <h1>
        <span class="text-capitalize">{{ $settings->title }}</span>
        <small>{{ trans('settings.all') }} <span class="text-lowercase">{{ $settings->title }}</span> {{ trans('settings.in_the_database') }}.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Admin</a></li>
        <li><a href="{{ url($settings->route) }}" class="text-capitalize">{{ $settings->title }}</a></li>
        <li class="active">{{ trans('crud.list') }}</li>
    </ol>
</section>
@endsection

@section('content')
<!-- Default box -->
<div class="box">
      @if (isset($errors) && $errors->any())
  	<div class="callout callout-danger">
        <h4>{{ trans('validation.please_fix') }}</h4>
        <ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
  @endif
<div class="flash-message">
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has($msg))
    <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
    @endif
  @endforeach
</div>
    <div class="text-right">{{ $entries->links() }}</div>
    <div class="box-header with-border">

        <a href="{{ url($settings->route.'/create') }}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> {{ trans('crud.add') }} {{ $settings->class }}</span></a>    

    </div>

    <div class="box-body">

        <table id="settingsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- Table columns --}}
                    @foreach ($settings->columns as $column)
                    <th class="text-center">
                        @if ($sortby == $column['name'] && $order == 'asc')

                        <a href="{{ url($settings->route, ['sortby' => $column['name'], 'order' => 'desc'])}}" > {{$column['label']}}</a>
                        @else 
                        <a href="{{ url($settings->route, ['sortby' => $column['name'], 'order' => 'asc'])}}" > {{$column['label']}}</a>

                        @endif
                    </th>
                    @endforeach
                    <th style="width:15%" class="text-center">{{ trans('crud.actions') }}</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($entries as $k => $entry)
                <tr data-entry-id="{{ $entry->id }}">


                    <!-- expand/minimize button column -->

                    @foreach ($settings->columns as $column)
                    @if (isset($column['type']) && $column['type']=='select_multiple')
                    {{-- relationships with pivot table (n-n) --}}
                    <td><?php
                        $results = $entry->{$column['entity']}()->getResults();
                        if ($results && $results->count()) {
                            $results_array = $results->lists($column['attribute'], 'id');
                            echo implode(', ', $results_array->toArray());
                        } else {
                            echo '-';
                        }
                        ?></td>
                    @elseif (isset($column['type']) && $column['type']=='select')
                    {{-- single relationships (1-1, 1-n) --}}
                    <td><?php
                        if ($entry->{$column['entity']}()->getResults()) {
                            echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
                        }
                        ?></td>
                    @elseif (isset($column['type']) && $column['type']=='model_function')
                    {{-- custom return value --}}
                    <td><?php
                        echo $entry->{$column['function_name']}();
                        ?></td>
                    @else
                    {{-- regular object attribute --}}
                    <td>{{ str_limit(strip_tags($entry->$column['name']), 80, "[...]") }}</td>
                    @endif

                    @endforeach


                    <td style="width:auto;">
                        {{-- <a href="{{ Request::url().'/'.$entry->id }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> {{ trans('crud.preview') }}</a> --}}
                        
                            <div style="float: left;">
                                <a href="{{ Request::url().'/'.$entry->id }}/edit" class="btn btn-primary"><i class="fa fa-edit"></i> {{ trans('crud.edit') }}</a>
                            </div>
                             <div style="float: left;margin-left: 5px;">
                                {{ Form::open(array('url' => $settings->route.'/'.$entry->id, 'method' => 'delete', 'class'=>'form-horizontal')) }}
                                {{ Form::submit(trans('crud.delete'), array('class' => 'btn btn-danger')) }} 
                                {{ Form::close() }}
                            </div>
                      
                    </td>

                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>

                </tr>
            </tfoot>
        </table>

    </div><!-- /.box-body -->
    <div class="text-right">{{ $entries->links() }}</div>
</div><!-- /.box -->
@endsection

@section('scripts')

@endsection
