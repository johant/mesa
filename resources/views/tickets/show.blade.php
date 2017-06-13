@extends('layouts.master')

@section('header')
<h1>
  TICKETS
  <small>Visualizar Incidente Nro. {!! $ticket->id !!}</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
  <li><a href=""><i class="fa fa-dashboard"></i> Tickets </a></li>
  <li class="active">Visualizar</li>
</ol>
@stop

@section('content')
<div class="row">
  <form class="" action="#" method="post" enctype="multipart/form-data" files="true">
{{ csrf_field() }}

  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group {{ $errors->has('title') ? 'has-error': ''}}">
          <label for="">Titulo del Ticket</label>
          <label type="text" name="title" placeholder="Ingresa el titulo del Incidente"
          class="form-control">{!! $ticket->title !!}</label>
        </div>
        <div class="form-group {{ $errors->has('body') ? 'has-error': ''}}">
          <label for="">Descripción Detallada</label>
          <div class=""> {!! $ticket->body !!}</div>
          {!! $errors->first('body', '<span class="help-block">:message</span>')!!}
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group {{ $errors->has('category') ? 'has-error': ''}}">
          <label>Categorias</label>
          <label type="text" name="category"
          class="form-control">{!! $ticket->category->name !!}</label>
        </div>
      <div class="form-group {{ $errors->has('priority') ? 'has-error': ''}}">
          <label>Importancia</label>
          <label type="text" name="category"
          class="form-control">{!! $ticket->priority !!}</label>
          {!! $errors->first('priority', '<span class="help-block">:message</span>')!!}
        </div>
        <div class="form-group {{ $errors->has('emails') ? 'has-error': ''}}">
           <label>Enviar correo a</label>
           <select class="form-control select2"
                    name="emails[]"
                    multiple="multiple"
                    data-placeholder="Seleccione una o más Etiquetas" style="width: 100%;" disabled>
                   @foreach ($ticket->emails as $email)
                     <option selected value="{{ $email->id }}">{{ $email->name }}</option>
                   @endforeach
           </select>
        </div>
      @if($attachments->count()>0)
        <div class="form-group {{ $errors->has('file') ? 'has-error': ''}}">
          <label for="">Archivos Adjuntos</label>
            <ul>
                @foreach($attachments as $attach)
                    <li><a href="{{ Storage::url ('files/'. $attach->filename) }}" target="_blank"> {{ $attach->original_file }} </a></li>
                @endforeach
            </ul>
        </div>
      @endif
        <div class="form-group">
          <label>Estado</label>
          <div class="form-control" >{{ $ticket->status->name }}</div>
        </div>
        <div class="form-group">
          <label>Usuario</label>
          <div class="form-control" >{{ $ticket->user->name}}</div>
        </div>
        <div class="form-group">
        @if($ticket->status_id ==1 || $ticket->status_id ==2 || $ticket->status_id ==3 || $ticket->status_id ==6 )
        <a href="{{ route('tickets.edit', $ticket->url ) }}" class="btn btn-primary btn-block">Editar Incidente</a>
        @endif
        </div>
      </div>
    </div>
  </div>
    </form>
</div>

@stop
@push('styles')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="/adminlte/plugins/datepicker/datepicker3.css">
<!-- Select2 -->
<link rel="stylesheet" href="/adminlte/plugins/select2/select2.min.css">
@endpush

@push('scripts')
  <!-- bootstrap datepicker -->
  <script src="/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- CK Editor -->
  <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
  <!-- Select2 -->
  <script src="/adminlte/plugins/select2/select2.full.min.js"></script>
  <script>
  //Initialize Select2 Elements
  $(".select2").select2();

  $('#datepicker').datepicker({
    autoclose: true
  });

  CKEDITOR.replace('editor');
  </script>

@endpush
