{!! csrf_field() !!}
<div>
    <b-card no-body>
        <b-tabs card>
            @foreach (config('cms.locales') as $locale => $localeName)
                <b-tab {{ $locale == config('app.locale') ? 'active' : '' }}>
                    <template slot="title">{{ $locale }}</template>
                    <div class="form-group row">
                        <label class="col-sm-2" for="title_{{ $locale }}">
                            @lang('cms::cms.title')
                            @if ($locale == config('app.locale'))*@endif
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control form-control-sm {{ $errors->has('title_'.$locale) ? 'is-invalid ' : '' }}" id="title_{{ $locale }}" name="title_{{ $locale }}" {{ $locale == config('app.locale') ? 'required' : '' }} type="text" value="{{ old('title_'.$locale, $model->{'title_'.$locale}) }}" />

                            @if ($errors->has('title_'.$locale))
                                <span class="invalid-feedback">{{ $errors->first('title_'.$locale) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="slug_{{ $locale }}">@lang('cms::cms.slug')</label>
                        <div class="col-sm-10">
                            <input class="form-control form-control-sm" id="slug_{{ $locale }}" readonly type="text" value="{{ old('slug_'.$locale, $model->{'slug_'.$locale}) }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="excerpt_{{ $locale }}">@lang('cms::cms.excerpt')</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="excerpt_{{ $locale }}" name="excerpt_{{ $locale }}">{{ old('excerpt_'.$locale, $model->{'excerpt_'.$locale}) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="content_{{ $locale }}">@lang('cms::cms.content')</label>
                        <div class="col-sm-10">
                            <textarea-tinymce id="content_{{ $locale }}" name="content_{{ $locale }}" value="{{ old('content_'.$locale, $model->{'content_'.$locale}) }}"></textarea-tinymce>
                        </div>
                    </div>
                </b-tab>
            @endforeach
        </b-tabs>
    </b-card>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="redirect_to">@lang('cms::cms.redirect_to')</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="redirect_to" name="redirect_to" type="text" value="{{ old('redirect_to', $model->redirect_to) }}" />
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.category')</label>
            <div class="col-sm-10">
                <select2 class="form-control form-control-sm" multiple="multiple" name="category_id[]"
                    ajax
                    ajax-data-search="title"
                    ajax-data-sort="title"
                    ajax-process-results-id="id"
                    ajax-process-results-text="title"
                    ajax-url="{{ route('api.v1.category.index') }}"
                    theme="classic"
                >
                    @foreach ($model->categories->sortBy('title') as $category)
                        <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select2>
                <button-prompt-ajax class="btn btn-secondary btn-sm"
                    ajax-name="title_{{ config('app.locale') }}"
                    ajax-url="{{ route('api.v1.category.store') }}"
                >
                    <i class="fas fa-plus"></i>
                </button-prompt-ajax>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.image')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('page_image') as $medium)
                    <input-file-image-default name="image_id[]" src="{{ $medium->getFullUrl() }}" value="{{ $medium->id }}"></input-file-image-default>
                @endforeach

                <input-file-images name="image[]"></input-file-images>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.gallery')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('page_gallery') as $medium)
                    <input-file-image-default name="gallery_id[]" src="{{ $medium->getFullUrl() }}" value="{{ $medium->id }}"></input-file-image-default>
                @endforeach

                <input-file-images name="gallery[]"></input-file-images>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.tag')</label>
            <div class="col-sm-10">
                <select2 class="form-control form-control-sm" multiple="multiple" name="tag_id[]"
                    ajax
                    ajax-data-search="title"
                    ajax-data-sort="title"
                    ajax-process-results-id="id"
                    ajax-process-results-text="title"
                    ajax-url="{{ route('api.v1.tag.index') }}"
                    theme="classic"
                >
                    @foreach ($model->tags->sortBy('title') as $tag)
                        <option selected value="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                </select2>
                <button-prompt-ajax class="btn btn-secondary btn-sm"
                    ajax-name="title_{{ config('app.locale') }}"
                    ajax-url="{{ route('api.v1.tag.store') }}"
                >
                    <i class="fas fa-plus"></i>
                </button-prompt-ajax>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
