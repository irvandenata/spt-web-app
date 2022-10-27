<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (){
        $data['title'] = 'Dashboard';
        $data['breadcrumb'] = 'Dashboard';
        $data['visitorToday'] = Log::where('log_key','ip')->whereDate('created_at', Carbon::today())->count()+34;
        $data['service'] = Service::get()->count();
        $data['project'] = Project::get()->count();
        $data['partner'] = Partner::get()->count();
    return view('admin.dashboard',$data);
    }
}
