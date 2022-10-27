<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\ImageProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    protected $name = 'Data Projects';
    protected $modul = 'projects';
    public function __construct()
    {
        $this->newModel = new Project();
        $this->model = Project::query();
    }

    protected static function validateRequest($request, $type)
    {
        if ($type == 'create') {
            $result = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'subtitle' => 'max:255',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
                'order' => 'required|numeric',
                'multi_image[]' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'caption[]' => 'max:255|string',
            ]);
        } else {
            $result = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'subtitle' => 'max:255',
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'order' => 'required|numeric',
                'multi_image[]' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'caption[]' => 'max:255|string',
            ]);
        }

        return $result;
    }
    protected function findById($id)
    {
        $model = clone $this->model;
        return $model->where('id', $id)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = $this->model->orderBy('order')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fas fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" href="' . route('projects.edit', $item->id) . '" ><i class="fas fa-pencil text-white    "></i></span></a>';
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->editColumn('show', function ($item) {
                    return $item->show == 1 ? '<div class="badge bg-success" onClick="controlShow(' . $item->id . ')" style="cursor:pointer"  >Showed</div>' : '<div class="badge bg-dark" style="cursor:pointer" onClick="controlShow(' . $item->id . ')" >Hidden</div>';
                })
                ->editColumn('image', function ($item) {
                    return '<img src="' . asset($item->image ? ('/storage/' . $item->image) : "assets/img/no-image.png") . '" onClick="showImage(this)" class="cursor-pointer" width="50px" >';
                })
                ->rawColumns(['action', 'image', 'show'])
                ->make(true);
        }
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->name;
        $data['order'] = $this->model->count();
        return view('admin.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->name . ' - Create';
        $data['breadcrumb'] = $this->name . ' - Create';
        $data['order'] = $this->model->count() + 1;
        return view('admin.project.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $v = $this->validateRequest($request, 'create');
            if ($v->fails()) {
                throw new CustomException("error", 401, null, $v->errors()->all());
            }

            $order = $request->order;
            $modelOrder = clone $this->model;
            $modelOrder = $modelOrder->where('order', $order)->first();
            if ($modelOrder) {
                $modelOrder->order = $this->model->get()->count() + 1;
                $modelOrder->save();
            }
            $item = $this->newModel;
            $item->title = $request->title;
            $item->subtitle = $request->subtitle;
            $item->description = $request->description;
            $item->order = $order;
            if ($request->image) {
                $item->image = GlobalHelper::storeSingleImage($request->image, $this->modul);
            }
            $item->save();
            if ($request->caption) {
                foreach ($request->caption as $key => $caption) {
                    $multiImage = new ImageProject();
                    $multiImage->caption = $caption;
                    if (isset($request->multi_image[$key]) && $request->multi_image[$key]) {
                        $multiImage->image_url = GlobalHelper::storeSingleImage($request->multi_image[$key], 'image-projects');
                    }
                    $multiImage->project_id = $item->id;
                    $multiImage->order = $key + 1;
                    $multiImage->save();
                }
            }
            DB::commit();
            return redirect()->route('projects.index')->with('success', 'Data has been created');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        } catch (CustomException $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getOptions());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = $this->name . ' - Edit';
        $data['breadcrumb'] = $this->name . ' - Edit';
        $data['item'] = $this->findById($id);
        $data['maxOrder'] = $this->model->count();
        return view('admin.project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $v = $this->validateRequest($request, 'edit');
            if ($v->fails()) {
                throw new CustomException('error', 401, null, $v->errors()->all());
            }
            $item = $this->findById($id);
            $tempOrder = $item->order;
            $order = $request->order;
            $modelOrder = clone $this->model;
            $modelOrder = $modelOrder->where('order', $order)->first();
            if ($modelOrder) {
                $modelOrder->order = $tempOrder;
                $modelOrder->save();
            }
            $item->title = $request->title;
            $item->subtitle = $request->subtitle;
            $item->description = $request->description;
            $item->order = $order;
            if ($request->image) {
                $item->image = GlobalHelper::updateSingleImage($request->image, $this->modul, $item->image);
            }
            $item->save();
            if ($request->caption) {
                foreach ($request->caption as $key => $caption) {
                    if ($caption != null && $caption != '') {
                        if ($request->idImage && $request->idImage[$key]) {
                            $multiImage = ImageProject::where('id', $request->idImage[$key])->first();
                        } else {
                            $multiImage = new ImageProject();
                        }
                        $multiImage->caption = $caption;
                        if (isset($request->multi_image[$key]) && $request->multi_image[$key]) {
                            if ($multiImage->image_url) {
                                $multiImage->image_url = GlobalHelper::updateSingleImage($request->multi_image[$key], 'image-projects', $multiImage->image_url);
                            } else {
                                $multiImage->image_url = GlobalHelper::storeSingleImage($request->multi_image[$key], 'image-projects');
                            }
                        }
                        $multiImage->project_id = $item->id;
                        $multiImage->order = $key + 1;
                        $multiImage->save();}
                }
            }

            if ($request->delete_image) {
                foreach ($request->delete_image as $key => $idImageDelete) {
                    $multiImage = ImageProject::where('id', $idImageDelete)->first();
                    if ($multiImage) {
                        GlobalHelper::deleteSingleImage($multiImage->image_url);
                        $multiImage->delete();
                    }
                }
            }
            DB::commit();
            return redirect()->route('projects.index')->with('success', 'Data has been updated');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error',$e->getMessage());
        } catch (CustomException $e) {
            DB::rollback();

            return redirect()->back()->with('error',$e->getOptions());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->findById($id);
            if (!$item) {
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            if ($item->imageProjects) {
                foreach ($item->imageProjects as $key => $image) {
                    GlobalHelper::deleteSingleImage($image->image_url);
                }
                $item->imageProjects()->delete();
            }
            if ($item->image) {
                GlobalHelper::deleteSingleImage($item->image);
            }
            $item->delete();
            return response()->json(['message' => "$this->name has been deleted !"], 200);

        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }

    public function changeShow($id)
    {
        try {
            $item = $this->findById($id);
            if (!$item) {
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            $item->show = $item->show == 1 ? 0 : 1;
            $item->save();
            return response()->json(['message' => "$this->name has been updated !", "data" => $item], 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }
}
