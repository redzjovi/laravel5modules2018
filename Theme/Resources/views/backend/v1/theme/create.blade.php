@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.theme.backend.v1.theme.index', request()->query()) }}">@lang('cms::cms.themes')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.theme.backend.v1.theme.store') }}" enctype="multipart/form-data" method="POST">
        @include('theme::backend/v1/theme/_form')
    </form>
@endsection
