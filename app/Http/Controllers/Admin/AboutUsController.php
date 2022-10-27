<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{

    protected $name = 'About Us';
    protected $modul = 'about-us';

    protected static function validateRequest($request)
    {
        $result = Validator::make($request->all(), [
            'company_name' => 'required|max:255',
            'motto' => 'max:255',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'whatsapp' => 'numeric',
            'address' => 'max:255',
            'email' => 'email',
        ]);
        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->name;
        $aboutUs = Storage::disk('local')->get('public/about-us/about-us.json');
        $data['aboutUs'] = json_decode($aboutUs);
        return view('admin.about-us.index', $data);
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
        try {
            $v = $this->validateRequest($request);
            if ($v->fails()) {
                throw new CustomException("error", 400, null, $v->errors()->all());
            }
            $aboutUs = Storage::disk('local')->get('public/about-us/about-us.json');
            $aboutUs = json_decode($aboutUs);
            if($request->image){
                if($aboutUs && $aboutUs->image){
                    GlobalHelper::deleteSingleImage($aboutUs->image);
                }
                $image = GlobalHelper::storeSingleImage($request->image, $this->modul);
            } else if($aboutUs) {
                $image = $aboutUs->image;
            }
            $data = [
                'company_name' => $request->company_name,
                'motto' => $request->motto,
                'whatsapp' => $request->whatsapp,
                'address' => $request->address,
                'description' => $request->description,
                'image' => $image,
                'email' => $request->email,
            ];
            Storage::put('public/about-us/about-us.json', json_encode($data));
            return redirect()->back()->with('success', 'Data has been updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (CustomException $e) {
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
