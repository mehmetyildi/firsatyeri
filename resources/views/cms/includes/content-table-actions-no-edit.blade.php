<td class="center actionsColumn">

	<button type="button" 
			class="btn btn-danger btn-sm" 
			data-toggle="modal" 
			data-target="#deleteModal{{ $record->id }}"><i class="fa fa-trash"></i>
	</button>
	@include('cms.includes.delete-modal', [ 
		'modal_id' => 'deleteModal'.$record->id, 
		'route' => 'cms.'.$pageUrl.'.delete', 
		'id' => ['role' => $record->id]
	]) 

</td>
