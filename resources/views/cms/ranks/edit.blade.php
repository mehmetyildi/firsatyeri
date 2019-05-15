@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

	@component('cms.components.breadcrumb')
		@slot('page') Düzenle @endslot
		<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
	@endcomponent

	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			{!! Form::model($record, ['route' => ['cms.'.$pageUrl.'.update', $record->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
			{!! method_field('PUT') !!}
			<div class="col-lg-1 formActions">
				<a href="{{ route('cms.'.$pageUrl.'.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>

					<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>

					<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Sil</button>
			</div>
			<div class="col-lg-6">

				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-info-circle"></i> İçerik Bilgileri</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						<div class="form-group">
							<label class="col-sm-3 control-label">Adı</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab-title_tr"> TR</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab-title_tr" class="tab-pane active">
										{!! Form::text('name', null, ['class' => 'form-control']) !!}
									</div>

								</div>
								<div class="error" style="color: red;">{{ $errors->first('name') }}</div>
							</div>
						</div>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hirararşik Sıra</label>
                            <div class="col-sm-9">
                                {!! Form::number('order', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="error" style="color: red;">{{ $errors->first('order') }}</div>
                        </div>
					</div>
				</div>
			</div>
            


			{!! Form::close() !!}
		</div>
	</div>

	<!-- Delete Object Modal -->

	<!-- End Delete Object Modal -->

	<!-- Delete Object Modal -->
	@include('cms.includes.delete-object-modal', [
        'modal_id' => 'deleteLogo',
        'field' => 'image_path',
        'route' => 'cms.'.$pageUrl.'.delete-file',
        'id' => ['record' => $record->id]
    ])
	<!-- End Delete Object Modal -->

	<!-- Delete Modal -->
	@include('cms.includes.delete-modal', [
        'modal_id' => 'deleteModal',
        'route' => 'cms.'.$pageUrl.'.delete',
        'id' => ['role' => $record->id]
    ])
	<!-- End Delete Modal -->
@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
	<script>
        $(document).ready(function(){
            new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
            new Switchery(document.querySelector('.js-switch2'), { color: '#1AB394' });
            $("#sector_list").select2({placeholder: 'Sektörleri Seçiniz'});
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
        });
	</script>
@endsection
