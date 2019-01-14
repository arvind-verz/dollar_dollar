<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\ProductManagement;
use Exporter;
use Excel;
use DB;
use App\User;
use App\Exports\CustomersReportExport;

class ReportController extends Controller
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
    public function customer_report()
    {
        $customer_reports = ProductManagement::join('users', 'product_managements.user_id', '=', 'users.id')
            ->leftJoin('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->select('users.id as users_id', 'users.*', 'brands.*', 'product_managements.*')
            ->get();

        DB::connection()->enableQueryLog();
        $customer_reports_groups = ProductManagement::join('users', 'product_managements.user_id', '=', 'users.id')
            ->leftJoin('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->groupBy('users.id')
            ->select('users.id as users_id', 'users.subscribe as users_subscribe', 'users.*', 'brands.*', 'product_managements.*')
            ->get();
        //dd(DB::getQueryLog());
//dd($customer_reports);
        return view('backend.reports.customer-report.index', [
            'customer_reports' => $customer_reports,
            'customer_reports_groups' => $customer_reports_groups,
        ]);
    }

    public function customerDeleteDeactivationReport()
    {
        //$CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, CUSTOMER_MODULE_ID);   

        $users = User::where('log_status', 1)->where(function ($query) {$query->where('delete_status', 1)->orWhere('status',0);})
            ->get();
        //dd($products);
        return view("backend.reports.customer-report.delete-deactivation", compact("users", "CheckLayoutPermission"));
    }

    public function product_report()
    {
        $product_reports = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->get();
        return view('backend.reports.product-report.index', [
            'product_reports' => $product_reports,
        ]);
    }

    public function customer_report_excel()
    {
        return Excel::download(new CustomersReportExport, 'profile ' . date("Ymd") . '.xlsx');
    }
}
