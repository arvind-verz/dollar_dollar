@if(!empty($ads) && ($page->disable_ads==0))
        <?php
        $current_time = strtotime(date('Y-m-d', strtotime('now')));
        $ad_start_date = strtotime($ads->ad_start_date);
        $ad_end_date = strtotime($ads->ad_end_date);
        ?>

        @if($ads->paid_ads_status==1 && $current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads->horizontal_paid_ad_image))
            <div class="pt-2">
                <a href="{{ isset($ads->horizontal_paid_ad_link) ? asset($ads->horizontal_paid_ad_link) : '#' }}"
                   target="_blank"><img src="{{ asset($ads->horizontal_paid_ad_image) }}"
                                        alt=""></a>
            </div>
        @else

            @if(!empty($ads->horizontal_banner_ad_image))
                <div class="pt-2">
                    <a href="{{ isset($ads->horizontal_banner_ad_link) ? asset($ads->horizontal_banner_ad_link) : '#' }}"
                       target="_blank"><img src="{{ asset($ads->horizontal_banner_ad_image) }}"
                                            alt=""></a>
                </div>
            @endif
        @endif
@endif