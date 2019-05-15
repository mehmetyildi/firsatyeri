@component('cms.components.content-listing-no-create')

	@slot('pageUrl') 
		{{ $pageUrl }} 
	@endslot

	@slot('pageName') 
		{{ $pageName }} 
	@endslot

	@slot('pageItem') 
		{{ $pageItem }} 
	@endslot

	@slot('tHead')
		<th>Adı</th>
        <th>Sahibi</th>
        <th>Kullanıcı Sayısı</th>
        <th>Yeri</th>
        <th>İşlem</th>
	@endslot

	@slot('tBody') 
		@foreach($records as $record)
            <tr>
                <td>{{ $record->name }}</td>
                <td>{{$record->creator->username}}</td>
                <td>{{count($record->users()->get())+1}}</td>
                <td>{{$record->city->name}}</td>
                @include('cms.includes.content-table-actions-no-edit', ['record' => $record, 'pageUrl' => $pageUrl])
            </tr>
        @endforeach
	@endslot

	@slot('contentScripts')

	@endslot

@endcomponent
