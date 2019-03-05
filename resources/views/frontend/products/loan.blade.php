@extends('frontend.layouts.app')
@section('description')
    <meta name="description" content="{{$page->meta_description}}">
@endsection
@section('keywords')
    <meta name="keywords" content="{{$page->meta_keyword}}">
@endsection
@section('author')
    <meta name="author" content="{{$page->meta_title}}">
@endsection
@section('title', $page->title)
@section('content')
    <?php
    //dd($page);
    $search_filter = isset($search_filter) ? $search_filter : "";
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
    <div class="ps-page--deposit ps-loan">
        <div class="container">
            <?php
            //$pageName = strtok($page->name, " ");;
            $pageName = explode(' ', trim($page->name));
            $pageHeading = $pageName[0];
            // $a =  array_shift($arr);
            unset($pageName[0]);
            ?>
            {{--Page content start--}}
            @if($page->slug!=THANK_SLUG)
                <h3 class="ps-heading mb-20">
                    <span>@if(!empty($page->icon))<i
                                class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                </h3>
                {!!  $page->contents !!}
            @else
                {!!  $page->contents !!}
            @endif
            <div class="ps-block--deposit-filter ">
                <div class="ps-block__content">
                    <form id="search-form" class="ps-form--filter"
                          action="{{ URL::route('loan.search') }}#logo-detail"
                          method="post">
                        <h4>fill in your property loan details</h4>

                        <div class="ps-form__values">
                            <div class="form-group--label form-group--label1">
                                <div class="form-group__content">
                                    <label>Rate Type
                                        @if(isset($toolTips->rate_type))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTips->rate_type}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                    </label>
                                    <select class="form-control" name="rate_type">
                                        <option value="{{BOTH_VALUE}}"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==BOTH_VALUE) selected @endif>{{BOTH_VALUE}}</option>
                                        <option value="{{FIXED_RATE}}"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==FIXED_RATE) selected @endif>{{FIXED_RATE}}</option>
                                        <option value="{{FLOATING_RATE}}"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==FLOATING_RATE) selected @endif>{{FLOATING_RATE}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label2">
                                <div class="form-group__content">
                                    <label>Tenure (Yrs) @if(isset($toolTips->tenure))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTips->tenure}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                    </label>
                                    <select class="form-control" name="tenure">
                                        @for($i=1;$i<=35;$i++)
                                            <option value="{{$i}}"
                                                    @if(isset($searchFilter['tenure']) && $searchFilter['tenure']==$i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label3">
                                <div class="form-group__content">
                                    <label>Property Type @if(isset($toolTips->property_type))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTips->property_type}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                    </label>
                                    <select class="form-control" name="property_type">
                                        {{--<option value="{{ALL}}"
                                        @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==ALL) selected @endif>{{ALL}}</option>--}}
                                        <option value="{{HDB_PROPERTY}}"
                                                @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==HDB_PROPERTY) selected @endif>{{HDB_PROPERTY}}</option>
                                        <option value="{{PRIVATE_PROPERTY}}"
                                                @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==PRIVATE_PROPERTY) selected @endif>{{PRIVATE_PROPERTY}}</option>
                                        <option value="{{COMMERCIAL_PROPERTY}}"
                                                @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==COMMERCIAL_PROPERTY) selected @endif>
                                            Commercial Individual
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label4">
                                <div class="form-group__content">
                                    <label>Completion @if(isset($toolTips->completion))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTips->completion}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif</label>
                                    <select class="form-control" name="completion">
                                        <option value="{{COMPLETE}}"
                                                @if(isset($searchFilter['completion']) && $searchFilter['completion']==COMPLETE) selected @endif>{{COMPLETE}}</option>
                                        <option value="{{BUC}}"
                                                @if(isset($searchFilter['completion']) && $searchFilter['completion']==BUC) selected @endif>{{BUC}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <a class="btn refresh form-control "
                                   href="{{url(LOAN_MODE)}}/#logo-detail"> <i
                                            class="fa fa-refresh"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option flex-box">
                                    <label>Sort by:</label>
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==INTEREST) active @endif">
                                        <input type="radio" name="filter" value="{{INTEREST}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') checked @endif>{{INTEREST}}
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) active @endif">
                                        <input type="radio" name="filter" value="{{TENURE}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) checked @endif>Lock
                                        in
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==INSTALLMENT) active @elseif(empty($searchFilter)) active @endif">
                                        <input type="radio" name="filter" value="{{INSTALLMENT}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']==INSTALLMENT) checked
                                               @elseif(empty($searchFilter)) checked @endif>{{MINIMUM_LOAN_AMOUNT}}
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 form-group--label">
										<div class="form-group__content flex-box">
											<label>Loan
                                                @if(isset($toolTips->loan))
                                                    <a class="ps-tooltip" href="javascript:void(0)"
                                                       data-tooltip="{{$toolTips->loan}}"><i
                                                                class="fa fa-exclamation-circle"></i></a>
                                                @endif
											</label>
											<div class="form-group form-group--nest">
												<div class="form-group__content">
													<input class="form-control only_numeric prefix_dollar" type="text"
														   placeholder=""
														   name="search_value" id="search_value"
														   value="{{ isset($searchFilter['search_value']) ? $searchFilter['search_value'] : '' }}"/>
												</div>
												<button type="submit">Go</button>
											</div>
										</div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 refresh-button for1">
                                        <div class="form-group ">
                                            <a class="btn refresh form-control " style="width: 73px;"
                                               href="{{url(AIO_DEPOSIT_MODE)}}/#logo-detail"> <i
                                                        class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 for">
                                        <div class="form-group  ">
                                            <select class="form-control sort-by" name="sort_by">
                                                <option value="" disabled="disabled" selected="selected">Arrange By
                                                </option>
                                                <option value="1"
                                                        @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==1) selected @endif>
                                                    Ascending
                                                </option>
                                                <option value="2"
                                                        @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==2) selected @endif>
                                                    Descending
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 refresh-button for2">
                                        <div class="form-group ">
                                            <a class="btn refresh form-control " style="width: 73px;"
                                               href="{{url(AIO_DEPOSIT_MODE)}}/#logo-detail"> <i
                                                        class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($products))
                @include('loanProductsInnerSlider')
                @include('loanSpInnerProductsSlider')
            @endif
            <?php
            $adspopup = json_decode($page->ads_placement);
            $j = 1;
            ?>
            @if(count($products))
                @foreach($products as $product)
                    <?php
                    $productRanges = $product->product_range;
                    $ads = json_decode($product->ads_placement);
                    ?>
                    @if($page->slug==LOAN_MODE && isset($ads[3]->ad_horizontal_image_popup_top))
                        <div class="ps-poster-popup">
                            <div class="close-popup">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                            <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
                               target="_blank"><img
                                        src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                                        alt=""></a>
                        </div>
                    @endif
                    <div class="ps-product @if($product->featured==1)featured-1 @endif"
                         id="p-{{ $j }}">
                        <div class="ps-product__header">
                            <div class="slider-img"><img  alt=""
                                                         src="{{ asset($product->brand_logo) }}"></div>
                            <div class="ps-product__promo left">
                                @if($product->shortlist_status==1)
                                    <label class="ps-btn--checkbox ">
                                        <input type="checkbox" id="" name="short_list_ids[]"
                                               value="{{$product->product_id}}"
                                               class="checkbox short-list"><span></span>Shortlist
                                        this
                                        Loan
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="ps-loan__text1">{!! $product->bank_sub_title !!}</div>
                        <div class="ps-loan-content ps-loan-content1">
                            @if(!empty($product->ads_placement))
                                @php
                                $ads = json_decode($product->ads_placement);
                                if(!empty($ads[0]->ad_image_horizontal)) {
                                @endphp
                                <div class="ps-product__poster"><a
                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                                            target="_blank"><img
                                                src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                                alt=""></a></div>
                                @php } @endphp
                            @endif
                            @if($product->formula_id==LOAN_F1)
                                <div class="ps-product__table loan_table">
                                    <div class="ps-table-wrap">
                                        <table class="ps-table ps-table--product">
                                            <thead>
                                            <tr>
                                                <th>YEARS</th>
                                                <th>INTEREST RATE (PA)</th>
                                                <th>Monthly Installment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($productRanges as $key=> $productRange)

                                                <tr>
                                                    <td class=" @if($productRange->tenure_highlight==true) highlight @endif">
                                                        YEAR {{$productRange->tenure}}</td>
                                                    <td>{{$productRange->bonus_interest+$productRange->rate_interest_other}}%
                                                        @if(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&&empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&!empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->bonus_interest}}%
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                            ({{$productRange->rate_name_other}})
                                                        @elseif(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&!empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                            ({{$productRange->rate_name_other}})
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& empty($productRange->rate_interest_other))
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->bonus_interest}}%
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                        @elseif(empty($productRange->floating_rate_type)&&empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                        @elseif(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                        @endif
                                                    </td>
                                                    <td class=" @if($productRange->tenure_highlight==true) highlight @endif ">
                                                        ${{round($productRange->monthly_payment)}} / mth
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class=" @if($product->highlight==true) highlight @endif ">THEREAFTER
                                                </td>
                                                <td>
                                                    {{($productRanges[0]->there_after_bonus_interest + $productRanges[0]->there_after_rate_interest_other)}}%
                                                    @if(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&&empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&!empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_bonus_interest}}%
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                        ({{$productRanges[0]->there_after_rate_name_other}})
                                                    @elseif(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&!empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                        ({{$productRanges[0]->there_after_rate_name_other}})
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& empty($productRanges[0]->there_after_rate_interest_other))
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_bonus_interest}}%
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                    @elseif(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                    @endif
                                                </td>
                                                <td class=" @if($product->highlight==true) highlight @endif ">
                                                    ${{round($product->there_after_installment)}} / mth
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if(isset($ads[1]))
                                    <?php
                                    if(!empty($ads[1]->ad_image_vertical)) {
                                    ?>
                                    <div class="ps-product__poster">
                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                           target="_blank"><img class="img-center"
                                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                alt=""></a>
                                    </div>
                                    <?php } ?>
                                @endif
                                <div class="ps-loan-right">
                                    <h4>For ${{ Helper::inThousand($product->placement) }} loan
                                        with {{$product->tenure}}
                                        years&emsp;Loan Tenure</h4>

                                    <div class="width-50">
                                        <p>Rate Type : <br/><strong>{{$productRanges[0]->rate_type}}
                                                @if($productRanges[0]->rate_type_name)
                                                    ({{$productRanges[0]->rate_type_name}}) @endif</strong></p>

                                        <p>Lock In : <br/><strong>{{$product->lock_in}} Years</strong></p>

                                        <p>Property : <br/><strong>{{$productRanges[0]->property_type}}</strong></p>
                                    </div>
                                    <div class="width-50">
                                        <p>Rate : <br/><strong>{{$product->avg_interest}}% ({{$product->avg_tenure}}
                                                yrs avg)</strong></p>

                                        <p>Mthly Instalment :<br/>
                                            <strong>${{round($product->monthly_installment)}} ({{$product->avg_tenure}}
                                                yrs avg)</strong>
                                        </p>

                                        <p>Minimum Loan :
                                            <br/>
                                            <strong>${{ Helper::inThousand($product->minimum_loan_amount) }}
                                            </strong>
                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        @if(!empty($product->ads_placement))
                            @php
                            $ads = json_decode($product->ads_placement);
                            if(!empty($ads[2]->ad_horizontal_image_popup)) {
                            @endphp
                            <div class="ps-poster-popup">
                                <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <a target="_blank"
                                   href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
                                            src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                            alt="" target="_blank"></a>
                            </div>
                            @php } @endphp
                        @endif
                        <div class="ps-product__detail">
                            {!! $product->product_footer !!}
                        </div>
                        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
                                        class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
                                                                            href="#">More data<i
                                        class="fa fa-angle-down"></i></a></div>
                    </div>
                    @if(count($products)>=2)
                        @if(!empty($ads_manage) && $ads_manage->page_type==LOAN_MODE && $j==2)
                            @include('frontend.includes.product-ads')
                        @endif
                    @elseif(empty($remainingProducts->count()) && $j==$products->count())
                        @if(!empty($ads_manage) && $ads_manage->page_type==LOAN_MODE)
                            @include('frontend.includes.product-ads')
                        @endif
                    @endif
                    @php $j++; @endphp
                @endforeach
            @else
                    <div class="ps-block--legend-table1 " style="margin-top: 20px;">
                        <div class="ps-block__content text-center">
                            <p>{{CRITERIA_ERROR}}</p>
                        </div>
                    </div>
            @endif
            @if(count($remainingProducts))
                @foreach($remainingProducts as $product)
                    <?php
                    $productRanges = $product->product_range;
                    $ads = json_decode($product->ads_placement);
                    ?>
                    @if($page->slug==LOAN_MODE && isset($ads[3]->ad_horizontal_image_popup_top))
                        <div class="ps-poster-popup">
                            <div class="close-popup">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                            <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
                               target="_blank"><img
                                        src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                                        alt=""></a>
                        </div>
                    @endif
                    <div class="ps-product " id="r-{{ $product->product_id }}">
                        <div class="ps-product__header">
                            <div class="slider-img"><img  alt=""
                                                         src="{{ asset($product->brand_logo) }}"></div>
                            <div class="ps-product__promo left">
                                @if($product->shortlist_status==1)
                                    <label class="ps-btn--checkbox ">
                                        <input type="checkbox" id="" name="short_list_ids[]"
                                               value="{{$product->product_id}}"
                                               class="checkbox short-list"><span></span>Shortlist
                                        this
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="ps-loan__text1">{!! $product->bank_sub_title !!}</div>
                        @if(!empty($product->ads_placement))
                            @php
                            $ads = json_decode($product->ads_placement);
                            if(!empty($ads[0]->ad_image_horizontal)) {
                            @endphp
                            <div class="ps-product__poster"><a
                                        href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                                        target="_blank"><img
                                            src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                            alt=""></a></div>
                            @php } @endphp
                        @endif
                        <div class="ps-loan-content ps-loan-content1">
                            @if($product->formula_id==LOAN_F1)
                                <div class="ps-product__table loan_table">
                                    <div class="ps-table-wrap">
                                        <table class="ps-table ps-table--product">
                                            <thead>
                                            <tr>
                                                <th>YEARS</th>
                                                <th>INTEREST RATE (PA)</th>
                                                <th>Monthly Installment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($productRanges as $key=> $productRange)

                                                <tr>
                                                    <td class=" ">
                                                        YEAR {{$productRange->tenure}}</td>
                                                    <td>{{$productRange->bonus_interest+$productRange->rate_interest_other}}%
                                                        @if(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&&empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&!empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->bonus_interest}}%
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                            ({{$productRange->rate_name_other}})
                                                        @elseif(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&!empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                            ({{$productRange->rate_name_other}})
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& empty($productRange->rate_interest_other))
                                                        @elseif(empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->bonus_interest}}%
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                        @elseif(empty($productRange->floating_rate_type)&&empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                        @elseif(!empty($productRange->floating_rate_type)&&!empty($productRange->bonus_interest)&&empty($productRange->rate_name_other)&& !empty($productRange->rate_interest_other))
                                                            = {{$productRange->floating_rate_type}}
                                                            @if($productRange->rate_interest_other<0)-@else
                                                                +@endif {{abs($productRange->rate_interest_other)}}%
                                                        @endif
                                                    </td>
                                                    <td class="">
                                                        ${{round($productRange->monthly_payment)}} / mth
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="  ">THEREAFTER
                                                </td>
                                                <td>
                                                    {{($productRanges[0]->there_after_bonus_interest + $productRanges[0]->there_after_rate_interest_other)}}%
                                                    @if(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&&empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&!empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_bonus_interest}}%
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                        ({{$productRanges[0]->there_after_rate_name_other}})
                                                    @elseif(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&!empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                        ({{$productRanges[0]->there_after_rate_name_other}})
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& empty($productRanges[0]->there_after_rate_interest_other))
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_bonus_interest}}%
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                    @elseif(empty($productRanges[0]->there_after_rate_type)&&empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                    @elseif(!empty($productRanges[0]->there_after_rate_type)&&!empty($productRanges[0]->there_after_bonus_interest)&&empty($productRanges[0]->there_after_rate_name_other)&& !empty($productRanges[0]->there_after_rate_interest_other))
                                                        = {{$productRanges[0]->there_after_rate_type}}
                                                        @if($productRange->there_after_rate_interest_other<0)-@else
                                                            +@endif {{abs($productRange->there_after_rate_interest_other)}}%
                                                    @endif
                                                </td>
                                                <td class=" ">
                                                    ${{round($product->there_after_installment)}} / mth
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if(isset($ads[1]))
                                    <?php
                                    if(!empty($ads[1]->ad_image_vertical)) {
                                    ?>
                                    <div class="ps-product__poster">
                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                           target="_blank"><img class="img-center"
                                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                alt=""></a>
                                    </div>
                                    <?php } ?>
                                @endif
                                <div class="ps-loan-right disable">
                                    <h4>For ${{ Helper::inThousand($product->placement) }} loan
                                        with {{$product->tenure}}
                                        years&emsp;Loan Tenure</h4>
                                    <p style="color:#303030 !important; padding:15px; font-weight: 800; ">Loan amount is not eligible for this Loan Package</p>

                                    <div class="width-50">
                                        <p>Rate Type : <br/><strong>{{$productRanges[0]->rate_type}}
                                                @if($productRanges[0]->rate_type_name)
                                                    ({{$productRanges[0]->rate_type_name}}) @endif</strong></p>

                                        <p>Lock In : <br/><strong>{{$product->lock_in}} Years</strong></p>

                                        <p>Property : <br/><strong>{{$productRanges[0]->property_type}}</strong></p>
                                    </div>
                                    <div class="width-50">
                                        <p>Rate : <br/><strong>{{$product->avg_interest}}% ({{$product->avg_tenure}}
                                                yrs avg)</strong></p>

                                        <p>Mthly Instalment :<br/>
                                            <strong>${{round($product->monthly_installment)}} ({{$product->avg_tenure}}
                                                yrs avg)</strong>
                                        </p>

                                        <p>Minimum Loan :
                                            <br/>
                                            <strong>${{ Helper::inThousand($product->minimum_loan_amount) }}
                                            </strong>
                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        @if(!empty($product->ads_placement))
                            @php
                            $ads = json_decode($product->ads_placement);
                            if(!empty($ads[2]->ad_horizontal_image_popup)) {
                            @endphp
                            <div class="ps-poster-popup">
                                <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <a target="_blank"
                                   href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
                                            src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                            alt="" target="_blank"></a>
                            </div>
                            @php } @endphp
                        @endif
                        <div class="ps-product__detail">
                            {!! $product->product_footer !!}
                        </div>
                        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
                                        class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
                                                                            href="#">More data<i
                                        class="fa fa-angle-down"></i></a></div>
                    </div>
                    @if($products->count()<2 && $remainingProducts->count()>=2)
                        @if(!empty($ads_manage) && $ads_manage->page_type==LOAN_MODE && $j==2)
                            @include('frontend.includes.product-ads')
                        @endif
                    @elseif(empty($products->count()) && $j==$remainingProducts->count())
                        @if(!empty($ads_manage) && $ads_manage->page_type==LOAN_MODE)
                            @include('frontend.includes.product-ads')
                        @endif
                    @endif
                    @php $j++; @endphp
                @endforeach
            @endif
        </div>
        {{--Page content end--}}
        {{--contact us or what we offer section start--}}
        @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
            {!! $systemSetting->{$page->contact_or_offer} !!}
        @endif
        {{--contact us or what we offer section end--}}
        <div class="ps-loan-popup">
            {!! Form::open(['url' => ['loan-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" name="rate_type_search" value=""/>
            <input type="hidden" name="tenure_search" value=""/>
            <input type="hidden" name="property_type_search" value=""/>
            <input type="hidden" name="completion_search" value=""/>
            <input type="hidden" name="product_ids" value=""/>
            <input type="hidden" name="loan_amount" value=""/>

            <p>Speak with a mortgage specialist to know more about the loan you have shortlisted!</p>
            <button type="submit" class="ps-btn" id="loan-enquiry">ENQUIRE NOW</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection