@extends('layouts.master')

@section('header')
<h1 class="pull-left">  {{ $estado }}
  <small><i class="fa fa-arrow-circle-left"></i><a href="/"> Regresar al Inicio</a></small>
</h1>
{{-- <ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
  <li class="active">Tickets</li>
</ol> --}}
<div class="pull-right">
     <a href="/tickets/create" class="btn bg-blue">
            <i class="fa fa-plus-square"></i>
           Crear Incidente
        </a>
</div>
@stop

@section('content')
  @include('partials.statistics')

<div class="box box-primary">
  <div class="box-header">
    <h3 class="box-title">
      Listado de Tickets {{ $estado }}
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
  <div class="table-responsive">
    <table id="tickets-table" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Categoria</th>
        <th>Fecha</th>
        <th>Status</th>
        <th>Lineas</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
@foreach($ticketsAll as $ticket)
          <tr>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->category->short_name }}</td>
            <td>{{ $ticket->published_at->diffForHumans() }}</td>
            <td role="gridcell">
              <span class="@if($ticket->status_id == 1) grid-report-item  aqua @elseif($ticket->status_id == 2) grid-report-item  yellow
                                    @elseif($ticket->status_id == 3) grid-report-item  green @elseif($ticket->status_id == 4) grid-report-item  purple
                                    @elseif($ticket->status_id == 5) grid-report-item red @elseif($ticket->status_id == 6) grid-report-item light-blue
                                    @endif">
                          {{ $ticket->status->name }}
              </span>
            </td>
            <td>{{ $ticket->user->name }} </td>
            <td>
            @if($ticket->status_id != 2)
              <a href="/tickets/{{ $ticket->url }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
              @endif
              @if($ticket->status_id ==1 || $ticket->status_id ==2 || $ticket->status_id ==3 || $ticket->status_id ==6 )
              <a href="/tickets/edit/{{ $ticket->url }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
              @endif
              @if($ticket->status_id == 2)
              <a href="" class="btn btn-xs btn-danger" data-whatever="{{ $ticket->title }}"
                    data-id="{{ $ticket->id }}" data-toggle="modal" data-target="#myModal"
                    data-url="{{ $ticket->url}}"><i class="fa fa-lock"></i></a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@stop
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/css/style.css">
@endpush
@push('scripts')
  <!-- DataTables -->
  <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- CK Editor -->
  <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cerrar Caso</h4>
      </div>
      <form class="" action="" method="post"  id="frmCerrar" onsubmit="return checkForm(this);">
        {{ csrf_field() }}
      <div class="modal-body">
      <div class="form-group {{ $errors->has('title') ? 'has-error': ''}}">
          <label for="">Titulo del Ticket</label>
          <div class="form-control" id="title" ></div>
        </div>
        <div class="form-group">
          <label for="">Descripción Detallada</label>
          <textarea name="body" id="editor" rows="10" class="form-control" placeholder="Ingresa el contenido del Ticket"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="btnSave"  id="btnSave"  class="btn btn-primary" >Cerrar Caso</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <script>
   function checkForm(form) // Submit button clicked
      {
        form.btnSave.disabled = true;
        $("#btnSave").html('Cerrando Incidente...');
        return true;
      }
    $(function () {
        CKEDITOR.replace('editor');

      $('#tickets-table').DataTable({
        "responsive": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
     $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var url = button.data('url') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#title').text(recipient)
        var pathname = window.location.host
        $('#frmCerrar').attr('action', window.location.protocol + "//"+pathname+'/tickets/close/'+url);
      });
    });
  </script>
  <!-- Modal -->

@endpush
