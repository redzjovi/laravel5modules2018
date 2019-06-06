<form action="{{ route('modules.theme.backend.v1.theme.index') }}" method="GET">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-link btn-sm" data-target="#collapse_search" data-toggle="collapse" type="button">@lang('cms::cms.search')</button>
        </div>
        <div class="collapse" id="collapse_search">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2" for="group">@lang('cms::cms.group')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="group" name="group" type="text" value="{{ request()->query('group') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="section">@lang('cms::cms.section')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="section" name="section" type="text" value="{{ request()->query('section') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="type">@lang('cms::cms.type')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="type" name="type" type="text" value="{{ request()->query('type') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="value">@lang('cms::cms.value')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="value" name="value" type="text" value="{{ request()->query('value') }}" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <a class="btn btn-secondary btn-sm" href="{{ route('modules.theme.backend.v1.theme.index') }}">
                    <i class="fas fa-sync"></i>
                </a>
                <a class="btn btn-primary btn-sm" href="{{ route('modules.theme.backend.v1.theme.export-csv', request()->query()) }}">
                    <i class="fas fa-file-export"></i>
                    @lang('cms::cms.csv')
                </a>
            </div>
        </div>
    </div>
</form>
<br />
