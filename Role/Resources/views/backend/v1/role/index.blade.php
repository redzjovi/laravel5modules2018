@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active breadcrumb-item">
            <a href="{{ route('modules.role.backend.v1.role.index') }}">@lang('cms::cms.roles')</a>
        </li>
    </ol>
@endsection

@section('content')
    @include('role::backend/v1/role/_search')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('modules.role.backend.v1.role.action') }}" id="form_role" method="POST">
                {!! csrf_field() !!}
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    <a class="btn btn-primary btn-sm" href="{{ route('modules.role.backend.v1.role.create', request()->query()) }}">@lang('cms::cms.create')</a>
                                </th>
                            </tr>
                            <tr>
                                <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                                <th>{!! $model->sortablelink('name', trans('cms::cms.name')) !!}</th>
                                <th>{!! $model->sortablelink('guard_name', trans('cms::cms.guard_name')) !!}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td><input {{ @in_array($role->id, old('id')) ? 'checked' : '' }} class="table_row_checkbox" name="id[]" type="checkbox" value="{{ $role->id }}" /></td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>
                                        <a href="{{ route('modules.role.backend.v1.role.edit', [$role->id] + request()->query()) }}"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" href="{{ route('modules.role.backend.v1.role.delete', $role->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fas fa-trash"></i></a>
                                        @can('modules.role.backend.v1.role.permission.*')
                                            <a href="{{ route('modules.role.backend.v1.role.permission.edit', [$role->id] + request()->query()) }}">@lang('cms::cms.permissions')</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">@lang('cms::cms.no_data')</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">
                                    <i class="text-danger">{{ $errors->first('id') }}</i>
                                    <div class="input-group">
                                        <select name="action" required>
                                            <option value=""></option>
                                            <option {{ old('action') == 'actionDelete' ? 'selected' : '' }} value="actionDelete">@lang('cms::cms.delete')</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-success" type="submit">@lang('cms::cms.apply')</button>
                                        </div>
                                    </div>
                                    <i class="text-danger">{{ $errors->first('action') }}</i>
                                </th>
                            </tr>
                            @if ($roles->hasPages())
                                <tr>
                                    <th colspan="4">{{ $roles->links('cms::vendor/pagination/bootstrap-4-custom') }}</th>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div><!-- end of class table-responsive -->
            </form>
        </div>
    </div>
@endsection

@push('scripts')
