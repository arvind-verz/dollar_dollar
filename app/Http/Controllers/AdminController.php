<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\PromotionProducts;
use App\Page;
use App\systemSettingLegendTable;
use App\AdsManagement;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    public function removeImage(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $place = $request->place;
        $ad_type = isset($request->ad_type) ? $request->ad_type : '';
        $status = 0;
        if ($type == 'banner') {
            $upd_query = Banner::find($id);

            $upd_query->banner_image = null;
            $upd_query->save();
            echo "success";
        }
        if ($type == SYSTEM_SETTING_LEGEND_MODULE_SINGLE) {
            $legend = systemSettingLegendTable::find($id);

            $legend->icon = null;
            $legend->save();
            echo "success";
        } elseif ($type == 'blog') {
            $upd_query = Page::find($id);

            $upd_query->blog_image = null;
            $upd_query->save();
            echo "success";
        } elseif ($type == 'ads') {
            $upd_query = AdsManagement::find($id);
            $adImageCount = 0;
            if (!is_null($upd_query->ad_image)) {
                $adImageCount++;
            }
            if (!is_null($upd_query->paid_ad_image)) {
                $adImageCount++;
            }
            if ($upd_query->page == "account" || $upd_query->page == "blog") {
                if (!is_null($upd_query->horizontal_banner_ad_image)) {
                    $adImageCount++;
                }
                if (!is_null($upd_query->horizontal_paid_ad_image)) {
                    $adImageCount++;
                }
            }
            if ($adImageCount <= 0) {
                echo "error";
            } else {
                if ($place == 'horizontal') {
                    $upd_query->horizontal_banner_ad_image = null;
                }
                if ($place == 'horizontal_paid') {
                    $upd_query->horizontal_paid_ad_image = null;
                }
                if ($place == 'normal') {
                    $upd_query->ad_image = null;
                }
                if ($place == 'paid') {
                    $upd_query->paid_ad_image = null;
                }

                $upd_query->save();
                echo "success";
            }
        } elseif ($type == 'blogads') {
            $upd_query = Page::find($id);

            $upd_query->blog_image_ads = null;
            $upd_query->save();
            echo "success";
        } elseif ($type == 'product') {
            $upd_query = PromotionProducts::find($id);
            $ads_placement = json_decode($upd_query['ads_placement']);
            if ($ad_type == 'horizontal') {
                $ads_placement[0]->ad_image_horizontal = null;
                $status = 1;
            } elseif ($ad_type == 'vertical') {
                $ads_placement[1]->ad_image_vertical = null;
                $status = 1;
            } elseif ($ad_type == 'horizontal_popup') {
                $ads_placement[2]->ad_horizontal_image_popup = null;
                $status = 1;
            } elseif ($ad_type == 'vertical_popup') {
                $ads_placement[3]->ad_horizontal_image_popup_top = null;
                $status = 1;
            }
            if ($status === 1) {
                $upd_query->ads_placement = json_encode($ads_placement);
                $upd_query->save();
                echo "success";
            }
        }
    }
}
