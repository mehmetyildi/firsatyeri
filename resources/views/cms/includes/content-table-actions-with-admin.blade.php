<td class="center actionsColumn">

    @if($record->role_id==2)
	<button type="button" 
			class="btn btn-success btn-sm"
			data-toggle="modal" 
			data-target="#promoteModal{{ $record->id }}"><i class="fa fa-thumbs-up"></i>
	</button>
	@include('cms.includes.promote_user_modal', [
		'modal_id' => 'promoteModal'.$record->id,
		'route' => 'cms.'.$pageUrl.'.promote',
		'user' => $record->id
	])
    @endif
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
