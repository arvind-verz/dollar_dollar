<?php

namespace App\Http\Controllers\Enquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactEnquiry;
use Auth;

class ContactEnquiryController extends Controller
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

        $contactEnquiries = ContactEnquiry::where('delete_status', 0)
            ->get();
        //dd($products);
        return view("backend.enquiry.contact-enquiry", compact("contactEnquiries", "CheckLayoutPermission"));
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
        $enquiry = ContactEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\ContactEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {

            return view("backend.enquiry.view-contact-enquiry", compact("enquiry"));
        } else {
            return redirect(route('contact-enquiry.index'));
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
        $contactEnquiry = ContactEnquiry::where('id', $id)->first();
        if (!$contactEnquiry) {
            return redirect()->action('Enquiry\ContactEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($contactEnquiry) {

            $contactEnquiry->delete_status = 1;
            $contactEnquiry->save();
            activity()
                ->performedOn($contactEnquiry)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => ENQUIRY_MODULE,
                    'msg' => $contactEnquiry->email . ' contact enquiry ' . DELETED_ALERT,
                    'old' => $contactEnquiry,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('contact-enquiry.index'))->with('success', $contactEnquiry->email . ' ' . DELETED_ALERT);
        } else {
            return redirect(route('contact-enquiry.index'));
        }
    }
}
