<?php

namespace App\Http\Controllers\Enquiry;

use App\LifeInsuranceEnquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LifeInsuranceEnquiryController extends Controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ENQUIRY_MODULE_ID);

        $enquiries = LifeInsuranceEnquiry::where('delete_status', 0)
            ->get();
        //dd($products);
        return view("backend.enquiry.life-insurance-enquiry", compact("enquiries", "CheckLayoutPermission"));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enquiry = LifeInsuranceEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\LifeInsuranceEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {
            return view("backend.enquiry.view-life-insurance-enquiry", compact("enquiry"));
          } else {
            return redirect(route('life-insurance-enquiry.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enquiry = LifeInsuranceEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\LifeInsuranceEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {

            $enquiry->delete_status = 1;
            $enquiry->save();
            activity()
                ->performedOn($enquiry)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => ENQUIRY_MODULE,
                    'msg' => $enquiry->email . 'Life insurance enquiry ' . DELETED_ALERT,
                    'old' => $enquiry,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('life-insurance-enquiry.index'))->with('success', $enquiry->email . ' ' . DELETED_ALERT);
        } else {
            return redirect(route('life-insurance-enquiry.index'));
        }
    }
}
