@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">User Update</h1>
        </div>
    </div>
    <div class="products">
        <div class="products__container">
            <div class="products__body">
                <form class="login__form" id="add-update">
                    <div class="login__body">
                        <div class="login__title login__title_sm ">User Detail</div>
                        <hr>
                        <div class="row login__field field">
                            <div class="col-12">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <select name="company_id" class="form-control select2">
                                            <option value="">select company </option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}"
                                                    @if ($item->id == $record->company_id) selected @endif>{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row login__field field">
                            <div class="col-4">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="text"
                                            value="{{ $record->first_name }}" name="first_name" placeholder="First Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="text" value="{{ $record->last_name }}"
                                            name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="file" name="image"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row login__field field">
                            <div class="col-6">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="email" name="email"
                                            value="{{ $record->email }}" placeholder="Your email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <select name="user_type" class="form-control">
                                            <option value="">select type </option>
                                            <option value="2" @if ($record->getRoleNames()->first() === 'Executive') selected @endif>
                                                Executive</option>
                                            <option value="3" @if ($record->getRoleNames()->first() === 'Manager') selected @endif>
                                                Manager</option>
                                            {{-- <option value="4" @if ($record->getRoleNames()->first() === 'Staff') selected @endif>Staff
                                            </option> --}}
                                            <option value="6" @if ($record->getRoleNames()->first() === 'Mobile User') selected @endif>Mobile
                                                User
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row login__field field">

                            <div class="col-6">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="password" name="password"
                                            placeholder="Your password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="password" name="password_confirmation"
                                            placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="login__field field">
                            <button type="button"
                                onclick="addFormData(event,'post','{{ url('admin/users/' . $record->id) }}','{{ url('admin/users') }}','add-update')"
                                class="btn btn-sm rounded-pill text-white" style="background-color:#ff5926 ">Update
                            </button>
                            <a href="{{ $url }}" class="btn btn-sm  rounded-pill border-info" style=""
                                type="submit">Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop
@section('script')
@stop
