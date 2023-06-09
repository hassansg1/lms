<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Clause;
use App\Models\Company;
use App\Models\Compliance;
use App\Models\ClauseData;
use App\Models\ComplianceDataFiles;
use App\Models\Standard;
use App\Models\StandardClause;
use App\Repos\StandardClauseRepo;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Session;


class StandardApplicableClauseController extends BaseController
{
    protected $model;
    protected $route;
    protected $heading;
    protected $topHeading;

    public function __construct()
    {
        $this->model = new StandardClause();
        $this->route = 'applicable_clause';
        $this->heading = 'Applicable Clause';
        \Illuminate\Support\Facades\View::share('top_heading', 'Applicable Clauses');
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request, $standardId)
    {
        $tree = getClauseTree($standardId, $request->clause_id_filter);

        $data['no_pagination'] = true;
        $data['no_header'] = true;
        $standard = Standard::find($standardId);
        $this->heading = "$standard->name > Clauses";

        return view($this->route . "/index")
            ->with(['items' => $tree, 'standardId' => $standardId, 'request' => $request, 'data' => $data, 'route' => $this->route,'model_name'=>'StandardClause', 'heading' => "Applicable Clauses of " . $standard->name]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $data = $this->fetchData($this->model, $request);

        return response()->json([
            'status' => true,
            'html' => view($this->route . "/form_rows")
                ->with(['items' => $data['items'], 'data' => $data, 'route' => $this->route, 'heading' => $this->heading])->render(),
            'data' => $data
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view($this->route . "/create")
            ->with(['route' => $this->route, 'heading' => $this->heading]);
    }

    /**
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate($this->model->rules);
        $this->model->saveFormData($this->model, $request);

        flashSuccess(getLang($this->heading . " Successfully Created."));

        if (isset($request->add_new)) return redirect(route($this->route . ".create"));

        Session::forget('clauseCached' . $request->standard_id);

        return redirect(route($this->route . ".index"));
    }

    /**
     * @param $item
     */
    public function show($item)
    {
        $item = $this->model->find($item);

        return view($this->route . '.view')->with(['route' => $this->route, 'item' => $item, 'heading' => $this->heading, 'clone' => $request->clone ?? null]);
    }

    /**
     * @param Request $request
     * @param $item
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $item)
    {
        if ($item == 0) {
            if (is_array($request->item))
                $item = $this->model->find('id', $request->item);
        }
        $item = $this->model->find($item);


        if ($request->ajax) {
            return response()->json([
                'status' => true,
                'html' => view($this->route . '.edit_modal')->with(['route' => $this->route, 'item' => $item, 'clone' => $request->clone ?? null])->render()
            ]);
        } else
            return view($this->route . '.edit')->with(['route' => $this->route, 'item' => $item, 'heading' => $this->heading, 'clone' => $request->clone ?? null]);
    }

    /**
     * @param Request $request
     * @param $item
     */
    public function update(Request $request, $item)
    {


        $item = $this->model->find($item);
        $this->model->saveFormData($item, $request);

        flashSuccess(getLang($this->heading . " Successfully Updated."));
        Session::forget('clauseCached' . $item->standard_id);

        return redirect(route($this->route . ".index"));
    }

    /**
     * @param $item
     */
    public function destroy($item)
    {
        $item = $this->model->find($item);
        $item->delete();

        flashSuccess(getLang($this->heading . " Successfully Deleted."));

        return redirect(route($this->route . ".index"));
    }

    public function viewStandards($standardId)
    {
        return $this->index($standardId, 1);
    }
}
