@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
    $slug = CONTACT_SLUG;
    //get banners
    $banners = Helper::getBanners($slug);
    ?>
    {{--Banner section start--}}

    @if($banners->count()>1)
        <div class="ps-home-banner">
            <div class="ps-slider--home owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                 data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
                 data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
                 data-owl-mousedrag="on">
                @foreach($banners as $banner)
                    <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}"><img
                                src="{{asset($banner->banner_image )}}" alt="">

                        <div class="ps-banner__content">
                            {!!$banner->banner_content!!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($banners->count()== 1)
        @foreach($banners as $banner)
            <div class="ps-hero bg--cover" data-background="{{asset($banner->banner_image )}}"><img
                        src="{{asset($banner->banner_image )}}" alt=""></div>
        @endforeach
    @endif

    {{--Banner section end--}}

    <div class="ps-breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a></li>
                @include('frontend.includes.breadcrumb')
            </ol>
        </div>
    </div>

    {{--Page content start--}}
    <div class="ps-page--deposit">
        <?php

        $pageName = explode(' ', trim($page->name));
        $details = [];
        $details['first_heading'] = $pageName[0];
        // $a =  array_shift($arr);
        unset($pageName[0]);
        $details['second_heading'] = implode(' ',$pageName);
        $string = $page->contents;
        $output = preg_replace_callback('~\{{(.*?)\}}~',
                function ($key) use ($details) {
                    $variable[$key[1]] = $details[$key[1]];
                    return $variable[$key[1]];
                },
                $string);
        ?>
        {!! $output !!}}
        <div class="container">
            <div class="ps-block--deposit-filter">
                <div class="ps-block__header"><img src="img/block/list-brand.png" alt=""></div>
                <div class="ps-block__content">
                    <form class="ps-form--filter" action="do_action" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button class="ps-btn filter">Interest</button>
                                    <button class="ps-btn filter">Placement</button>
                                    <button class="ps-btn filter">Tenor</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span>$</span>
                                                <input class="form-control" type="text" placeholder="">
                                            </div>
                                            <button>Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <select class="form-control">
                                            <option value="1">Sort by</option>
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ps-slider--feature-product nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true"
                 data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="4"
                 data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                 data-owl-duration="1000" data-owl-mousedrag="on"
                 data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                 data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                <div class="ps-block--short-product second" data-mh="product"><img src="img/logo/1.png" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
                <div class="ps-block--short-product second" data-mh="product"><img src="img/logo/2.png" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
                <div class="ps-block--short-product second" data-mh="product"><img src="img/logo/3.png" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
                <div class="ps-block--short-product second" data-mh="product"><img src="img/logo/4.png" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
                <div class="ps-block--short-product second" data-mh="product"><img src="img/logo/5.png" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
            </div>
            <div class="ps-block--legend-table">
                <div class="ps-block__header">
                    <h3>Legend table</h3>
                </div>
                <div class="ps-block__content">
                    <p><img src="img/icons/ff.png" alt="">= Fresh funds</p>

                    <p><img src="img/icons/ef.png" alt="">= example funds</p>

                    <p><img src="img/icons/cx.png" alt="">= example funds</p>
                </div>
            </div>
            <div class="ps-product featured-1">
                <div class="ps-product__header"><img src="img/logo/1.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__poster"><a href="#"><img src="img/product/feature-1.jpg" alt=""></a></div>
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product highlight">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>13 Month</th>
                                    <th>13 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            <div class="ps-product">
                <div class="ps-product__header"><img src="img/logo/1.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product highlight">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>13 Month</th>
                                    <th>13 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            <div class="ps-product">
                <div class="ps-product__header"><img src="img/logo/2.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>5 Month</th>
                                    <th>5 Month</th>
                                    <th>11 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            <div class="ps-product">
                <div class="ps-product__header"><img src="img/logo/3.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>5 Month</th>
                                    <th>5 Month</th>
                                    <th>11 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            <div class="ps-product">
                <div class="ps-product__header"><img src="img/logo/4.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>5 Month</th>
                                    <th>5 Month</th>
                                    <th>11 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            <div class="ps-product">
                <div class="ps-product__header"><img src="img/logo/5.png" alt="">

                    <div class="ps-product__promo">
                        <p><span class="highlight"> Promo: </span> Mar 14, 2017 to Mar 31, 2017</p>

                        <p class="text-uppercase">-252 days left</p>
                    </div>
                </div>
                <div class="ps-product__content">
                    <div class="ps-product__table">
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>5 Month</th>
                                    <th>5 Month</th>
                                    <th>11 Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="img/icons/ff.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                    <td>1.20%</td>
                                </tr>
                                <tr>
                                    <td><img src="img/icons/ef.png" alt=""></td>
                                    <td>$20k - $999k</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                    <td>1.10%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ps-product__panel">
                        <h4>Possible interest(s) earned for SGD $50k</h4>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>

                        <p><strong>13 mth</strong>- $266.44 (1.20%)</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__detail">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Criteria</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Fresh funds #</li>
                                            <li>RHB Fixed Deposit account</li>
                                            <li>Placement done at Branch</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <h4 class="ps-product__heading">Keypoints</h4>
                                        <ul class="ps-list--arrow-circle">
                                            <li>Receive interest upfront</li>
                                            <li>Deposit into main account</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                        Page</a><a
                                            class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
        </div>
    </div>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
