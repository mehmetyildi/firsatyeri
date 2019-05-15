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
        <th>Kullanıcı Adı</th>
        <th>Kullanıcı Durumu</th>
        <th>Takip Ettiği</th>
        <th>Takip Eden</th>
        <th>İşlem</th>
	@endslot

	@slot('tBody') 
		@foreach($records as $record)
            <tr>
                <td>{{$record->name }}</td>
                <td>{{$record->username}}</td>
                <td>{{$record->role->name}}</td>
                <td>{{count($record->followers()->get())}}</td>
                <td>{{count($record->following()->get())}}</td>
                @include('cms.includes.content-table-actions-with-admin', ['record' => $record, 'pageUrl' => $pageUrl])
            </tr>
        @endforeach
	@endslot

	@slot('contentScripts')

	@endslot

@endcomponent
