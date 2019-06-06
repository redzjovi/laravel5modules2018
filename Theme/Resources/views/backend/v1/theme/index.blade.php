@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active breadcrumb-item">
            <a href="{{ route('modules.theme.backend.v1.theme.index') }}">@lang('cms::cms.themes')</a>
        </li>
    </ol>
@endsection

@section('content')
    @include('theme::backend/v1/theme/_search')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('modules.theme.backend.v1.theme.action') }}" method="POST">
                {!! csrf_field() !!}
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <a class="btn btn-primary btn-sm" href="{{ route('modules.theme.backend.v1.theme.create', request()->query()) }}">@lang('cms::cms.create')</a>
                                </th>
                            </tr>
                            <tr>
                                <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                                <th>{!! $model->sortablelink('group', trans('cms::cms.group')) !!}</th>
                                <th>{!! $model->sortablelink('section', trans('cms::cms.section')) !!}</th>
                                <th>{!! $model->sortablelink('type', trans('cms::cms.type')) !!}</th>
                                <th>{!! $model->sortablelink('value', trans('cms::cms.value')) !!}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($themes as $theme)
                                <tr>
                                    <td><input {{ @in_array($theme->id, old('id')) ? 'checked' : '' }} class="table_row_checkbox" name="id[]" type="checkbox" value="{{ $theme->id }}" /></td>
                                    <td>{{ $theme->group }}</td>
                                    <td>{{ $theme->section }}</td>
                                    <td>{{ $theme->type }}</td>
                                    <td>{{ $theme->value }}</td>
                                    <td>
                                        <a href="{{ route('modules.theme.backend.v1.theme.edit', [$theme->id] + request()->query()) }}"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" href="{{ route('modules.theme.backend.v1.theme.delete', $theme->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">@lang('cms::cms.no_data')</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6">
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
                            @if ($themes->hasPages())
                                <tr>
                                    <th colspan="6">{{ $themes->links('cms::vendor/pagination/bootstrap-4-custom') }}</th>
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
