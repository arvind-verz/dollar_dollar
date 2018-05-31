@if(session('success'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success m-b-0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                {!! session('success') !!}
            </div>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger m-b-0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                {!! session('error') !!}
            </div>
        </div>
    </div>
@endif
@if(session('status'))
    <div class="col-lg-12">
        <div class="auth-alert alert text-success m-b-0">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {!! session('status') !!}
        </div>
    </div>
@endif
