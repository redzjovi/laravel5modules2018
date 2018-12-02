<form action="{{ route('modules.user.backend.v1.user.index') }}" method="GET">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-link btn-sm" data-target="#collapse_search" data-toggle="collapse" type="button">@lang('cms::cms.search')</button>
        </div>
        <div class="collapse" id="collapse_search">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2" for="name">@lang('cms::cms.name')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="name" name="name" type="text" value="{{ request()->query('name') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="email">@lang('cms::cms.email')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="email" name="email" type="text" value="{{ request()->query('email') }}" />
                    </div>
                </div>

                @can('modules.user.backend.v1.user.role.*')
                    <hr />
                    <div class="form-group row">
                        <label class="col-sm-2" for="role_id">@lang('cms::cms.roles')</label>
                        <div class="col-sm-10">
                            <select class="form-control form-control-sm" id="role_id" multiple name="role_id[]"
                                @if (Agent::isDesktop())
                                    bootstrap-select="true"
                                @endif
                                data-live-search="true"
                                multiple data-actions-box="true"
                            >
                                @foreach ($roles as $role)
                                    <option {{ in_array($role->id, request()->query('role_id', [])) ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <a class="btn btn-secondary btn-sm" href="{{ route('modules.user.backend.v1.user.index') }}">
                    <i class="fas fa-sync"></i>
                </a>
                <a class="btn btn-primary btn-sm" href="{{ route('modules.user.backend.v1.user.export-csv', request()->query()) }}">
                    <i class="fas fa-file-export"></i>
                    @lang('cms::cms.csv')
                </a>
            </div>
        </div>
    </div>
</form>
<br />
