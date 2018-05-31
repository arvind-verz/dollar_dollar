<div class="col-md-3">
    <div class="row-inner">
        <div class="navigation"> Products</div>
        @php
        $id=0;
        $parentCategories=Helper::getCategories($id);
        //dd($parentCategories)

        @endphp
        @if($parentCategories['count'])
            <ul class="side-nav">

                @foreach($parentCategories['categories'] as $category)
                    @php
                    $subOneCategories=Helper::getCategories($category->id);
                    @endphp

                    <li class="@if($subOneCategories['count']) side-has-sub @endif">
                        <a href="{{ route("get-products-category",["division"=>$category->division]) }}">{{$category->category}}</a>


                        @if($subOneCategories['count'])
                            <ul class="submenu">
                                @foreach($subOneCategories['categories'] as $subOneCategory)
                                    @php
                                    $subTwoCategories=Helper::getCategories($subOneCategory->id);

                                    @endphp
                                    <li class="@if($subTwoCategories['count']) side-has-sub @endif">
                                        <a href="{{ route("get-products-category",["division"=>$subOneCategory->division]) }}">{{$subOneCategory->category}}</a>

                                        @if($subTwoCategories['count'])

                                            <ul class="submenu">
                                                @foreach($subTwoCategories['categories'] as $subTwoCategory)
                                                    @php
                                                    $subThreeCategories=Helper::getCategories($subTwoCategory->id);
                                                    @endphp
                                                    <li class="@if($subThreeCategories['count']) side-has-sub @endif">
                                                        <a href="{{ route("get-products-category",["division"=>$subTwoCategory->division]) }}">{{$subTwoCategory->category}}</a>


                                                        @if($subThreeCategories['count'])
                                                            <ul class="submenu">
                                                                @foreach($subThreeCategories['categories'] as $subThreeCategory)
                                                                    <li>
                                                                        <a href="{{ route("get-products-category",["division"=>$subThreeCategory->division]) }}">{{$subThreeCategory->category}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif

                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </li>
                @endforeach
            </ul>
        @endif


    </div>
</div>