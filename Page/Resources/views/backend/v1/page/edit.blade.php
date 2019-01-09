@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.page.backend.v1.page.index', request()->query()) }}">@lang('cms::cms.pages')</a>
        </li>
        <li class="active breadcrumb-item">{{ $model->id }}</li>
        <li class="active breadcrumb-item">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.page.backend.v1.page.update', $model->id) }}" enctype="multipart/form-data" id="form_page" method="POST">
        {!! method_field('PUT') !!}
        <input name="id" type="hidden" value="{{ $model->id }}" />
        @include('page::backend/v1/page/_form')
    </form>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('\Modules\Page\Http\Requests\Api\V1\Page\UpdateRequest', '#form_page') !!}
@endpush
