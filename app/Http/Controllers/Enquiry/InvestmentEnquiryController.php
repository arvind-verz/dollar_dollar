<?php

namespace App\Http\Controllers\Enquiry;

use App\InvestmentEnquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class InvestmentEnquiryController extends Controller
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

        $enquiries = InvestmentEnquiry::where('delete_status', 0)
            ->get();
        //dd($products);
        return view("backend.enquiry.investment-enquiry", compact("enquiries", "CheckLayoutPermission"));
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
        $enquiry = InvestmentEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\InvestmentEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {
            return view("backend.enquiry.view-investment-enquiry", compact("enquiry"));
          } else {
            return redirect(route('investment-enquiry.index'));
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
        $enquiry = InvestmentEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\InvestmentEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {

            $enquiry->delete_status = 1;
            $enquiry->save();
            activity()
                ->performedOn($enquiry)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => ENQUIRY_MODULE,
                    'msg' => $enquiry->email . 'Investment enquiry ' . DELETED_ALERT,
                    'old' => $enquiry,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('investment-enquiry.index'))->with('success', $enquiry->email . ' ' . DELETED_ALERT);
        } else {
            return redirect(route('investment-enquiry.index'));
        }
    }
}
