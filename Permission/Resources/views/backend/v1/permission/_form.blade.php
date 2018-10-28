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
            <label class="col-sm-2" for="guard_name">@lang('cms::cms.guard_name') *</label>
            <div class="col-sm-10">
                <select class="form-control form-control-sm" id="guard_name" name="guard_name" required>
                    <option></option>
                    @foreach ($model->getGuardNameOptions() as $guardName => $guardNameDescription)
                        <option {{ $guardName == old('guard_name', $model->guard_name) ? 'selected' : '' }} value="{{ $guardName }}">{{ $guardNameDescription }}</option>
                    @endforeach
                </select>

                @if ($errors->has('guard_name'))
                    <span class="invalid-feedback">{{ $errors->first('guard_name') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
