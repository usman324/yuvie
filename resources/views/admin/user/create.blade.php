@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">User Create</h1>
        </div>
    </div>
    <div class="products">
        <div class="products__container">
            <div class="products__body">
                <form class="login__form" id="add-user">
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
                                                    @if (request()->q == $item->id) selected @endif>{{ $item->name }}
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
                                        <input class="field__input" required type="text" name="first_name"
                                            placeholder="First Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <input class="field__input" required type="text" name="last_name"
                                            placeholder="Last Name">
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
                                            placeholder="Your email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="login__field field">
                                    <div class="field__wrap">
                                        <select name="user_type" class="form-control">
                                            <option value="">select type </option>
                                            <option value="2">Executive</option>
                                            <option value="3">Manager</option>
                                            {{-- <option value="4">Staff</option> --}}
                                            <option value="6">Mobile User</option>
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
                                onclick="addFormData(event,'post','{{ url('admin/users') }}','{{ url('admin/users') }}','add-user')"
                                class="btn btn-sm rounded-pill text-white" style="background-color:#ff5926 ">Add
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script> --}}
@stop
