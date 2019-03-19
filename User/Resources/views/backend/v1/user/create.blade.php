@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.user.backend.v1.user.index', request()->query()) }}">@lang('cms::cms.users')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.user.backend.v1.user.store') }}" method="POST">
        @include('user::backend/v1/user/_form')
    </form>
@endsection
