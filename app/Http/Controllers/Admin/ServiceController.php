<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Helpers\GlobalHelper;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $name = 'Data Services';
    protected $modul = 'services';

    public function __construct()
    {
        $this->newModel = new Service();
        $this->model = Service::query();
    }

    protected static function validateRequest ($request){
        $result = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subtitle' => 'max:255',
            'image'=> 'mimes:jpeg,jpg,png,gif|max:10000',
            'order'=> 'required|numeric',
        ]);
        return $result ;
    }
    protected function findById($id){
        $model = clone $this->model;
        return  $model->where('id', $id)->first();
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
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fas fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" onclick="editItem(' . $item->id . ')"><i class="fas fa-pencil text-white    "></i></span></a>';
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->editColumn('show', function($item){
                    return $item->show == 1 ? '<div class="badge bg-success" onClick="controlShow('.$item->id.')" style="cursor:pointer"  >Showed</div>' : '<div class="badge bg-dark" style="cursor:pointer" onClick="controlShow('.$item->id.')" >Hidden</div>';
                })
                ->editColumn('image', function ($item) {
                    return '<img src="'.asset($item->image?('/storage/'.$item->image):"assets/img/no-image.png").'" onClick="showImage(this)" class="cursor-pointer" width="50px" >';
                })
                ->rawColumns(['action','image','show'])
                ->make(true);
        }
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->name;
        $data['order'] = $this->model->count();
        return view('admin.service.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $v = $this->validateRequest($request);
            if ($v->fails()) {
                throw new CustomException("error", 404, null, $v->errors()->all());
            }
            $order = $request->order;
            $modelOrder = clone $this->model;
            $modelOrder = $modelOrder->where('order', $order)->first();
            if($modelOrder){
                $modelOrder->order = $this->model->get()->count() + 1;
                $modelOrder->save();
            }
            $item = $this->newModel;
            $item->title = $request->title;
            $item->subtitle = $request->subtitle;
            $item->description = $request->description;
            $item->order = $order;
            if($request->image){
               $item->image = GlobalHelper::storeSingleImage($request->image, $this->modul);
            }
            $item->save();
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 404);
        }
        return response()->json(['message' => "$this->name has been created !", "data" => $item], 200);
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
        return $this->findById($id);
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
            $v = $this->validateRequest($request);
            if ($v->fails()) {
                throw new CustomException("error", 400, null, $v->errors()->all());
            }
            $item = $this->findById($id);

            if(!$item){
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            $modelOrder = clone $this->model;

            $order = $request->order;
            $oldOrder = $item->order;

            $modelOrder = $modelOrder->where('order', $order)->first();
            if($modelOrder){
                $modelOrder->order = $oldOrder;
                $modelOrder->save();
            }

            $item->title = $request->title;
            $item->subtitle = $request->subtitle;
            $item->description = $request->description;
            $item->order = $order;
            if($request->image){
               $item->image = GlobalHelper::updateSingleImage($request->image, $this->modul, $item->image);
            }
            $item->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 500);
        }
        return response()->json(['message' => "$this->name has been updated !", "data" => $item], 200);

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
            if(!$item){
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            if($item->image){
                GlobalHelper::deleteSingleImage($item->image);
            }
            $item->delete();
            return response()->json(['message' => "$this->name has been deleted !"], 200);

        }catch (Exception $e) {
            return response()->json($e, 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }

    public function changeShow($id){
        try {
            $item = $this->findById($id);
            if(!$item){
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            $item->show = $item->show == 1 ? 0 : 1;
            $item->save();
            return response()->json(['message' => "$this->name has been updated !", "data" => $item], 200);
        }catch (Exception $e) {
            return response()->json($e, 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }
}
