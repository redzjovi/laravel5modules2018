@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('modules.role.backend.v1.role.index', request()->query()) }}">@lang('cms::cms.roles')</a>
        </li>
        <li class="active breadcrumb-item">{{ $model->id }}</li>
        <li class="active breadcrumb-item">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('modules.role.backend.v1.role.update', $model->id) }}" id="form_role" method="POST">
        {!! method_field('PUT') !!}
        <input name="id" type="hidden" value="{{ $model->id }}" />
        @include('role::backend/v1/role/_form')
    </form>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('\Modules\Role\Http\Requests\Backend\V1\Role\UpdateRequest', '#form_role') !!}
@endpush
