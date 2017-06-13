<div class="row">
    <div class="col-md-12">
        <div class="box box-info ">
            <div class="box-header with-border clearfix">
                <div class="box-title">
                    <i class="fa fa-newspaper-o"></i>
                    Estado Tiquetes Soporte
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('1'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['1'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                        <p>Ingresado</p>
                        </div>
                        <div class="icon">
                        <i class="ion-ios-plus-outline"></i>
                        </div>
                    <a href="{{ route('tickets.list', 1) }}" class="small-box-footer">
                    Ver Mas
                    <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('2'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['2'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                            <p>Accion de Usuario </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('tickets.list', 2) }}" class="small-box-footer">
                        Ver Mas
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-green">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('3'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['3'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                            <p>Mesa de Ayuda </p>
                        </div>
                        <div class="icon">
                            <i class="ion-ios-paper"></i>
                        </div>
                        <a href="{{ route('tickets.list', 3) }}" class="small-box-footer">
                        Ver Mas
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-light-blue">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('6'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['6'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                            <p>Compunet</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-refresh"></i>
                        </div>
                        <a href="{{ route('tickets.list', 6) }}" class="small-box-footer">
                        Ver Mas
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-purple">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('4'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['4'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                            <p>Cerrado</p>
                        </div>
                        <div class="icon">
                            <i class="ion-locked"></i>
                        </div>
                        <a href="{{ route('tickets.list', 4) }}" class="small-box-footer">
                        Ver Mas
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                 <div class="col-lg-2 col-xs-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                        @if($tickets->pluck('status_id')->contains('5'))
                        <h3>{{  $tickets->pluck('status_id')->intersect(['5'])->count() }}</h3>
                        @else
                        <h3>0</h3>
                        @endif
                            <p>Eliminado </p>
                        </div>
                        <div class="icon">
                            <i class="ion-trash-a"></i>
                        </div>
                        <a href="{{ route('tickets.list', 5) }}" class="small-box-footer">
                        Ver Mas
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
