<form action="{{ route('modules.tag.backend.v1.tag.index') }}" method="GET">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-link btn-sm" data-target="#collapse_search" data-toggle="collapse" type="button">@lang('cms::cms.search')</button>
        </div>
        <div class="collapse" id="collapse_search">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2" for="title">@lang('cms::cms.title')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="title" name="title" type="text" value="{{ request()->query('title') }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="slug">@lang('cms::cms.slug')</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" id="slug" name="slug" type="text" value="{{ request()->query('slug') }}" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <a class="btn btn-secondary btn-sm" href="{{ route('modules.tag.backend.v1.tag.index') }}">
                    <i class="fas fa-sync"></i>
                </a>
                <a class="btn btn-primary btn-sm" href="{{ route('modules.tag.backend.v1.tag.export-csv', request()->query()) }}">
                    <i class="fas fa-file-export"></i>
                    @lang('cms::cms.csv')
                </a>
            </div>
        </div>
    </div>
</form>
<br />
