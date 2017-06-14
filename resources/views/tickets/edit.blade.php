@extends('layouts.master')

@section('header')
<h1>
  TICKETS
  <small>Editar Incidente Nro. {!! $ticket->id !!}</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
  <li><a href=""><i class="fa fa-dashboard"></i> Tickets </a></li>
  <li class="active">Editar</li>
</ol>
@stop

@section('content')
<div class="row">
  <form class="" action="{{ route('tickets.update', $ticket->url )}}" method="post" enctype="multipart/form-data" files="true" onsubmit="return checkForm(this);">
{{ csrf_field() }}

  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group {{ $errors->has('title') ? 'has-error': ''}}">
          <label for="">Titulo del Ticket</label>
          <div class="form-control" >{{ $ticket->title}}</div>
          {!! $errors->first('title', '<span class="help-block">:message</span>')!!}

        </div>

        <div class="form-group {{ $errors->has('body') ? 'has-error': ''}}">
          <label for="">Descripción Detallada</label>
          <div class=""> {!! $ticket->body !!}</div>
          <textarea name="body" id="editor" rows="10" class="form-control" placeholder="Ingresa el contenido del Ticket">
          {{ old('body')}} </textarea>
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
          @if (auth()->user()->role_id == 1 )
            <select class="form-control" name="category">
              <option value="">Seleccione una Categoria</option>
              @foreach ($categories as $category)
                 <option value="{{ $category->id}}" {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
           {!! $errors->first('category', '<span class="help-block">:message</span>')!!}
          @else
          <label type="text" name="category"
          class="form-control">{!! $ticket->category->name !!}</label>
          @endif
        </div>
      <div class="form-group {{ $errors->has('priority') ? 'has-error': ''}}">
          <label>Importancia</label>
          @if (auth()->user()->role_id == 1 )
          <select class="form-control" name="priority">
            <option value="">Seleccione un Nivel de Importancia</option>
            <option value="baja" {{ $ticket->priority == 'baja' ? 'selected' : '' }}>Baja</option>
            <option value="media" {{ $ticket->priority == 'media' ? 'selected' : '' }}>Media</option>
            <option value="alta" {{ $ticket->priority == 'alta' ? 'selected' : '' }}>Alta</option>
          </select>
          {!! $errors->first('priority', '<span class="help-block">:message</span>')!!}
          @else
         <label type="text" name="category"
          class="form-control">{!! $ticket->priority !!}</label>
          @endif
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
           {!! $errors->first('emails', '<span class="help-block">:message</span>')!!}
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
        <div class="form-group {{ $errors->has('file') ? 'has-error': ''}}">
          <label for="">Adjuntar Archivo</label>
          <input type="file" id="files" name="files[]" multiple class="file-loading">
          {!! $errors->first('file', '<span class="help-block">:message</span>')!!}
        </div>
        @if (auth()->user()->role_id == 1 )
        <div class="form-group {{ $errors->has('estado') ? 'has-error': ''}}">
          <label>Estado</label>
          <select class="form-control" name="status">
            <option value="">Seleccione un estado</option>
            @foreach ($status as $estado)
              <option value="{{ $estado->id }}"
                {{ $ticket->status_id == $estado->id ? 'selected': ''}}>
                {{ $estado->name }}
              </option>
            @endforeach
          </select>
          {!! $errors->first('estado', '<span class="help-block">:message</span>')!!}
        </div>
        @endif
        <div class="form-group {{ $errors->has('estado') ? 'has-error': ''}}">
          <label>Usuario</label>
          <div class="form-control" >{{ $ticket->user->name}}</div>
        </div>
        <div class="form-group">
          <button type="submit" name="btnSave" class="btn btn-primary btn-block">Guardar Incidente</button>
        </div>
      </div>
    </div>
  </div>
    </form>
</div>
<div class="row">
  <div class="alert alert-danger alert-dismissable">
    <p>
      Para descargar el formato de incidente paso a paso, por favor haga click <a href="{{ asset('Formato/formato_incidentes.docx') }}" target="_blank">aqui</a> .
    </p>
  </div>
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
  function checkForm(form) // Submit button clicked
  {
    form.btnSave.disabled = true;
    $("#btnSave").html('Actualizando Incidente...');
    return true;
  }
  //Initialize Select2 Elements
  $(".select2").select2();

  $('#datepicker').datepicker({
    autoclose: true
  });

  CKEDITOR.replace('editor');
  </script>

@endpush
