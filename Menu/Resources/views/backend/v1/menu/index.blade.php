@extends('cms::backend/v1/layout/main')

@push('styles')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active breadcrumb-item">
            <a href="{{ route('modules.menu.backend.v1.menu.index') }}">@lang('cms::cms.menus')</a>
        </li>
    </ol>
@endsection

@section('content')
    @include('menu::backend/v1/menu/_search')

    <div class="row">
        <div class="col-12">
            <form action="{{ route('modules.menu.backend.v1.menu.action') }}" method="POST">
                {!! csrf_field() !!}
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <a class="btn btn-primary btn-sm" href="{{ route('modules.menu.backend.v1.menu.create', request()->query()) }}">@lang('cms::cms.create')</a>
                                </th>
                            </tr>
                            <tr>
                                <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                                <th>{!! $model->sortablelink('title', trans('cms::cms.title')) !!}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                <tr>
                                    <td><input {{ @in_array($menu->id, old('id')) ? 'checked' : '' }} class="table_row_checkbox" name="id[]" type="checkbox" value="{{ $menu->id }}" /></td>
                                    <td>{{ $menu->title }}</td>
                                    <td>
                                        <a href="{{ route('modules.menu.backend.v1.menu.edit', [$menu->id] + request()->query()) }}"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" href="{{ route('modules.menu.backend.v1.menu.delete', $menu->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="3">@lang('cms::cms.no_data')</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">
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
                            @if ($menus->hasPages())
                                <tr>
                                    <th colspan="3">{{ $menus->links('cms::vendor/pagination/bootstrap-4-custom') }}</th>
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
