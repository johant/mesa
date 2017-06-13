<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        @if( $type == 'Crear' )
        <h3>Se ha generado el Caso Nro {!! $ticket !!} {!! $title !!}</h3>
        @elseif ( $type == 'Modificar' )
        <h3>Se ha actualizado el Caso Nro <b> {!! $ticket !!}</b></h3>
        @else
        <h3>Se ha Cerrado el Caso Nro <b> {!! $ticket !!}</b></h3>
        @endif
        <p>Fecha: {!! $date !!}</p>
        <p>Estado: {!! $status !!}</p>
        <p>Autor del Aviso: {!! $user !!}</p>
        <p> Titulo: {!! $title !!}</p>
        <p>Prioridad: {!! $priority !!}</p>
        <p>Descripción detallada: {!! $description !!}</p>
        @if( count($attachments))
        <p><strong> Lista de adjuntos: </strong></p>
        <p>Para ver la lista de adjuntos copie la direccion en el navegador!!</p>
         <ul>
            @foreach($attachments as $attachment)
                <li><a href="{{ url('/').(Storage::url ('files/'. $attachment)) }}" target="_blank"> {{ url('/').Storage::url ('files/'. $attachment) }}</a></li>
            @endforeach
        @endif
         </ul>
    </body>
</html>
