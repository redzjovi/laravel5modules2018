@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.category.backend.v1.category.index', request()->query()) }}">@lang('cms::cms.categories')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.category.backend.v1.category.store') }}" enctype="multipart/form-data" method="POST">
        @include('category::backend/v1/category/_form')
    </form>
@endsection
