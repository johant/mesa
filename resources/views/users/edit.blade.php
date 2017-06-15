@extends('layouts.master')

@section('header')
<h1>
  USUARIOS
  <small>Editar usuario </small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
  <li><a href=""><i class="fa fa-user"></i> Usuarios </a></li>
    <li><a href=""><i class="fa fa-pencil"></i> editar </a></li>
  <li class="active">Editar</li>
</ol>
@stop
