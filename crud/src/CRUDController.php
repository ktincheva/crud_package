<?php

namespace KTSoftware\CRUD;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class CRUDController extends Controller {

    //
    private $data = [];
    private $settings = null;
    private $list_view = 'crud::list';
    private $craete_view = 'crud::create';
    private $edit_view = 'crud::edit';
    
    public function __construct($settings) {
        $this->data['settings'] = $settings;

        $this->settings = $settings;
    }

    function getData() {
        return $this->data;
    }

    function getSettings() {
        return $this->settings;
    }

    function getList_view() {
        return $this->list_view;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setSettings($settings) {
        $this->settings = $settings;
    }

    function setList_view($list_view) {
        $this->list_view = $list_view;
    }

    function getCrete_view() {
        return $this->craete_view;
    }

    function setCreqte_view($create_view) {
        $this->create_view = $create_view;
    }

    public function index() {
        $model = $this->settings->model;
        $this->data['sortby'] = Input::get('sortby');
        $this->data['order'] = Input::get('order');
        
        if (property_exists($model, 'translable')) {
            $model = $model::where('lang', \Lang::locale());
        }
        if ($this->data['sortby'] && $this->data['order']) {
            $this->data['entries'] = $model::orderBy($this->data['sortby'], $this->data['order'])->paginate($this->settings->rowsPerPage);
        } else {
            $this->data['entries'] = $model::paginate($this->settings->rowsPerPage);
        }

        if (!empty($this->settings->list_view) && view()->exists($this->settings->list_view))
            return view($this->settings->list_view, $this->data);
        else
            return view($this->list_view, $this->data);
    }

    public function create() {

        if (isset($this->settings->create_form['fields'])) {
            $this->settings->fields = $this->settings->create_form['fields'];
        }
        $this->data['settings'] = $this->settings;
        return view($this->craete_view, $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        //
       
        $model = $this->settings->model;
        $input = Input::all();
        $validation = Validator::make($input, $this->settings->create_form['rules']);

        if ($validation->passes()) {
            // $input["password"] = Hash::make($input["password"]);
            $model::create($input);
            return redirect($this->settings->route)->with('danger', 'Data have been saved successfully');
        }
        return redirect($this->settings->route . '/create')
                        ->withErrors($validation)
                        ->with('success', 'There have validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $model = $this->settings->model;
        $this->data['entry'] = $model::find($id);

        if (isset($this->settings->update_form['fields'])) {
            $this->settings->fields = $this->settings->update_form['fields'];
        }
        $this->data['settings'] = $this->settings;

        $this->prepareFields($this->data['entry']);
        return view($this->edit_view, $this->data);
    }

    public function update(Request $request = null) {
        $model = $this->settings->model;
        if (isset($this->settings->update_form['fields'])) {
            $this->settings->fields = $this->settings->update_form['fields'];
        }
        $this->data['settings'] = $this->settings;
        $this->prepareFields($model::find($request->input('id')));

        $data = $model::find($request->input('id'));
        $data = $this->assingDataToModel($data, $request->all());
        if($data->save())
            return redirect($this->settings->route)->with('success', 'Data have been saved successfully');
        else return redirect($this->settings->route)->with('danger', 'Data have not been saved successfully');
    }

    public function destroy($id) {
        $model = $this->settings->model;
        $data = $model::find($id);
        $data->delete();
        return redirect($this->settings->route)->with('message', 'Data have been deleted successfully');
    }

    protected function prepareFields($data = false) {

        if (!isset($this->settings->fields)) {
            abort(500, "The CRUD fields are not defined.");
        }

        foreach ($this->settings->fields as $key => $field) {
            if (!isset($this->settings->fields[$key]['type']))
                $this->settings->fields[$key]['type'] = 'text';
        }

        if ($data) {
            foreach ($this->settings->fields as $key => $field) {
                // set the value
                if (!isset($this->settings->fields[$key]['value'])) {
                    $this->settings->fields[$key]['value'] = $data->$field['name'];
                }
            }
            $this->settings->fields[] = array(
                'name' => 'id',
                'value' => $data->id,
                'type' => 'hidden'
            );
        }
    }

    private function assingDataToModel($item, $data) {
        if (!isset($this->settings->fields)) {
            abort(500, "The CRUD fields are not defined.");
        }
        foreach ($this->settings->fields as $key => $field) {
            if (!empty($data[$field['name']]))
                $item->$field['name'] = $data[$field['name']];
        }
        return $item;
    }

}
