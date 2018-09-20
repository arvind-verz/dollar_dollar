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
        {!! Form::open(['class' => 'form-horizontal','url' => 'blog-search', 'method' => 'GET', 'id' => 'blog_search']) !!}
        <div class="mb-20">
            <input type="hidden" name="blog_id" value="{{ $id }}">
            <input class="form-control" type="text" name="b_search" value="" placeholder="Search...">
        </div>
        {!! Form::close() !!}
        <ul class="ps-list--sidebar menu-sibar">
            <li class="@if(!isset($id)) current @endif"><a href="{{ url(BLOG_URL) }}">All</a></li>
            <?php

            $parentCategories = Helper::getBlogMenus();
            //dd($parentCategories);
            if(count($parentCategories)) {
            printBlogCategories($parentCategories, BLOG_MENU_ID, $id);
            }
            ?>
        </ul>
    </div>
    @if(count($ads))
    <div class="ps-post__thumbnail ads pc-only"><a href="{{ $ads[0]->ad_link }}" target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt="" title="{{ $ads[0]->title }}"></a></div>
    @endif
</div>
<script type="text/javascript">
    $(document).keypress(function(e) {
        var b_search = $("input[name='b_search']").val();
        if(e.which == 13) {
            $("form#blog_search").submit();
        }
    });
</script>

