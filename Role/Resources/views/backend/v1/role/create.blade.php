@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.role.backend.v1.role.index', request()->query()) }}">@lang('cms::cms.roles')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.role.backend.v1.role.store') }}" id="form_role" method="POST">
        @include('role::backend/v1/role/_form')
    </form>
@endsection
