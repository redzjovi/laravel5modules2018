{!! csrf_field() !!}
<div>
    <b-card no-body>
        <b-tabs card>
            @foreach (config('cms.locales') as $locale => $localeName)
                <b-tab>
                    <template slot="title">{{ $locale }}</template>
                    <div class="form-group row">
                        <label class="col-sm-2" for="title_{{ $locale }}">@lang('cms::cms.title') *</label>
                        <div class="col-sm-10">
                            <input class="form-control form-control-sm {{ $errors->has('title_'.$locale) ? 'is-invalid ' : '' }}" id="title_{{ $locale }}" name="title_{{ $locale }}" required type="text" value="{{ old('title_'.$locale, $model->{'title_'.$locale}) }}" />

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
            <label class="col-sm-2" for="content">@lang('cms::cms.image')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('page_image') as $medium)
                    <div class="image_p input-group">
                        <img class="img-thumbnail" src="{{ $medium->getFullUrl() }}" style="height: 50px; object-fit: scale-down; width: 50px;" />
                        <input name="image_id[]" type="hidden" value="{{ $medium->id }}" />
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-sm"
                                onclick="$(this).parent().parent().remove()"
                                type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="d-none images_div">
                    <div class="image_p input-group">
                        <input accept="image/*" class="form-control form-control-sm" name="image[]" type="file" />
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-sm"
                                onclick="$(this).parent().parent().remove()"
                                type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary btn-sm"
                    onclick="$('.image_p:last').clone().insertBefore('.images_div');"
                    type="button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="content">@lang('cms::cms.gallery')</label>
            <div class="col-sm-10">
                @foreach ($model->getMedia('page_gallery') as $medium)
                    <div class="gallery_p input-group">
                        <img class="img-thumbnail" src="{{ $medium->getFullUrl() }}" style="height: 50px; object-fit: scale-down; width: 50px;" />
                        <input name="gallery_id[]" type="hidden" value="{{ $medium->id }}" />
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-sm"
                                onclick="$(this).parent().parent().remove()"
                                type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="d-none galleries_div">
                    <div class="gallery_p input-group">
                        <input accept="image/*" class="form-control form-control-sm" name="gallery[]" type="file" />
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-sm"
                                onclick="$(this).parent().parent().remove()"
                                type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary btn-sm"
                    onclick="$('.gallery_p:last').clone().insertBefore('.galleries_div');"
                    type="button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
