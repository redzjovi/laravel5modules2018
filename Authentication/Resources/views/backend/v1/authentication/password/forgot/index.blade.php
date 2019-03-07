@extends('cms::backend/v1/layout/main')

@push('styles')

@section('navbar', '')

@section('breadcrumb')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div align="center" class="card-header">
                        <div class="float-left">
                            <a href="{{ route('modules.authentication.backend.v1.authentication.login.index', request()->query()) }}">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                        @lang('cms::cms.forgot_password')
                    </div>
                    <div class="card-body">
                        <form action="{{ route('modules.authentication.backend.v1.authentication.password.forgot.store', request()->query()) }}" class="form-horizontal" id="form_forgot" method="POST">
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
                                <div class="col-lg-8 offset-lg-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.send_password_reset_link')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
