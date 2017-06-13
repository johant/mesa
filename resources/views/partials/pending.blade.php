    <div class="col-md-12">
        <div class="box box-info ">
            <div class="box-header with-border clearfix">
                <div class="box-title">
                    <i class="fa fa-hourglass-start"></i>
                    Pendientes Soporte
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
                        <div class="box-body">
                <table id="tickets-pending-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modulo</th>
                            <th>Titulo</th>
                            <th>Fecha</th>
                            <th>Status</th>
                            <th>Prioridad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticketsPending as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->category->short_name }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{!! $ticket->published_at->diffForHumans() !!}</td>
                            <td role="gridcell"><span class="@if($ticket->status_id == 1) grid-report-item  aqua @elseif($ticket->status_id == 2) grid-report-item  yellow
                                                                                    @elseif($ticket->status_id == 3) grid-report-item  green @elseif($ticket->status_id == 4) grid-report-item  purple
                                                                                    @elseif($ticket->status_id == 5) grid-report-item red @elseif($ticket->status_id == 6) grid-report-item light-blue @endif">
                             {{ $ticket->status->name }} </td>
                            <td>{{ $ticket->priority }}</td>
                            <td>
                                    <a href="/tickets/{{ $ticket->url }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="/tickets/edit/{{ $ticket->url }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
