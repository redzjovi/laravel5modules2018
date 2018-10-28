@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.permission.backend.v1.permission.index', request()->query()) }}">@lang('cms::cms.permissions')</a>
        </li>
        <li class="active breadcrumb-item">{{ $model->id }}</li>
        <li class="active breadcrumb-item">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.permission.backend.v1.permission.update', $model->id) }}" id="form_permission" method="POST">
        {!! method_field('PUT') !!}
        <input name="id" type="hidden" value="{{ $model->id }}" />
        @include('permission::backend/v1/permission/_form')
    </form>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('\Modules\Permission\Http\Requests\Backend\V1\Permission\UpdateRequest', '#form_permission') !!}
@endpush