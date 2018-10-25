{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="name">@lang('cms::cms.name') *</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="name" name="name" required type="text" value="{{ old('name', $model->name) }}" />

                @if ($errors->has('name'))
                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="email">@lang('cms::cms.email') *</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="email" name="email" required type="email" value="{{ old('email', $model->email) }}" />

                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="password">
                @lang('cms::cms.password')
                @if (! $model->id) * @endif
            </label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="password" name="password"
                    @if (! $model->id) required @endif
                    type="password" />

                @if ($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="verification_code">@lang('cms::cms.verification_code')</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="verification_code" max="999999" name="verification_code" type="number" value="{{ old('verification_code', $model->verification_code) }}" />

                @if ($errors->has('verification_code'))
                    <span class="invalid-feedback">{{ $errors->first('verification_code') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
