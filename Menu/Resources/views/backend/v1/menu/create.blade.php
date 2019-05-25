@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.menu.backend.v1.menu.index', request()->query()) }}">@lang('cms::cms.menus')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.menu.backend.v1.menu.store') }}" enctype="multipart/form-data" method="POST">
        @include('menu::backend/v1/menu/_form')
    </form>
@endsection
