<?php

namespace Modules\Cms\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepositoryController extends \Illuminate\Routing\Controller
{
    protected $repository;

    public function action(\Modules\Cms\Http\Requests\Backend\V1\Repository\ActionRequest $request)
    {
        $action = $request->action;
        $this->{$action}($request);
        return redirect()->back();
    }

    public function actionDelete(Request $request)
    {
        if ($ids = $request->id) {
            foreach ($ids as $id) {
                $this->repository->delete($id);
            }
            flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
        }
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }
}
