<div class="ps-poster-popup">
    <?php
    $current_time = strtotime(date('Y-m-d', strtotime('now')));
    $ad_start_date = strtotime($ads_manage->ad_start_date);
    $ad_end_date = strtotime($ads_manage->ad_end_date);
    ?>
    @if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads_manage->paid_ad_image))
        <a href="{{ isset($ads_manage->paid_ad_link) ? $ads_manage->paid_ad_link : 'javascript:void(0)' }}"
           target="_blank"><img
                    src="{{ isset($ads_manage->paid_ad_image) ? asset($ads_manage->paid_ad_image) : '' }}"
                    alt=""></a>
    @else
        <a href="{{ isset($ads_manage->ad_link) ? $ads_manage->ad_link : 'javascript:void(0)' }}"
           target="_blank"><img
                    src="{{ isset($ads_manage->ad_image) ? asset($ads_manage->ad_image) : '' }}"
                    alt=""></a>
    @endif
</div>