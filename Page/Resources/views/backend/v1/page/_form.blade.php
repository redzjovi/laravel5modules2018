{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="title">@lang('cms::cms.title') *</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="title" name="title" required type="text" value="{{ old('title', $model->title) }}" />

                @if ($errors->has('title'))
                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="slug">@lang('cms::cms.slug')</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" readonly type="text" value="{{ $model->slug }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="excerpt">@lang('cms::cms.excerpt')</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="excerpt">{{ $model->excerpt }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.content')</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="content">{{ $model->content }}</textarea>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
