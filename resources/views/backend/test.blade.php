@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active"><a href="{{ route('promotion-products') }}">{{PRODUCT_MODULE}}</a></li>
            <li class="active">{{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="rootwizard">
                        <ul class="nav nav-tabs pull-right">

                            <li><a href="#basic-detail" data-toggle="tab">Other Detail</a></li>
                            <li><a href="#formula-detail" data-toggle="tab">Formula Detail</a></li>
                            <li class="active"><a href="#product-detail" data-toggle="tab">Product Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>

                        </ul>
                        <div class="box-body">

                            {!! Form::open(['class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->

                            <div class="tab-content">
                                <div class="tab-pane active" id="product-detail">
                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', old('name'), ['id'=>'','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Bank</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="bank">
                                                <option value="">None</option>
                                                @if($banks->count())
                                                    @foreach($banks as $bank)
                                                        <option value="{{$bank->id}}"
                                                                @if(old('bank')==$bank->id) selected="selected" @endif>{{$bank->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Product Type</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="product_type" id="product-type">
                                                <option value="">None</option>
                                                @if($promotion_types->count())
                                                    @foreach($promotion_types as $product_type)
                                                        <option value="{{$product_type->id}}"
                                                                @if(old('product_type') == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Formula</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="formula">
                                                <option value="">None</option>
                                            </select>
                                            <input type="hidden" id="hidden-formula" value="{{ old('formula') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Date Range</label>

                                        <div class="col-sm-4">
                                            <div class="input-group date">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success">Start
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       name="promotion_start_date"
                                                       value="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) :date('Y-m-d', time())  }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 ">

                                            <div class="input-group date ">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-danger">End
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       name="promotion_end_date"
                                                       value="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :date('Y-m-d', time())  }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="status"
                                                    style="width: 100%;">
                                                <option value="1" @if(old('status') == 1) selected="selected" @endif>
                                                    Active
                                                </option>
                                                <option value="0" @if(old('status') == 0) selected="selected" @endif>
                                                    Deactivate
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Featured</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="featured"
                                                    style="width: 100%;">
                                                <option value="0" @if(old('featured') == 0) selected="selected" @endif >
                                                    No
                                                </option>
                                                <option value="1" @if(old('featured') == 1) selected="selected" @endif>
                                                    Yes
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="formula-detail">
                                    @if(count(old('min_placement')))
                                        <?php //dd(old('min_placement')[0]); ?>
                                        @foreach(old('min_placement') as $key => $value)

                                            <div id="placement_range_{{$key}}">
                                                <div class="form-group">
                                                    <label for="title" class="col-sm-2 control-label">Formula
                                                        Detail</label>

                                                    <div class="col-sm-4">
                                                        <div class="input-group date">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-success">Min
                                                                    Placement
                                                                </button>
                                                            </div>
                                                            <input type="text" class="form-control pull-right "
                                                                   name="min_placement[{{$key}}]"
                                                                   value="{{ old('min_placement')[$key]  }}">

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 ">

                                                        <div class="input-group date ">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-danger">Max
                                                                    Placement
                                                                </button>
                                                            </div>
                                                            <input type="text" class="form-control pull-right"
                                                                   name="max_placement[{{$key}}]"
                                                                   value="{{ old('max_placement')[$key]  }}">

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button"
                                                                class="btn btn-info pull-left mr-15 add-placement-range-button 1"
                                                                data-range-id="0"
                                                                onClick="addMorePlacementRange(this);"><i
                                                                    class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-danger -pull-right  remove-placement-range-button display-none"
                                                                data-range-id="0" onClick="removePlacementRange(this);">
                                                            <i
                                                                    class="fa fa-minus"> </i>
                                                        </button>
                                                    </div>

                                                </div>
                                                @if(count(old('tenure_type')[$key]))

                                                    @foreach(old('tenure_type')[$key] as $k => $v)

                                                        <div class="form-group " id="formula_detail_{{$key}}">
                                                            <label for="title" class="col-sm-2 control-label"></label>

                                                            <div class="col-sm-6 ">
                                                                <div class="form-row">
                                                                    <div class="col-md-4 mb-3">
                                                                        <label for="">Tenure Type</label>
                                                                        <select class="form-control "
                                                                                data-placeholder=""
                                                                                name="tenure_type[{{$key}}][{{$k}}]"
                                                                                style="width: 100%;">
                                                                            <option value="None" selected="selected">
                                                                                None
                                                                            </option>
                                                                            <option value="1"
                                                                                    @if(old('tenure_type')[$key][$k] == 1)selected="selected" @endif>
                                                                                Day
                                                                            </option>
                                                                            <option value="2"
                                                                                    @if(old('tenure_type')[$key][$k] == 2)selected="selected" @endif>
                                                                                Month
                                                                            </option>
                                                                            <option value="3"
                                                                                    @if(old('tenure_type')[$key][$k] == 3)selected="selected" @endif>
                                                                                Year
                                                                            </option>

                                                                        </select>
                                                                        <?php // dd(old('tenure')[$key][{{$k}}]));?>
                                                                    </div>
                                                                    <div class="col-md-4 mb-3">
                                                                        <label for="">Tenur</label>
                                                                        <input type="text" class="form-control" id=""
                                                                               name="tenure[{{$key}}][{{$k}}]"
                                                                               value="{{old('tenure')[$key][$k]}}"
                                                                               placeholder="">

                                                                    </div>
                                                                    <div class="col-md-4 mb-3">
                                                                        <label for="">Bonus Interest</label>
                                                                        <input type="text" class="form-control" id=""
                                                                               name="bonus_interest[{{$key}}][{{$k}}]"
                                                                               value=" {{old('bonus_interest')[$key][$k] }}"
                                                                               placeholder="">

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1 col-sm-offset-1 ">
                                                                <button type="button"
                                                                        class="btn btn-info pull-left mr-15"
                                                                        id="add-formula-detail-{{$key}}{{$k}}"
                                                                        data-formula-detail-id="{{$k}}"
                                                                        data-range-id="{{$key}}"
                                                                        onClick="addMoreFormulaDetail(this);"><i
                                                                            class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger -pull-right display-none"
                                                                        id="remove-formula-detail-{{$key}}{{$k}}"
                                                                        data-formula-detail-id="{{$k}}"
                                                                        data-range-id="{{$key}}"
                                                                        onClick="removeFormulaDetail(this);"><i
                                                                            class="fa fa-minus"> </i>
                                                                </button>
                                                            </div>
                                                            <div class="col-sm-2">&emsp;</div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div id="new-formula-detail-{{$key}}"></div>

                                            </div>
                                        @endforeach

                                    @else

                                        <div id="placement_range_0">
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group date">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success">Min
                                                                Placement
                                                            </button>
                                                        </div>
                                                        <input type="text" class="form-control pull-right "
                                                               name="min_placement[0]"
                                                               value="{{ old('min_placement') ? old('min_placement') :''  }}">

                                                    </div>
                                                </div>

                                                <div class="col-sm-4 ">

                                                    <div class="input-group date ">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-danger">Max Placement
                                                            </button>
                                                        </div>
                                                        <input type="text" class="form-control pull-right"
                                                               name="max_placement[0]"
                                                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                                                    </div>

                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button"
                                                            class="btn btn-info pull-left mr-15 add-placement-range-button 1"
                                                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                                                class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger -pull-right  remove-placement-range-button display-none"
                                                            data-range-id="0" onClick="removePlacementRange(this);"><i
                                                                class="fa fa-minus"> </i>
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="form-group " id="formula_detail_0">
                                                <label for="title" class="col-sm-2 control-label"></label>

                                                <div class="col-sm-6 ">
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Tenure Type</label>
                                                            <select class="form-control "
                                                                    data-placeholder="" name="tenure_type[0][]"
                                                                    style="width: 100%;">
                                                                <option value="None" selected="selected">None</option>
                                                                <option value="1">Day</option>
                                                                <option value="2">Month</option>
                                                                <option value="3">Year</option>

                                                            </select>

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Tenur</label>
                                                            <input type="text" class="form-control" id=""
                                                                   name="tenure[0][]"
                                                                   placeholder="">

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Bonus Interest</label>
                                                            <input type="text" class="form-control" id=""
                                                                   name="bonus_interest[0][]"
                                                                   placeholder="">

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-1 col-sm-offset-1 ">
                                                    <button type="button"
                                                            class="btn btn-info pull-left mr-15"
                                                            id="add-formula-detail-00"
                                                            data-formula-detail-id="0" data-range-id="0"
                                                            onClick="addMoreFormulaDetail(this);"><i
                                                                class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger -pull-right display-none"
                                                            id="remove-formula-detail-00"
                                                            data-formula-detail-id="0" data-range-id="0"
                                                            onClick="removeFormulaDetail(this);"><i
                                                                class="fa fa-minus"> </i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-2">&emsp;</div>
                                            </div>
                                            <div id="new-formula-detail-0"></div>
                                        </div>
                                    @endif
                                    <div id="new-placement-range"></div>

                                </div>

                                <div class="tab-pane" id="basic-detail">
                                    <div class="form-group">
                                        {{Form::label('criteria', 'Criteria',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('criteria', old('criteria'), ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{Form::label('key_points', 'Key Points',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('key_points', old('key_points'), ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_poster', 'Advertisement Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_poster', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Advertisement Type</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="ad_type"
                                                    style="width: 100%;">
                                                <option value="">None</option>
                                                <option value="1" @if(old('ad_type') == 1) selected="selected" @endif>
                                                    Horizontal
                                                </option>
                                                <option value="2" @if(old('ad_type') == 2) selected="selected" @endif>
                                                    Vertical
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_link', 'Advertisement Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_link', old('ad_link'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{Form::label('main_page_link', 'Main Page Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('main_page_link', old('main_page_link'), ['id'=>'link_main_page','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('tc_link', 'T&C Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('tc_link', old('tc_link'), ['id'=>'link_tc','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer wizard">
                                <a href="{{ route('promotion-products') }}"
                                   class="btn btn-default back"><i class="fa fa-close">
                                    </i> Cancel</a>
                                <a href="javascript:;" class="btn btn-warning previous"><i
                                            class="fa  fa-angle-double-left"></i> Previous</a>
                                <a href="javascript:;" class=" btn btn-warning pull-right next">Next <i
                                            class="fa  fa-angle-double-right "></i></a>
                                <button type="submit" class="btn btn-info pull-right finish"><i
                                            class="fa  fa-check"></i>
                                    Add
                                </button>
                                </ul>
                            </div>
                            <!-- /.tab-content -->
                            {!! Form::close() !!}

                        </div>
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->

    </section>

    <!-- /.content -->
    <script type="text/javascript">

        $(document).ready(function () {
            var promotion_type = $("#product-type").val();
            var formula = $("#hidden-formula").val();


            //alert(product_name_id);
            if ((promotion_type.length != 0) && (formula.length != 0)) {
                //alert(formula);
                $.ajax({
                    method: "POST",
                    url: "{{url('/admin/promotion-products/get-formula')}}",
                    data: {promotion_type: promotion_type, formula: formula},
                    cache: false,
                    success: function (data) {
                        $("select[name='formula']").html(data);
                    }
                });

            }


        });
        $("select[name='product_type']").on("change", function () {
            var promotion_type = $(this).val();
            var formula = $("#formula").val();
            //alert(formula);
            $.ajax({
                method: "POST",
                url: "{{url('/admin/promotion-products/get-formula')}}",
                data: {promotion_type: promotion_type, formula: formula},
                cache: false,
                success: function (data) {
                    $("select[name='formula']").html(data);
                }
            });

        });
    </script>
@endsection



        <!-- Scripts -->
    <script>
        /*tinymce.init({
         selector: "textarea.plain-text-area ",  // change this value according to your HTML
         plugins: "textcolor colorpicker ",
         content_css : "mycontent.css",
         toolbar: "forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify| fontsizeselect",
         fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
         height: "100"
         });*/

        var editor_config = {
            path_absolute: "{{ URL::to('/') }}/",
            selector: "textarea",
            content_css: [
                '/dollar_dollar/public/frontend/css/plugin.css',
                '/dollar_dollar/public/frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css',
                '/dollar_dollar/public/frontend/plugins/jquery-ui/jquery-ui.min.css',
                '/dollar_dollar/public/frontend/css/main.css',
                '/dollar_dollar/public/frontend/css/custom.css'
            ],
            toolbar: "insert | insertfile  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | forecolor backcolor | image | code",
            setup: function (ed) {
                window.tester = ed;
                ed.addButton('mybutton', {
                    title: 'My button',
                    text: 'Insert variable',
                    onclick: function () {
                        ed.plugins.variables.addVariable('account_id');
                    }
                });

                ed.on('variableClick', function (e) {
                    console.log('click', e);
                });
            },
            plugins: [
                "advlist autolink lists link  charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars   fullscreen",
                "insertdatetime  nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern image", "variables code"
            ],
            variable_mapper: {
                username: 'Username',
                phone: 'Phone',
                community_name: 'Community name',
                email: 'Email address',
                sender: 'Sender name',
                account_id: 'Account ID'
            },
            font_formats: 'Roboto,sans-serif;',
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
            menubar: "tools",
            relative_urls: false,
            table_default_attributes: {
                border: '1'
            },
            table_responsive_width: true,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }
                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };
        tinymce.init(editor_config);

        // Load multiple scripts
        var scriptLoader = new tinymce.dom.ScriptLoader();

        scriptLoader.add('/dollar_dollar/public/frontend/js/jquery.min.js');
        scriptLoader.add('/dollar_dollar/public/frontend/js/plugin.js');
        scriptLoader.add('/dollar_dollar/public/frontend/plugins/jquery-ui/jquery-ui.min.js');
        scriptLoader.add('/dollar_dollar/public/frontend/js/main.js');

        tinymce.init({
            selector: "textarea.text-color-base ",  // change this value according to your HTML
            plugins: "textcolor colorpicker ",
            toolbar: "forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify| fontsizeselect",
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
            height: "100"
        });


    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".only_numeric").numeric();
        });

        function check_url(link) {
            //alert(link);
            //Get input value
        }
        $(document).ready(function () {
            //Date picker
            $('.datepicker1').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

    </script>

    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{ asset('backend/bower_components/DataTables/datatables.min.js' ) }}"></script>
    <script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('frontend/js/jquery.numeric.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="{{ asset('backend/bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('backend/bower_components/morris.js/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }} "></script>
    <script src="{{ asset('backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('backend/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('backend/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('backend/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- datepicker -->
    <script src="{{ asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ asset('backend/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{--<script src="{{ asset('backend/dist/js/demo.js')}}"></script>--}}
    {{--multiple tag add at a time JS--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular.min.js"></script>
    <script src="{{ asset('backend/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('backend/dist/bootstrap-tagsinput-angular.min.js')}}"></script>
    <script src="{{ asset('backend/dist/js/jquery.bootstrap.wizard.js')}}"></script>

    <script>
        $(document).ready(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('#reports').DataTable();

            $('#activities').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[6, 'desc']],
                        "columnDefs": []
                    });
            $('#users').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        "columnDefs": []
                    });
            $('#admins').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[5, 'desc'], [4, 'desc']],
                        "columnDefs": []
                    });
            $('#banners').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[0, 'asc'], [3, 'asc']],
                        "columnDefs": []
                    });
            $('#brands').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[3, 'asc']],
                        "columnDefs": []
                    });

            $('#pages').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[0, 'asc']],
                        "columnDefs": []
                    });
            $('#products').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[9, 'desc']],
                        "columnDefs": []
                    });
            $('#menus').DataTable(
                    {
                        "pageLength": 10,
                        'ordering': true,
                        'order': [[1, 'asc']],
                        "columnDefs": []
                    });
            $('#report').DataTable(
                    {
                        dom: 'Bfrtip',
                        "pageLength": 50,
                        buttons: [
                            {
                                text: 'Export Customers Report',
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7]
                                },
                                filename: function(){
                                    var today = new Date();
                                    var dd = today.getDate();
                                    var mm = today.getMonth() + 1; //January is 0!
                                    var yyyy = today.getFullYear();
                                    if (dd < 10) {
                                        dd = '0' + dd
                                    }
                                    if (mm < 10) {
                                        mm = '0' + mm
                                    }
                                    today = yyyy+''+mm+''+dd;
                                    return today + '-Customers-Report';
                                }
                            }
                        ],
                    });

            $('#rootwizard').bootstrapWizard();

        });

    </script>
    <script type="text/javascript">

        function addMoreTextArea() {
            // Layout options
            var $newTextArea = $('<div />', {
                'id': '',
                'class': 'form-group'
            });
            $newTextArea.append(
                    '<label class="col-sm-2 control-label">'
                    + '</label>'
                    + '<div class="col-sm-10">'
                    + '<div class="input-group">'
                    + '<textarea class="form-control " name="contact_addresses[]">'
                    + '</textarea>'
                    + '<span class="input-group-addon btn-info" onClick="addMoreTextArea();">'
                    + '<i class="fa fa-plus-square">'
                    + '</i>'
                    + '</span>'
                    + '</div>'
                    + '</div>'
            );
            $('#inner').append($newTextArea);
            tinymce.init(editor_config);
        }
        function addMorePlacementRange(id) {
            var tenure = $("input[name='tenure[0]']").val();
            var range_id = $(id).data('range-id');
            range_id++;
            $(id).addClass('display-none');
            $(".remove-placement-range-button").removeClass('display-none');


            $('#add-placement-range-button').remove();
            // Layout options
            var $newTextArea = $('<div>', {
                'id': 'placement_range_' + range_id
            });


            $newTextArea.append(
                    '<div class="form-group" id="placement_range_'+range_id+'">'
                    + '<label class="col-sm-2 control-label">'
                    + '</label>'
                    + '<div class="col-sm-4">'
                    + ' <div class="input-group date">'
                    + '<div class="input-group-btn">'
                    + '<button type="button" class="btn btn-success">'
                    + 'Min Placement'
                    + '</button>'
                    + '</div>'
                    + '<input type="text" class="form-control pull-right" name="min_placement['+range_id+']" value="">'
                    + ' </div>'
                    + ' </div>'
                    + ' <div class="col-sm-4 ">'
                    + '<div class="input-group date ">'
                    + ' <div class="input-group-btn">'
                    + '<button type="button" class="btn btn-danger">'
                    + 'Max Placement'
                    + '</button>'
                    + '</div>'
                    + '<input type="text" class="form-control pull-right" name="max_placement['+range_id+']" value="">'
                    + '</div>'
                    + '</div>'
                    + ' <div class="col-sm-2">'
                    + ' <button type="button" class="btn btn-info pull-left mr-15 add-placement-range-button" data-range-id= '+range_id
                    + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>'
                    + '<button type="button" class="btn btn-danger -pull-right display-none  remove-placement-range-button"   data-range-id= '+range_id
                    + ' onClick="removePlacementRange(this);"><i class="fa fa-minus"> </i> </button>'
                    + ' </div> </div>'


                    + '<div class="form-group" id="formula_detail_1">'
                    + '<label for="title" class="col-sm-2 control-label">'
                    + '</label>'
                    + '<div class="col-sm-6 ">'
                    + ' <div class="form-row">'
                    + ' <div class="col-md-6 mb-3">'
                    + ' <label for="">Tenure</label>'
                    + '<input type="text" class="form-control" id="" name="tenure['+range_id+'][0]" placeholder="" >'
                    + '</div>'
                    + '<div class="col-md-6 mb-3">'
                    + '<label for="">Bonus Interest</label>'
                    + '<input type="text" class="form-control" id="" name="bonus_interest['+range_id+'][0]" placeholder="" >'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '  <div class="col-sm-1 col-sm-offset-1 ">'
                    + ' <button type="button" class="btn btn-info pull-left mr-15  " id="add-formula-detail-'+range_id+'0" data-formula-detail-id="0" '
                    + ' data-range-id='+range_id
                    + ' onClick="addMoreFormulaDetail(this); " > '
                    + ' <i class="fa fa-plus"> </i> </button>'
                    + '<button type="button" class="btn btn-danger -pull-right   display-none" id="remove-formula-detail-'+range_id+'0" data-formula-detail-id ="0" '
                    + ' data-range-id ='+range_id
                    + ' onClick="removeFormulaDetail(this);" >'
                    + '<i class="fa fa-minus"> </i>'
                    + ' </button>'
                    + ' </div>'
                    + ' <div class="col-sm-2">&emsp;</div></div>'
                    + ' <div id="new-formula-detail-'+range_id+'"></div>'
                    + ' </div>'

            );
            $('#new-placement-range').append($newTextArea);
        }
        function removePlacementRange(id) {
            var range_id = $(id).data('range-id');
            $("#placement_range_" + range_id).remove();
        }

        function addMoreFormulaDetail(id) {

            var formula_detail_id = $(id).data('formula-detail-id');
            var range_id = $(id).data('range-id');
            $(id).addClass('display-none');

            $("#remove-formula-detail-"+range_id+formula_detail_id).removeClass('display-none');
            formula_detail_id++;
            //alert(range_id+' '+formula_detail_id);
            $('#add-formula-detail-'+range_id+formula_detail_id).remove();
            // Layout options
            var $newTextArea = $('<div />', {
                'id': 'formula_detail_' + formula_detail_id,
                'class': 'form-group'
            });


            $newTextArea.append(
                    '<label for="title" class="col-sm-2 control-label">'
                    + '</label>'
                    + '<div class="col-sm-6 ">'
                    + ' <div class="form-row">'
                    + ' <div class="col-md-6 mb-3">'
                    + ' <label for="">Tenure</label>'
                    + '<input type="text" class="form-control" id="" name="tenure[' + range_id + '][' + formula_detail_id + ']" placeholder="" >'
                    + '</div>'
                    + '<div class="col-md-6 mb-3">'
                    + '<label for="">Bonus Interest</label>'
                    + '<input type="text" class="form-control" id="" name="bonus_interest[' + range_id + '][' + formula_detail_id + ']" placeholder="" >'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '  <div class="col-sm-1 col-sm-offset-1 ">'
                    + ' <button type="button" class="btn btn-info pull-left mr-15  " data-formula-detail-id="'+formula_detail_id
                    + '" data-range-id="'+range_id+'" id="add-formula-detail-'+range_id+formula_detail_id+'" onClick="addMoreFormulaDetail(this); " > '
                    + ' <i class="fa fa-plus"> </i> </button>'
                    + '<button type="button" class="btn btn-danger -pull-right  display-none" data-formula-detail-id ="'+formula_detail_id
                    + '" data-range-id ="'+range_id+' " id="remove-formula-detail-'+range_id+formula_detail_id+ '" onClick="removeFormulaDetail(this);" >'
                    + '<i class="fa fa-minus"> </i>'
                    + ' </button>'
                    + ' </div>'
                    + ' <div class="col-sm-2">&emsp;</div>'
            );
            $('#new-formula-detail-'+range_id).append($newTextArea);
        }
        function removeFormulaDetail(id) {
            var formula_detail_id = $(id).data('formula-detail-id');
            $("#formula_detail_" + formula_detail_id).remove();
        }

        $(document).ready(function () {


            if ($("#link").val().length != 0) {
                $("#target-div").show();
            } else {
                $("#target-div").hide();

            }

            $('#link').trigger("change");
            // #page 7 is id of category page.


        });
        $("input[id*=link]").on("change", function () {
            if (this.value.length != 0) {
                var input_value = this.value;
                //Set input value to lower case so HTTP or HtTp become http
                input_value = input_value.toLowerCase();

                //Check if string starts with http:// or https://
                var regExr = /^(http:|https:)\/\/.*$/m;

                //Test expression
                var result = regExr.test(input_value);

                //If http:// or https:// is not present add http:// before user input
                if (!result) {
                    var new_value = "http://" + input_value;
                    this.value = new_value;
                }
                $("#target-div").show();
                //trigger to change select2 plug in value
                $('#target').val('null').trigger('change');
            } else {
                $("#target-div").hide();
                //trigger to change select2 plug in value
                $('#target').val('null').trigger('change');
            }
        });

    </script>