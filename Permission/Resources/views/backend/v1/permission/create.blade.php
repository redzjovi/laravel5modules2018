@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.permission.backend.v1.permission.index', request()->query()) }}">@lang('cms::cms.permissions')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.permission.backend.v1.permission.store') }}" id="form_permission" method="POST">
        @include('permission::backend/v1/permission/_form')
    </form>
@endsection
