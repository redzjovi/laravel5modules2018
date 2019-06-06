{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="group">
                @lang('cms::cms.group') *
            </label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm {{ $errors->has('group') ? 'is-invalid ' : '' }}" id="group" name="group" required type="text" value="{{ old('group', $model->group) }}" />

                @if ($errors->has('group'))
                    <span class="invalid-feedback">{{ $errors->first('group') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="section">
                @lang('cms::cms.section') *
            </label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm {{ $errors->has('section') ? 'is-invalid ' : '' }}" id="section" name="section" required type="text" value="{{ old('section', $model->section) }}" />

                    @if ($errors->has('section'))
                    <span class="invalid-feedback">{{ $errors->first('section') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="type">
                @lang('cms::cms.type') *
            </label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm {{ $errors->has('type') ? 'is-invalid ' : '' }}" id="type" name="type" required type="text" value="{{ old('type', $model->type) }}" />

                @if ($errors->has('type'))
                    <span class="invalid-feedback">{{ $errors->first('type') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="value">
                @lang('cms::cms.value') *
            </label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm {{ $errors->has('value') ? 'is-invalid ' : '' }}" id="value" name="value" required type="text" value="{{ old('value', $model->value) }}" />

                @if ($errors->has('value'))
                    <span class="invalid-feedback">{{ $errors->first('value') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
<div>
    <b-card no-body>
        <b-tabs card>
            @foreach (config('cms.locales') as $locale => $localeName)
                <b-tab {{ $locale == config('app.locale') ? 'active' : '' }}>
                    <template slot="title">{{ $locale }}</template>
                    <div class="form-group row">
                        <label class="col-sm-2" for="title_{{ $locale }}">
                            @lang('cms::cms.title')
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control form-control-sm" id="title_{{ $locale }}" name="title_{{ $locale }}" type="text" value="{{ old('title_'.$locale, $model->{'title_'.$locale}) }}" />
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
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
