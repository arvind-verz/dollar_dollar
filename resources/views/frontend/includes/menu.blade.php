<header class="header">
    <div class="header__top">
        <div class="container">
            <p>@if(AUTH::check())Hello, {{ AUTH::user()->first_name }} @endif Welcome to DollarDollar.SG</p>
            <ul class="header__actions">
                <li><a href="{{ url(PROFILEDASHBOARD) }}"><i class="fa fa-user-circle"></i>My account</a></li>
                <li><a href="{{ url(LOGIN_SLUG) }}"><i class="fa fa-clock"></i>Login</a></li>
                <li><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
            </ul>
        </div>
    </div>
    <nav class="navigation">
        <?php
        function printTerms($menus, $slug, $parent = 0, $deep = 0) { ?>
        @if(count($menus[$parent]) > 0)

            <?php foreach($menus[$parent] as $key => $menu) {  ?>

            @if (isset($menus[$menu['id']]) && (count($menus[$menu['id']]) > 0) )

                <li class="menu-item-has-children"><a
                            href="@if($menu['slug'] != null) {{route('slug',[$menu['slug']]) }} @else # @endif">{{$menu['title']}}</a>

                    @if($menu['slug'] == BLOG_URL)
                        <ul class="sub-menu">
                            <?php

                            $parentCategories = Helper::getBlogMenus();
                            printCategories($parentCategories, BLOG_MENU_ID);
                            ?>
                        </ul>
                    @else
                        <ul class="sub-menu">
                            <?php
                            printTerms($menus, $menu['slug'], $menu['id'], ($deep + 1));
                            ?>
                        </ul>
                    @endif


                </li>
            @elseif($menu['slug'] != null)
                <li class="@if($menu['slug']== $slug) current-menu-item @endif"><a
                            href="{{route('slug',[$menu['slug']]) }}">{{$menu['title']}}</a>

                    @if($menu['slug'] == BLOG_URL)
                        <ul class="sub-menu">
                            <?php

                            $slug = BLOG_URL;
                            $menus = \Helper::getBlogMenus($slug);
                            if (count($menus)) {
                                printTerms($menus, BLOG_URL);
                            }

                            ?>
                        </ul>
                    @endif


                </li>
            @endif

            <?php } ?>
        @endif
        <?php } ?>


        <?php
        function printCategories($parentCategories, $parent = 0, $deep = 0) { ?>
        @if(count($parentCategories[$parent]) > 0)

            <?php foreach($parentCategories[$parent] as $key => $parentCategory){
            //dd($parentCategories, $parent, $key, $parentCategory)
            ?>

            @if (isset($parentCategories[$parentCategory['id']]) && (count($parentCategories[$parentCategory['id']]) > 0) )

                <li class="menu-item-has-children"><a
                            href="{{ route('get-blog-by-category',['id'=>$parentCategory['id']]) }}">{{$parentCategory['title']}}</a>
                    <ul class="sub-menu">
                        @php
                        printCategories($parentCategories, $parentCategory['id'], ($deep + 1));
                        @endphp
                    </ul>
                </li>
            @else

                <li class=""><a
                            href="{{ route('get-blog-by-category',['id'=>$parentCategory['id']]) }}">{{$parentCategory['title']}}</a>
                </li>
            @endif

            <?php } ?>
        @endif
        <?php } ?>


        <div class="container"><a class="ps-logo" href="{{ route('index') }}"><img
                        src="{{ asset($systemSetting->logo) }}"
                        alt=""></a>

            <div class="menu-toggle"><span></span></div>
            <ul class="menu">
                <?php
                $id = 0;
                $menus = Helper::getMenus($id);
                printTerms($menus, $page->slug); ?>
            </ul>
        </div>
    </nav>
</header>