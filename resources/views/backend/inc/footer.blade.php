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
        font_formats: 'Roboto,sans-serif;',
        branding: false,
        plugins: [
            "advlist autolink lists link  charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime  nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern image  "
        ],
        toolbar: "insert | insertfile  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | forecolor backcolor | image | code",
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 36pt 48pt 72pt",
        menubar: "tools",
        relative_urls: false,
        table_default_attributes: {
            border: '1'
        },
        table_responsive_width: true,
        content_css: [
            '/dollar_dollar/public/frontend/css/plugin.css',
            '/dollar_dollar/public/frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css',
            '/dollar_dollar/public/frontend/plugins/jquery-ui/jquery-ui.min.css',
            '/dollar_dollar/public/frontend/css/main.css',
            '/dollar_dollar/public/frontend/css/custom.css'
        ],
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
    $(document).ready(function() {
        $(".only_numeric").numeric();
    });

    function check_url(link) {
        //alert(link);
        //Get input value

    }

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
<script src="{{ asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js' ) }}"></script>
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

<script>
    $(document).ready(function () {
        //Initialize Select2 Elements
        $('.select2').select2();


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
                    'order': [[8, 'desc'], [9, 'desc'], [7, 'desc']],
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
        $('#menus').DataTable(
                {
                    "pageLength": 10,
                    'ordering': true,
                    'order': [[1, 'asc']],
                    "columnDefs": []
                });

    });

</script>
<script type="text/javascript">

    function addMoreTextArea() {
        // Layout options
        var $newTextArea = $('<div />', {
            'id': '',
            'class': 'form-group'
        })
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
        )
        $('#inner').append($newTextArea);
        tinymce.init(editor_config);
    }

    $(document).ready(function () {


        if ($("#link").val().length != 0) {
            $("#target-div").show();
        } else {
            $("#target-div").hide();

        }

        $('#link').trigger("change");
        // #page 7 is id of category page.
        $('#link').change(function () {
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

    });

</script>