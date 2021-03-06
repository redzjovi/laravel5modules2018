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
                        <label class="col-sm-2" for="excerpt_{{ $locale }}">@lang('cms::cms.excerpt')</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm" id="excerpt_{{ $locale }}" name="excerpt_{{ $locale }}">{{ old('excerpt_'.$locale, $model->{'excerpt_'.$locale}) }}</textarea>
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
            <label class="col-sm-2" for="content">@lang('cms::cms.nestable')</label>
            <div class="col-sm-10">
                <menu-nestable name="nestable" :value="{{ $model->nestable ? $model->nestable : '[]' }}"></menu-nestable>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.image')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('tag_image') as $medium)
                    <input-file-image-default name="image_id[]" src="{{ $medium->getFullUrl() }}" value="{{ $medium->id }}"></input-file-image-default>
                @endforeach

                <input-file-images name="image[]"></input-file-images>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.gallery')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('tag_gallery') as $medium)
                    <input-file-image-default name="gallery_id[]" src="{{ $medium->getFullUrl() }}" value="{{ $medium->id }}"></input-file-image-default>
                @endforeach

                <input-file-images name="gallery[]"></input-file-images>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
