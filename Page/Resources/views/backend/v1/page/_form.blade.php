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
