@extends('admin.layout.master')
@section('style')
    <title>{{ $title }}</title>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }} List</h1>
            <div class="sorting1__variants">
                <div class="sorting1__text">Show:</div><select class="sorting1__select">
                    <option selected>All {{ $title }}</option>
                    <option>All {{ $title }}</option>
                </select>
            </div>
            <div class="sorting1__options">
                <div class="dropdown js-dropdown"><a class="dropdown__head js-dropdown-head" href="#">
                        <div class="dropdown__text">Sort by:</div>
                        <div class="dropdown__category">Default</div>
                    </a>
                    <div class="dropdown__body js-dropdown-body">
                        <label class="checkbox checkbox_sm checkbox_green">
                            <input class="checkbox__input" type="checkbox" />
                            <span class="checkbox__in"><span class="checkbox__tick"></span><span
                                    class="checkbox__text">Project
                                    Name</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" checked="checked" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Newest
                                    Project</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" checked="checked" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Due
                                    Date</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Project
                                    Type</span></span></label>
                    </div>
                </div>
                <a class="sorting1__filters" href="#">
                    <svg class="icon icon-filters">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-filters') }}"></use>
                    </svg>
                </a>
                <a href="{{ $url . '/create' }}" class="sorting1__btn btn rounded-pill text-white"
                    style="background-color:#ff5926 "><svg class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">New User</span>
                </a>
            </div>
        </div>
    </div>
    <div class="products">
        <div class="products__container">
            <div class="products__body">
                <div class="products__head">
                    <div class="products__search"><button class="products__open"><svg class="icon icon-search">
                                <use xlink:href="img/sprite.svg#icon-search"></use>
                            </svg></button><input class="products__input" type="text" placeholder="Search…"></div><select
                        class="products__select">
                        <option>Action</option>
                        <option>Action</option>
                        <option>Action</option>
                    </select>
                </div>
                <div class="products__table">
                    <div class="products__row products__row_head">
                        <div class="products__cell"><label class="checkbox checkbox_green checkbox_big"><input
                                    class="checkbox__input" type="checkbox"><span class="checkbox__in"><span
                                        class="checkbox__tick"></span></span></label></div>
                        <div class="products__cell">#Id</div>
                        <div class="products__cell">First Name</div>
                        <div class="products__cell">Last Name</div>
                        <div class="products__cell">Email</div>
                        <div class="products__cell">Action</div>
                    </div>
                    @foreach ($records as $item)
                        <div class="products__row">
                            <div class="products__cell"><label class="checkbox checkbox_green checkbox_big"><input
                                        class="checkbox__input" type="checkbox"><span class="checkbox__in"><span
                                            class="checkbox__tick"></span></span></label></div>
                            <div class="products__cell">
                                <div class="products__details">
                                    <div class="products__preview"></div>
                                    <div class="products__title">{{ $item->id }}</div>
                                </div>
                            </div>
                            <div class="products__cell">{{ $item->first_name }}</div>
                            <div class="products__cell"><span
                                    class="products__note">id</span><span>{{ $item->last_name }}</span></div>
                            <div class="products__cell"><span
                                    class="products__note">stock</span><span>{{ $item->email }}</span></div>
                            <div class="products__cell">
                                <a href='{{ $url . '/' . $item->id . '/edit' }}' class='toggle' data-target='editClass'><em
                                        class='icon ni ni-edit'></em><span>Edit</span></a>
                                <a href='javascript:'   onclick='deleteRecordAjax("{{$url."/".$item->id}}")' class='toggle' data-target='editClass'><em
                                        class='icon ni ni-edit'></em><span>Delete</span></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="products__foot">
            <div class="products__counter">1-10 of 195 items</div>
            <div class="pagination">
              <div class="pagination__wrap"><a class="pagination__arrow" href="#"><svg class="icon icon-arrow-prev">
                    <use xlink:href="img/sprite.svg#icon-arrow-prev"></use>
                  </svg></a>
                <div class="pagination__list"><a class="pagination__link active" href="#">1</a><a class="pagination__link" href="#">2</a><a class="pagination__link" href="#">3</a><a class="pagination__link" href="#">4</a><a class="pagination__link" href="#">5</a><a class="pagination__link" href="#">...</a><a class="pagination__link" href="#">19</a></div><a class="pagination__arrow" href="#"><svg class="icon icon-arrow-next">
                    <use xlink:href="img/sprite.svg#icon-arrow-next"></use>
                  </svg></a>
              </div>
              <div class="pagination__view"><select class="pagination__select">
                  <option>10</option>
                  <option>20</option>
                  <option>30</option>
                </select>
                <div class="pagination__icon"><svg class="icon icon-arrows">
                    <use xlink:href="img/sprite.svg#icon-arrows"></use>
                  </svg></div>
              </div>
            </div>
          </div> --}}
        </div>
    </div>
@stop
@section('script')
@stop
