<a href='{{ $music_url . '/' . $record->audio }}' download class='toggle' data-target='editClass'><svg
        class="icon icon-arrow-prev">
        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-download') }}"></use>
    </svg></a>
<a href='javascript:' onclick="deleteRecordAjax('{{ $url . '/' . $record->id }}')" class='toggle'
    data-target='editClass'><svg class="icon icon-arrow-prev">
        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
    </svg></a>
