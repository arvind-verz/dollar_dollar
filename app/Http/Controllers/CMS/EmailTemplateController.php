<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    /**
     * BannerController constructor.
     */
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, EMAIL_TEMPLATE_MODULE_ID);
        $emailTemplates = EmailTemplate::whereNotNull('contents')->get();
        return view("backend.emailTemplate.index", compact("emailTemplates", "title","CheckLayoutPermission"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, EMAIL_TEMPLATE_MODULE_ID);
        $emailTemplates = EmailTemplate::whereNull('contents')->select('id', 'title')->get();
        if ($emailTemplates->isEmpty()) {
            return redirect(route('email-template.index'))->with('error', EMAIL_TEMPLATE_ERROR);
        }
        //get pages detail
        return view("backend.emailTemplate.create", compact("title", "emailTemplates",'CheckLayoutPermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'contents' => 'required',
            'email_template' => 'required',
            'email_subject' => 'required',
        ]);
        $emailTemplate = EmailTemplate::findorfail($request->email_template);

        $emailTemplate->contents = $request->contents;
        $emailTemplate->subject = $request->email_subject;
        $emailTemplate->status = $request->status;
        $emailTemplate->created_at = Carbon::now()->toDateTimeString();
        $emailTemplate->save();

        return redirect(route('email-template.index'))->with('success', $emailTemplate->title . ' ' . ADDED_ALERT);

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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, EMAIL_TEMPLATE_MODULE_ID);

        $emailTemplate = EmailTemplate::findorfail($id);
        return view("backend.emailTemplate.edit", compact("title", "emailTemplate",'CheckLayoutPermission'));
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

        $emailTemplate = EmailTemplate::findorfail($id);
        $request->validate([
            'contents' => 'required',
            'email_subject' => 'required',
        ]);
        $emailTemplate->contents = $request->contents;
        $emailTemplate->subject = $request->email_subject;
        $emailTemplate->status = $request->status;
        $emailTemplate->updated_at = Carbon::now()->toDateTimeString();
        $emailTemplate->save();
        return redirect(route('email-template.index'))->with('success', $emailTemplate->title . ' ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $emailTemplate = EmailTemplate::findorfail($id);
        $emailTemplate->delete();
        return redirect(route('email-template.index'))->with('success', $emailTemplate->title . ' ' . DELETED_ALERT);
    }
}
