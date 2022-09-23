<?php

namespace App\Http\Controllers;

use App\Models\TicketCost;
use App\Exceptions\CustomException;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TicketCostController extends Controller
{
    protected $name = 'Data Anggaran Tiket Pesawat';

    public function __construct()
    {
        $this->newModel = new TicketCost();
        $this->model = TicketCost::query();
        $this->modul = 'ticketCost';
    }

    protected static function validateRequest ($request){
        $result = Validator::make($request->all(), [
            'cost' => 'required',
            'arrival_id' => 'required',
            'destination_id' => 'required',
        ]);
        return $result ;
    }
    protected function findById($id){
        return $this->model->where('id', $id)->first();
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = $this->model->latest()->with(['arrival','destination'])->get();

            return DataTables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fa fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" onclick="editItem(' . $item->id . ')"><i class="fa fa-pencil text-white    "></i></span></a>';
                })
                ->editColumn('cost', function ($item) {
                    return 'Rp. '.number_format($item->cost, 2, ',', '.');
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['provinces'] = Province::orderBy('name')->get();
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->name;
        $data['modul'] = $this->modul;
        return view($this->modul.'.index', $data);
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
            $item = $this->newModel;
            $item->cost = str_replace('.', '',$request->cost);
            $item->arrival_id = $request->arrival_id;
            $item->destination_id = $request->destination_id;
            $item->save();
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 404);
        }
        return response()->json(['message' => "$this->name Berhasil dibuat !", "data" => $item], 200);
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
                throw new CustomException("error", 404, null, ["Data tidak ditemukan"]);
            }
            $item->cost = str_replace('.', '',$request->cost);
            $item->arrival_id = $request->arrival_id;
            $item->destination_id = $request->destination_id;
            $item->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e, 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 500);
        }
        return response()->json(['message' => "$this->name Berhasil diperbaharui !", "data" => $item], 200);

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
                throw new CustomException("error", 404, null, ["Data tidak ditemukan"]);
            }
            $item->delete();
            return response()->json(['message' => "$this->name Berhasil dihapus !"], 200);

        }catch (Exception $e) {
            return response()->json($e, 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }
}

