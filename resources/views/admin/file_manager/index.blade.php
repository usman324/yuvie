@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }}</h1>
            
            <div class="sorting1__options">
               
                <a href="{{ $url.'/create' }}"
                    class="sorting1__btn btn rounded-pill text-white" style="background-color:#ff5926 "><svg
                        class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">Add New</span>
                </a>
            </div>
        </div>
    </div>
    <div class="products">
        <div class="products__container">
            <div class="products__body">
                <table id="myTable" class="table rounded table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($records as $item)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href='{{ $url . '/' . $item->id . '/edit' }}' class='toggle'
                                        data-target='editClass'><svg class="icon icon-arrow-prev">
                                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-edit') }}"></use>
                                        </svg></a>
                                    <a href='javascript:' onclick="deleteRecordAjax('{{ $url . '/' . $item->id }}')"
                                        class='toggle' data-target='editClass'><svg class="icon icon-arrow-prev">
                                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
                                        </svg></a>
                                </td>
                            </tr>

                            <?php
                            $i++;
                            ?>
                        @endforeach


                    </tbody>
                </table>

            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        function getMusic(e) {
            let company = e.target.value;
            window.location.href = "{{ url('admin/background-musics?company=') }}" + company
        }
    </script>
@stop
