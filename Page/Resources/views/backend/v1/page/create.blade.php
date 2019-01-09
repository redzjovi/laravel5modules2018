@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.page.backend.v1.page.index', request()->query()) }}">@lang('cms::cms.pages')</a>
        </li>
        <li class="active breadcrumb-item">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.page.backend.v1.page.store') }}" enctype="multipart/form-data" id="form_page" method="POST">
        @include('page::backend/v1/page/_form')
    </form>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('\Modules\Page\Http\Requests\Api\V1\Page\StoreRequest', '#form_page') !!}
@endpush
