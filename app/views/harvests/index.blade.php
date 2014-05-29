@extends('layouts.admin')

@section('title')
@parent
- login
@stop

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Spice Harvester</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Harvests
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
            	<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>URL</th>
                            <th>Set</th>
                            <th>Metadata Prefix</th>
                            <th>Status</th>
                            <th>Akcie</th>
                        </tr>
                    </thead>
                    <tbody>
						@foreach($harvests as $h)
			            <tr>
			                <td>{{ $h->id }}</td>
			                <td>{{ $h->base_url }}</td>
			                <td>{{ $h->set_name }}</td>
			                <td>{{ $h->metadata_prefix }}</td>
			                <td>{{ $h->status . ' ' . date("d. m. Y",strtotime($h->updated_at)) }}</td>
			                <td>{{ link_to_action('SpiceHarvesterController@launch', 'Spustiť', array($h->id), array('class' => 'btn btn-default')) }}</td>
			            </tr>
						@endforeach
                    </tbody>
                </table>


            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@stop