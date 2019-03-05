@if(count($legendtable))
<div class="ps-block--legend-table">
    <div class="ps-block__header">
        <h3>Legend table</h3>
    </div>
    <div class="ps-block__content">
        @foreach($legendtable as $legend)
        @if($legend->status==1)
        @if($legend->page_type==FIX_DEPOSIT && $page->slug==FIXED_DEPOSIT_MODE)
        <p>
            <span class="legend-icon" style="background: {{$legend->icon_background}}">
                
            {{$legend->icon}}</span> = {{ $legend->title }}
        </p>
        @elseif($legend->page_type==SAVING_DEPOSIT && $page->slug==SAVING_DEPOSIT_MODE)
        <p>
            <span class="legend-icon" style="background: {{$legend->icon_background}}">{{$legend->icon}}</span> = {{ $legend->title }}
        </p>
        @elseif($legend->page_type==PRIVILEGE_DEPOSIT && $page->slug==PRIVILEGE_DEPOSIT_MODE)
        <p>
            <span class="legend-icon" style="background: {{$legend->icon_background}}">{{$legend->icon}}</span> = {{ $legend->title }}
        </p>
        @elseif($legend->page_type==FOREIGN_CURRENCY_DEPOSIT && $page->slug==FOREIGN_CURRENCY_DEPOSIT_MODE)
        <p>
            <span class="legend-icon" style="background: {{$legend->icon_background}}">{{$legend->icon}}</span> = {{ $legend->title }}
        </p>
        @elseif($legend->page_type==ALL_IN_ONE_ACCOUNT && $page->slug==AIO_DEPOSIT_MODE)
        <p>
            <span class="legend-icon" style="background: {{$legend->icon_background}}">{{$legend->icon}}</span> = {{ $legend->title }}
        </p>
        @endif
        @endif
        @endforeach
    </div>
</div>
@endif