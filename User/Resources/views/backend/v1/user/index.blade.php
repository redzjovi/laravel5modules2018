@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active breadcrumb-item">
            <a href="{{ route('modules.user.backend.v1.user.index') }}">@lang('cms::cms.users')</a>
        </li>
    </ol>
@endsection

@section('content')
    @include('user::backend/v1/user/_search')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('modules.user.backend.v1.user.action') }}" method="POST">
                {!! csrf_field() !!}
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <a class="btn btn-primary btn-sm" href="{{ route('modules.user.backend.v1.user.create', request()->query()) }}">@lang('cms::cms.create')</a>
                                </th>
                            </tr>
                            <tr>
                                <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                                <th>{!! $model->sortablelink('name', trans('cms::cms.name')) !!}</th>
                                <th>{!! $model->sortablelink('email', trans('cms::cms.email')) !!}</th>
                                @can('modules.user.backend.v1.user.role.*')
                                    <th>@lang('cms::cms.roles')</th>
                                @endcan
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td><input {{ @in_array($user->id, old('id')) ? 'checked' : '' }} class="table_row_checkbox" name="id[]" type="checkbox" value="{{ $user->id }}" /></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @can('modules.user.backend.v1.user.role.*')
                                        <td>
                                            @if ($roles = $user->roles->sortBy('name'))
                                                <ul>
                                                    @foreach ($roles as $role)
                                                        <li>
                                                            @can('modules.role.backend.v1.role.permission.*')
                                                                <a href="{{ route('modules.role.backend.v1.role.permission.edit', $role->id) }}">{{ $role->name }}</a>
                                                            @else
                                                                {{ $role->name }}
                                                            @endcan
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('modules.user.backend.v1.user.edit', [$user->id] + request()->query()) }}"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" href="{{ route('modules.user.backend.v1.user.delete', $user->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">@lang('cms::cms.no_data')</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">
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
                            @if ($users->hasPages())
                                <tr>
                                    <th colspan="5">{{ $users->links('cms::vendor/pagination/bootstrap-4-custom') }}</th>
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
