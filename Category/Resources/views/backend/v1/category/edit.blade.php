@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.category.backend.v1.category.index', request()->query()) }}">@lang('cms::cms.categories')</a>
        </li>
        <li class="active breadcrumb-item">{{ $model->id }}</li>
        <li class="active breadcrumb-item">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.category.backend.v1.category.update', $model->id) }}" enctype="multipart/form-data" method="POST">
        {!! method_field('PUT') !!}
        <input name="id" type="hidden" value="{{ $model->id }}" />
        @include('category::backend/v1/category/_form')
    </form>
@endsection
