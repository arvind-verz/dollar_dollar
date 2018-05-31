<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TagController extends Controller
{
    /**
     * Constructor of Tag controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, TAG_MODULE_ID);
        $tags = Tag::where('delete_status', 0)->get();
        //dd($tags);
        return view("backend.CMS.tag.index", compact("tags", "CheckLayoutPermission"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->create_permission(@Auth::user()->role_type_id, TAG_MODULE_ID) == 0) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }

        return view("backend.CMS.tag.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag' => 'required|unique:tags,title',
            'status' => 'required'
        ]);
        $tag_array = explode(",", $request->tag);

        foreach ($tag_array as $key => $value) {

            try {

                Tag::insert(
                    ['title' => $value, 'status' => $request->status, 'created_by' => Auth::user()->id, 'created_at' => Carbon::now()->toDateTimeString()]
                );
            } catch (\Exception $exception) {
                return redirect()->back()->with('error', OPPS_ALERT);
            }


        }
        //store activity log
        activity()
            ->withProperties(['ip' => \Request::ip(),
                'module' => TAG_MODULE,
                'msg' => implode(', ', $tag_array) . ' ' . ADDED_ALERT,
                'old' => null,
                'new' => null])
            ->log(CREATE);

        return redirect()->action('CMS\TagController@index')->with('success', implode(', ', $tag_array) . ' ' . ADDED_ALERT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->edit_permission(@Auth::user()->role_type_id, TAG_MODULE_ID) == 0) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->action('CMS\TagController@index')->with('error', OPPS_ALERT);
        }
        return view("backend.CMS.tag.edit", compact("tag"));
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
        $this->validate($request, [
            'title' => 'required|unique:tags,title,' . $id,
            'status' => 'required'
        ]);
        $tag = Tag::find($id);
        $oldTag = $tag;

        if (!$tag) {
            return redirect()->action('CMS\TagController@index')->with('error', OPPS_ALERT);
        }
        $tag->title = $request->title;
        $tag->status = $request->status;
        $tag->updated_by = Auth::user()->id;
        $tag->updated_at = Carbon::now()->toDateTimeString();
        $tag->save();
        $newTag = Tag::find($id);
        //store activity log
        activity()
            ->performedOn($tag)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => TAG_MODULE,
                'msg' => $newTag->title . ' ' . UPDATED_ALERT,
                'old' => $oldTag,
                'new' => $newTag
            ])
            ->log(UPDATE);
        return redirect()->action('CMS\TagController@index')->with('success', $newTag->title . ' ' . UPDATED_ALERT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->delete_permission(@Auth::user()->role_type_id, 4) == TAG_MODULE_ID) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }
        $tag = Tag::where('id', $id)->first();
        if (!$tag) {
            return redirect()->action('CMS\TagController@index')->with('error', OPPS_ALERT);
        } else {
            $tag->delete_status = 1;
            $tag->save();
            //store log of activity
            activity()
                ->performedOn($tag)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => TAG_MODULE,
                    'msg' => $tag->title . ' ' . DELETED_ALERT,
                    'old' => $tag,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect()->action('CMS\TagController@index')->with('success', $tag->title . ' ' . DELETED_ALERT);
        }
    }
}
