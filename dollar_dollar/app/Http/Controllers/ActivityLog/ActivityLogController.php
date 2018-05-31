<?php

namespace App\Http\Controllers\ActivityLog;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;


class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ACTIVITY_LOG_MODULE_ID);

        //
        $details = Activity::where('delete_status', 0)
            ->get();

        $activities = [];
        if ($details->count()) {

            foreach ($details as $detail) {
                $properties = $detail->properties;

                $activity = [];
                $admin = Admin::find($detail->causer_id);

                if ($admin) {
                    $activity['causer'] = $admin->first_name . ' ' . $admin->last_name;
                    $activity['email'] = $admin->email;
                } else {
                    $activity['causer'] = null;
                    $activity['email'] = null;
                }
                $activity['ip'] = null;
                $activity['module'] = null;
                $activity['msg'] = null;
                if (isset($properties['ip'])) {
                    $activity['ip'] = $properties['ip'];
                }
                if (isset($properties['module'])) {
                    $activity['module'] = $properties['module'];
                }
                $activity['action'] = $detail->description;
                if (isset($properties['msg'])) {
                    $activity['msg'] = $properties['msg'];
                }

                if ($detail->created_at) {
                    $activity['date'] = date("Y-m-d h:i A", strtotime($detail->created_at));
                } else {
                    $activity['date'] = $detail->created_at;
                }
                $activities[] = $activity;
            }
        }
        return view("backend.activity.index", compact("activities","CheckLayoutPermission"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy()
    {
        // Activity::cleanLog();

        $activities = Activity::where('delete_status', 0)
            ->get();

        if ($activities->count()) {

            Activity::where('delete_status', 0)
                ->update(['delete_status' => 1]);

            //store log of activity
            activity()
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => ACTIVITY_LOG_MODULE,
                    'msg' => "Cleared log ",
                    'old' => null,
                    'new' => null
                ])
                ->log(DELETE);

            return redirect(route('activity.index'))->with('success', 'Log clear successfully');

        }
        return redirect(route('activity.index'));
    }
}