@extends('cms::backend/v1/layout/main')

@push('styles')

@section('navbar', '')

@section('breadcrumb')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('cms::cms.reset_password')</div>
                    <div class="card-body">
                        <form action="{{ route('modules.authentication.backend.v1.authentication.password.reset.update', request()->query()) }}" class="form-horizontal" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="email">@lang('cms::cms.email') *</label>
                                <div class="col-lg-6">
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" readonly required type="email" value="{{ old('email', $user->email) }}" />

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="verification_code">@lang('cms::cms.verification_code') *</label>
                                <div class="col-lg-6">
                                    <input class="form-control {{ $errors->has('verification_code') ? 'is-invalid' : '' }}" id="verification_code" name="verification_code" readonly required type="text" value="{{ old('verification_code', $user->verification_code) }}" />

                                    @if ($errors->has('verification_code'))
                                        <span class="invalid-feedback">{{ $errors->first('verification_code') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="password">@lang('cms::cms.password') *</label>
                                <div class="col-lg-6">
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" required type="password" value="{{ old('password') }}" />

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-4 text-lg-right" for="password_confirmation">@lang('cms::cms.password_confirmation') *</label>
                                <div class="col-lg-6">
                                    <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" required type="password" value="{{ old('password_confirmation') }}" />

                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 offset-lg-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.reset_password')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
