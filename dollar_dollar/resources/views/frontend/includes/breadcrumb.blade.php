<?php
$linkedPage = \DB::table('pages')->where('id',$page->page_linked)->first();
//dd($linkedPage->menu_id);
// dd($linkedPage);
?>
@if(isset($linkedPage->menu_id))
<?php
$breadcums = Helper::getBreadCumsCategoryByMenus($linkedPage->menu_id);
$breadCumsCount = count($breadcums) - 1;
//dd($breadcums);
?>
@for($i=0; $i<=$breadCumsCount;$i++)
{{-- @php dd($breadcums[$i],$breadCumsCount); @endphp--}}
        <!--
    check if product division and breadcums division same
    when category only one product that time redirect direct to product page
    that time need to check for reducing double breadcum of category
    -->
@if($breadcums[$i]['id'] == $page->menu_id)
    <li class="active">{{$breadcums[$i]['title']}}</li>

@else
    <li>
        <a href="{{ route("slug", ["slug"=>$breadcums[$i]['slug']]) }}"> {{$breadcums[$i]['title']}}</a>
    </li>
@endif
@endfor
<li class="active">{{$page->name}}</li>
@else
    <li class="active">{{$page->name}}</li>
@endif
