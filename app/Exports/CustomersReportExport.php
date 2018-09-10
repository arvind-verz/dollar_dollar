<?php

namespace App\Exports;

use App\ProductManagement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CustomersReportExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $customer_reports = ProductManagement::join('users', 'product_managements.user_id', '=', 'users.id')
            ->join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->select('users.id as users_id', 'users.*', 'brands.*', 'product_managements.*')
            ->get();

        $customer_reports_groups = ProductManagement::join('users', 'product_managements.user_id', '=', 'users.id')
            ->join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->groupBy('users.id')
            ->select('users.id as users_id', 'users.*', 'brands.*', 'product_managements.*')
            ->get();
//dd($customer_reports);
        return view('backend.reports.customer-report.customer-report-excel', [
            'customer_reports'        => $customer_reports,
            'customer_reports_groups' => $customer_reports_groups,
        ]);
    }
}
