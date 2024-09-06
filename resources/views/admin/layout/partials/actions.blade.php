<a href='{{ $url . '/' . $record->id . '/edit' }}' class='toggle' data-target='editClass'><svg class="icon icon-arrow-prev">
        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-edit') }}"></use>
    </svg></a>
<a href='javascript:' onclick="deleteRecordAjax('{{ $url . '/' . $record->id }}')" class='toggle'
    data-target='editClass'><svg class="icon icon-arrow-prev">
        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
    </svg></a>
