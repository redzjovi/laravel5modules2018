{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="name">@lang('cms::cms.name') *</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="name" name="name" required type="text" value="{{ old('name', $model->name) }}" />
                <i class="text-danger">{{ $errors->first('name') }}</i>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="email">@lang('cms::cms.email') *</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="email" name="email" required type="email" value="{{ old('email', $model->email) }}" />
                <i class="text-danger">{{ $errors->first('email') }}</i>
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
                <i class="text-danger">{{ $errors->first('password') }}</i>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
