<?php

namespace App\Http\Controllers\Enquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\LoanEnquiry;
use App\PromotionProducts;

class LoanEnquiryController extends Controller
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

        $loanEnquiries = LoanEnquiry::where('delete_status', 0)
            ->get();
        if($loanEnquiries->count())
        {
            foreach($loanEnquiries as &$loanEnquiry)
            {
                $productIds = [];

                if (!empty($loanEnquiry->product_ids)) {
                    $productIds = unserialize($loanEnquiry->product_ids);
                }
                $productNames = [];
                if (count($productIds)) {
                    $products = PromotionProducts::whereIn('id',$productIds)->where('delete_status', 0)->where('status', 1)->get();
                    if ($products->count()) {
                        $productNames = $products->pluck('product_name')->all();
                    }
                }

                $loanEnquiry->product_names = $productNames;
            }

        }
        return view("backend.enquiry.loan-enquiry", compact("loanEnquiries", "CheckLayoutPermission"));
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
        $enquiry = LoanEnquiry::where('id', $id)->first();
        if (!$enquiry) {
            return redirect()->action('Enquiry\LoanEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($enquiry) {
            $productIds = [];

            if (!empty($enquiry->product_ids)) {
                $productIds = unserialize($enquiry->product_ids);
            }
            $productNames = [];
            if (count($productIds)) {
                $products = PromotionProducts::whereIn('id',$productIds)->where('delete_status', 0)->where('status', 1)->get();
                if ($products->count()) {
                    $productNames = $products->pluck('product_name')->all();
                }
            }

            $enquiry->product_names = $productNames;

            return view("backend.enquiry.view-loan-enquiry", compact("enquiry"));
        } else {
            return redirect(route('loan-enquiry.index'));
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
        $loanEnquiry = LoanEnquiry::where('id', $id)->first();
        if (!$loanEnquiry) {
            return redirect()->action('Enquiry\LoanEnquiryController@index')->with('error', OPPS_ALERT);
        }

        if ($loanEnquiry) {

            $loanEnquiry->delete_status = 1;
            $loanEnquiry->save();
            activity()
                ->performedOn($loanEnquiry)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => ENQUIRY_MODULE,
                    'msg' => $loanEnquiry->email . ' loan enquiry ' . DELETED_ALERT,
                    'old' => $loanEnquiry,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('loan-enquiry.index'))->with('success', $loanEnquiry->email . ' ' . DELETED_ALERT);
        } else {
            return redirect(route('loan-enquiry.index'));
        }
    }
}
