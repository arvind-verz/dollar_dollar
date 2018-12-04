<?php
$promotionId = FIX_DEPOSIT;
if (isset($page)) {
    $pageSlug = $page->slug;
} else {
    $pageSlug = FIXED_DEPOSIT_MODE;
}
if ($pageSlug == FIXED_DEPOSIT_MODE) {
    $promotionId = FIX_DEPOSIT;
} elseif ($pageSlug == SAVING_DEPOSIT_MODE) {
    $promotionId = SAVING_DEPOSIT;
} elseif ($pageSlug == PRIVILEGE_DEPOSIT_MODE) {
    $promotionId = PRIVILEGE_DEPOSIT;
} elseif ($pageSlug == FOREIGN_CURRENCY_DEPOSIT_MODE) {
    $promotionId = FOREIGN_CURRENCY_DEPOSIT;
} elseif ($pageSlug == AIO_DEPOSIT_MODE) {
    $promotionId = ALL_IN_ONE_ACCOUNT;
}
$defaultSearch = \DB::table('default_search')->where('promotion_id', $promotionId)->first();
?>
@if($defaultSearch)
    <span class="display-none" id="placement-id" data-value="{{$defaultSearch->placement}}"></span>
@endif
{!! $systemSetting->footer !!}
