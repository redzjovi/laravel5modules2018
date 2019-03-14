{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="name">@lang('cms::cms.name')</label>
            <div class="col-sm-10">
                <input class="form-control form-control-sm" id="name" readonly type="text" value="{{ $model->name }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2" for="permission_name">@lang('cms::cms.permissions')</label>
            <div class="col-sm-10">
                <select class="form-control form-control-sm" id="permission_name" multiple name="permission_name[]"
                    @if (Agent::isDesktop())
                        bootstrap-select="true"
                    @endif
                    data-live-search="true"
                    multiple data-actions-box="true"
                >
                    @foreach ($permissions as $permission)
                        <option {{ $model->permissions->contains($permission->id) ? 'selected' : '' }} value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('permission_name'))
                    <span class="invalid-feedback">{{ $errors->first('permission_name') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
