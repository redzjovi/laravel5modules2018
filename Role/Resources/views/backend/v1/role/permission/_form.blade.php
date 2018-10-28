{!! csrf_field() !!}
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2" for="permission_id">@lang('cms::cms.permission')</label>
            <div class="col-sm-10">
                <select class="form-control form-control-sm" id="permission_id" multiple name="permission_id[]"
                    @if (Agent::isDesktop())
                        bootstrap-select="true"
                    @endif
                    data-live-search="true"
                    multiple data-actions-box="true"
                >
                    @foreach ($permissions as $permission)
                        <option {{ $model->permissions->contains($permission->id) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('permission_id'))
                    <span class="invalid-feedback">{{ $errors->first('permission_id') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
