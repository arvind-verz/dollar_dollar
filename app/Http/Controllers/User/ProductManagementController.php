<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\ProductManagement;
use Auth;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validate = Validator::make($request->all(), [
            'bank_id'           =>  'required',
            'amount'            =>  'required|numeric',
            'interest_earned'   =>  'numeric|nullable'
        ]);

        if ($validate->fails()) {
            return redirect('product-management')
                        ->withErrors($validate)
                        ->withInput();
        }
        else {
            $product_management                     =   new ProductManagement();
            $product_management->user_id            =   Auth::user()->id;
            $product_management->bank_id            =   $request->bank_id;
            $product_management->account_name       =   $request->account_name;
            $product_management->amount             =   $request->amount;
            $product_management->tenure             =   $request->tenure;
            $product_management->start_date         =   $request->start_date;
            $product_management->end_date           =   $request->end_date;
            $product_management->interest_earned    =   $request->interest_earned;
            $product_management->save();
        }
        return redirect('product-management')->with('success',  'Data ' . ADDED_ALERT);
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
