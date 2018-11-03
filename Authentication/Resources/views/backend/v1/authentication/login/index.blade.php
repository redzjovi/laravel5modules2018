@extends('cms::backend/v1/layout/main')

@push('styles')

@section('navbar', '')

@section('breadcrumb')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div align="center" class="card-header">@lang('cms::cms.login')</div>
                    <div class="card-body">
                        <form action="{{ route('modules.authentication.backend.v1.authentication.login.store', request()->query()) }}" class="form-horizontal" id="form_login" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="email">@lang('cms::cms.email') *</label>
                                <div class="col-lg-6">
                                    <input autofocus class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" required type="email" value="{{ old('email') }}" />

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="password">@lang('cms::cms.password') *</label>
                                <div class="col-lg-6">
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" required type="password" />

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 offset-lg-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input {{ old('remember') ? 'checked' : '' }} class="form-check-input" name="remember" type="checkbox" />@lang('cms::cms.remember_me')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 offset-lg-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.login')</button>
                                    <a class="btn btn-link" href="{{ route('modules.authentication.backend.v1.authentication.password.forgot.index', request()->query()) }}">@lang('cms::cms.forgot_password')?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('\Modules\Authentication\Http\Requests\Api\V1\Authentication\Login\StoreRequest', '#form_login') !!}
@endpush
