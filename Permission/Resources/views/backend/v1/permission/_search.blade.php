<form action="{{ route('modules.permission.backend.v1.permission.index') }}" method="GET">
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
                    <label class="col-sm-2" for="guard_name">@lang('cms::cms.guard_name')</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm" id="guard_name" name="guard_name">
                            <option></option>
                            @foreach ($model->getGuardNameOptions() as $guardName => $guardNameDescription)
                                <option {{ $guardName == request()->query('guard_name') ? 'selected' : '' }} value="{{ $guardName }}">{{ $guardNameDescription }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <a class="btn btn-secondary btn-sm" href="{{ route('modules.permission.backend.v1.permission.index') }}">
                    <i class="fas fa-sync"></i>
                </a>
                <a class="btn btn-primary btn-sm" href="{{ route('modules.permission.backend.v1.permission.export-csv', request()->query()) }}">
                    <i class="fas fa-file-export"></i>
                    @lang('cms::cms.csv')
                </a>
            </div>
        </div>
    </div>
</form>
<br />
