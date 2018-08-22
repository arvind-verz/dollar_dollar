<?php
function printBlogCategories($parentCategories, $parent = 0, $id, $deep = 0) {//dd($id); ?>
@if(count($parentCategories[$parent]) > 0)

    <?php foreach($parentCategories[$parent] as $key => $parentCategory){

    //dd($parentCategories, $parent, $key, $parentCategory)
    ?>

    @if (isset($parentCategories[$parentCategory['id']]) && (count($parentCategories[$parentCategory['id']]) > 0) )

        <li class="@if($id==$parentCategory['id']) current @endif"><a
                    href="{{ route('get-blog-by-category',['id'=>$parentCategory['id']]) }}">{{$parentCategory['title']}}</a>
            <ul class="">
                @php
                printBlogCategories($parentCategories, $parentCategory['id'], ($deep + 1));
                @endphp
            </ul>
        </li>
    @else
<?php //print_r($id); ?>
        <li class="@if($id==$parentCategory['id']) current @endif"><a
                    href="{{ route('get-blog-by-category',['id'=>$parentCategory['id']]) }}">{{$parentCategory['title']}}</a>
        </li>
    @endif

    <?php } ?>
@endif
<?php } ?>
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
    <div class="ps-sidebar">
        <h3>Blog</h3>
        <ul class="ps-list--sidebar">
            <li class="@if(!isset($id)) current @endif"><a href="{{ url(BLOG_URL) }}">All</a></li>
            <?php

            $parentCategories = Helper::getBlogMenus();
            //dd($parentCategories);
            printBlogCategories($parentCategories, BLOG_MENU_ID, $id);
            ?>
        </ul>
    </div>
    @if(count($ads))
    <div class="ps-post__thumbnail ads"><a href="{{ $ads[0]->ad_link }}" target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt="" title="{{ $ads[0]->title }}"></a></div>
    @endif
</div>

