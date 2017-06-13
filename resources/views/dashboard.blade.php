@extends('layouts.master')
@section('header')
<h1 class="pull-left">
 Dashboard
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

<div class="row">
  @include('partials.useraction')
</div>
<div class="row">
  @include('partials.pending')
</div>
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

  <script>
    $(function () {
      $('#tickets-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
      $('#tickets-pending-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>

@endpush
