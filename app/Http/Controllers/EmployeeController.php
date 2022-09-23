<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Employee;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    protected $name = 'Data Pegawai';

    public function __construct()
    {
        $this->newModel = new Employee();
        $this->model = Employee::query();
        $this->modul = 'employee';
    }

    protected static function validateRequest ($request){
        $result = Validator::make($request->all(), [
            'grade_id' => 'required|numeric|exists:grades,id',
            'position_id' => 'required|numeric|exists:positions,id',
            'group_id' => 'required|numeric|exists:groups,id',
            'name' => 'required',
            'nip'=> 'required'
        ]);
        return $result ;
    }
    protected function findById($id){
        return $this->model->where('id', $id)->with('user')->first();
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = $this->model->latest()->with(['grade','position','group','user'])->get();

            return DataTables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fa fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" onclick="editItem(' . $item->id . ')"><i class="fa fa-pencil text-white    "></i></span></a>';
                })
                ->editColumn('cost', function ($item) {
                    return 'Rp. '.number_format($item->cost, 2, ',', '.');
                })
                ->addColumn('email', function ($item) {
                    return $item->user?$item->user->email:'Tidak Ada Akun';
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['groups'] = Group::orderBy('name')->get();
        $data['positions'] = Position::orderBy('name')->get();
        $data['grades'] = Grade::orderBy('name')->get();
        $data['users'] = User::whereDoesntHave('employee')->orderBy('name')->get();
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
            $item->grade_id = $request->grade_id;
            $item->position_id = $request->position_id;
            $item->group_id = $request->group_id;
            $item->name = $request->name;
            $item->nip = $request->nip;
            $item->user_id = $request->user_id;
            $item->bank_number = $request->bank_number;
            $item->bank_account = $request->bank_account;
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
            $item->grade_id = $request->grade_id;
            $item->position_id = $request->position_id;
            $item->group_id = $request->group_id;
            $item->name = $request->name;
            $item->nip = $request->nip;
            $item->user_id = $request->user_id;
            $item->bank_number = $request->bank_number;
            $item->bank_account = $request->bank_account;
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

    public function getUsers(Request $request){
        $query = $request->q;
        if(strlen($query) > 2){
        $users = User::where('name', 'LIKE', "%$query%")->orWhere('email', 'LIKE', "%$query%")->orderBy('name')->get()->whereDoesntHave('employee');
    }
        return response()->json($users, 200);
    }
}
