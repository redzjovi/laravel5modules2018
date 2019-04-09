@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.tag.backend.v1.tag.index', request()->query()) }}">@lang('cms::cms.tags')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.tag.backend.v1.tag.store') }}" enctype="multipart/form-data" method="POST">
        @include('tag::backend/v1/tag/_form')
    </form>
@endsection
