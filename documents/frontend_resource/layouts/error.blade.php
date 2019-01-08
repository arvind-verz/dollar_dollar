@if($errors ->any())
    <div class="row">
        <div class="col-lg-12">
            @if(isset($errors))
            <div class="alert alert-danger m-b-0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif