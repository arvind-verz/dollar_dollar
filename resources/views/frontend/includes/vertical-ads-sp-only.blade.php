@if(!empty($ads) && ($page->disable_ads==0))
    <?php
    $current_time = strtotime(date('Y-m-d', strtotime('now')));
    $ad_start_date = strtotime($ads->ad_start_date);
    $ad_end_date = strtotime($ads->ad_end_date);
    ?>
    @if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads->paid_ad_image))
        <div class="ps-post__thumbnail ads sp-only">
            <a href="{{ isset($ads->paid_ad_link) ? asset($ads->paid_ad_link) : '#' }}"
               target="_blank"><img src="{{ asset($ads->paid_ad_image) }}" alt=""></a>
        </div>
    @else
        <div class="ps-post__thumbnail ads sp-only">
            <a href="{{ isset($ads->ad_link) ? asset($ads->ad_link) : '#' }}" target="_blank"><img
                        src="{{ asset($ads->ad_image) }}" alt=""></a>
        </div>
    @endif
@endif