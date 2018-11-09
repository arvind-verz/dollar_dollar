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
            '/frontend/css/plugin.css',
            '/frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css',
            '/frontend/plugins/jquery-ui/jquery-ui.min.css',
            '/frontend/css/main.css',
            '/frontend/css/custom.css'
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

    scriptLoader.add('/frontend/js/jquery.min.js');
    scriptLoader.add('/frontend/js/plugin.js');
    scriptLoader.add('/frontend/plugins/jquery-ui/jquery-ui.min.js');
    scriptLoader.add('/frontend/js/main.js');

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
        $(".only_numeric").on("keydown", function (event) {
            if (event.keyCode == 189) {
                event.preventDefault();
            }
        })
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

    $(function () {
        if ($('.date_range').val() == '') {
            $('.date_range').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY/MM/DD'
                }
            }, function (start, end, label) {

                $('.date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            });
        }
        else {
            $('.date_range').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
        }
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
<script src="{{ asset('backend/bower_components/iconpicker/fontawesome-iconpicker.js') }}"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
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
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{ asset('backend/dist/js/jquery.bootstrap.wizard.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var bulk_arr = [];
        var bulk_arr1 = [];
        $("select[name='select_type']").on("change", function () {
            var select_type = $(this).val();
            var type = $("input[name='bulk_update_type']").val();
            if (select_type != '') {
                var r = confirm("Are you sure?");
                if (r == true) {
                    $.post("{{ route('user-bulk-remove') }}", {
                        id: bulk_arr1,
                        type: type,
                        select_type: select_type
                    }, function (data) {
                        if (data.trim() == 'success') {
                            window.location.reload();
                        }
                    });
                }
            }
        });
        $("input[name='bluk_remove[]']").on("click", function () {
            var value = $(this).val();

            $(this).each(function () {
                if ($(this).is(":checked")) {
                    bulk_arr.push(value);
                    bulk_arr1.push(value);
                    $("a.bulk_remove, div.bulk_status").removeClass("hide");
                }
                else {
                    bulk_arr.pop(value);
                    bulk_arr1.pop(value);
                }
            });

            if (bulk_arr.length < 1) {
                $("a.bulk_remove, div.bulk_status").addClass("hide");
                $("a.bluk_remove, div.bulk_status").find(".badge").text('');
            }
            else {
                $("a.bulk_remove, div.bulk_status").removeClass("hide");
                $("a.bulk_remove").find(".badge").text(bulk_arr.length);
                $("div.bulk_status").find(".badge").text(bulk_arr1.length);
            }
            //alert(bulk_arr);
        });

        $("input[name='all_bulk_remove']").on("click", function () {
            bulk_arr = [];

            if ($(this).is(":checked")) {
                $("input[name='bluk_remove[]']").each(function () {
                    var value = $(this).val();
                    $(this).prop("checked", true);
                    bulk_arr.push(value);
                    bulk_arr1.push(value);
                    $("a.bulk_remove, div.bulk_status").removeClass("hide");
                });
                $("a.bulk_remove").find(".badge").text(bulk_arr.length);
                $("div.bulk_status").find(".badge").text(bulk_arr1.length);
            }
            else {
                $("input[name='bluk_remove[]").prop("checked", false);
                $("input[name='bluk_remove[]']").each(function () {
                    var value = $(this).val();
                    $(this).prop("checked", false);
                    bulk_arr.pop(value);
                    bulk_arr1.pop(value);
                    $("a.bulk_remove, div.bulk_status").addClass("hide");
                });
                $("a.bulk_remove, div.bulk_status").find(".badge").text('');
            }
        });

        $("a.bulk_remove").on("click", function () {
            var r = confirm("Are you sure?");
            var type = $("input[name='bulk_remove_type']").val();
            if (r == true) {
                $.post("{{ route('user-bulk-remove') }}", {id: bulk_arr, type: type}, function (data) {
                    if (data.trim() == 'success') {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        $('#reports').DataTable();

        $('#activities').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                'order': [[6, 'desc']],
                "columnDefs": []
            });
        $('#users').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                "aoColumnDefs": [{
                    "aTargets": [0, 1],
                    "bSortable": false,

                }]
            });
        $('#admins').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                'order': [[5, 'desc'], [4, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSortable": false,

                }]
            });
        $('#banners').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                'order': [[0, 'asc'], [3, 'asc']],
                "columnDefs": []
            });
        $('#brands').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                'order': [[3, 'asc']],
                "columnDefs": []
            });

        $('#pages').DataTable(
            {
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [
                    [4, 'desc'],
                    [3, 'desc']
                ],
                "aoColumnDefs": [{
                    "aTargets": [5],
                    "bSortable": false,

                }],

            });
        $('#customer-report').DataTable(
            {
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Customer management',
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Profile ' + today;
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Profile ' + today;
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [[0, 'asc']],
                "aoColumnDefs": [{
                    "aTargets": [],
                    "bSortable": false,

                },
                    { width: 300, targets: 0 },
                    { width: 300, targets: 1 },
                    { width: 100, targets: 2 },
                    { width: 100, targets: 3 },
                    { width: 150, targets: 4 },
                    { width: 100, targets: 5 },
                    { width: 100, targets: 6 },
                    { width: 100, targets: 7}
                ],

            });
        $('#contact-table').DataTable(
            {
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        title: 'Contact enquiry',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        },
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Contact ' + today;
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Contact ' + today;
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [[6, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [0, 7],
                    "bSortable": false,

                },
                    { width: 50, targets: 0 },
                    { width: 100, targets: 1 },
                    { width: 100, targets: 2 },
                    { width: 100, targets: 3 },
                    { width: 100, targets: 4 },
                    { width: 400, targets: 5}
                ]

            });


        $('#life').DataTable(
            {
               dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        title: 'Life enquiry',
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Life ' + today;
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Life ' + today;
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [[10, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [0, 11],
                    "bSortable": false,

                }],

            });

        $('#investment').DataTable(
            {
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        },
                        title: 'Investment enquiry',
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Invest ' + today;
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Invest ' + today;
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [[12, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [0, 13],
                    "bSortable": false,

                }],

            });

        $('#health').DataTable(
            {
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        title: 'Health enquiry',
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }

                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Health ' + today;
                        }

                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        filename: function () {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();
                            var yy = yyyy.toString().substring(2);
                            if (dd < 10) {
                                dd = '0' + dd
                            }
                            if (mm < 10) {
                                mm = '0' + mm
                            }
                            today = yy + '' + mm + '' + dd;
                            return 'Health ' + today;
                        }
                    }
                ],
                "pageLength": 100,
                'ordering': true,
                'order': [[9, 'desc']],
                "aoColumnDefs": [{
                    "aTargets": [0, 10],
                    "bSortable": false,

                }],

            });
        $('#products').DataTable(
            {
                "pageLength": 100,
                'ordering': true,
                'order': [[8, 'desc'], [7, 'desc']],
                "columnDefs": []
            });
        $('#menus').DataTable(
            {
                "pageLength": 100,
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
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        filename: function () {
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
                            today = yyyy + '' + mm + '' + dd;
                            return 'Customers-Report ' + today;
                        }
                    }
                ],
            });

        $('#rootwizard').bootstrapWizard({

            'tabClass': 'nav nav-pills',
            'onPrevious': function (tab, navigation, index) {
                //alert(index);
                $("#error-div").addClass('display-none');
                var product_id = $.trim($("#product-id").val());
                var errorSection = document.getElementById("js-errors");
                var minPlacementAmount = $.trim($('#minimum-placement-amount').val());
                errorSection.innerHTML = '';
                var formula = $.trim($('#formula').val());
                var errors = new Array();
                var i = 0;

                var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
                var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
                var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
                var SDP1 = [
                    '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
                    '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
                    '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
                ];
                var utilFormula = [
                    '<?php echo SAVING_DEPOSIT_F1; ?>',
                    '<?php echo PRIVILEGE_DEPOSIT_F1; ?>',
                    '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>'
                ];

                var SDP6 = [
                    '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
                ];
                var AIOA = ['<?php echo ALL_IN_ONE_ACCOUNT_F1; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F2; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F3; ?>' , '<?php echo ALL_IN_ONE_ACCOUNT_F4; ?>' , '<?php echo ALL_IN_ONE_ACCOUNT_F5; ?>'];

                if (index == 1) { return true;
                    var name = $.trim($('#name').val());
                    var bank = $.trim($('#bank').val());
                    var ongoingStatus = $.trim($('#ongoing-status-1').data('status'));
                    var productType = $.trim($('#product-type').val());
                    var currency = $.trim($('#currency').val());
                    var maxInterestRate = $.trim($('#maximum-interest-rate').val());
                    var promotionPeriod = $.trim($('#promotion-period').val());
                    var untilEndDate = $.trim($('#until-end-date').val());
                    var startDate = $.trim($('#promotion_start_date').val());
                    var endDate = $.trim($('#promotion_end_date').val());
                    // Make sure we entered the name
                    if (!name) {
                        errors[i] = 'The name is required.';
                        i++;
                    } else {
                        $.ajax({
                            method: "POST",
                            url: "{{url('/admin/check-product')}}",
                            data: {
                                name: name,
                                product_id: product_id,
                                bank: bank,
                                productType: productType,
                                formula: formula
                            },
                            cache: false,
                            async: false,
                            success: function (data) {
                                console.log(data);
                                if (data == 1) {
                                    errors[i] = 'This detail has already been taken';
                                    i++;
                                }
                            }
                        });
                    }
                    if (!bank) {
                        errors[i] = 'The bank is required.';
                        i++;
                    }
                    if (!productType) {
                        errors[i] = 'The product type is required.';
                        i++;
                    }
                    if (!(!startDate && !endDate) && (!startDate || !endDate)) {
                        errors[i] = 'The date is required.';
                        i++;
                    }
                    if(!minPlacementAmount && (jQuery.inArray(formula, AIOA) !== -1)){
                        errors[i] = 'The maximum placement is required.';
                        i++;
                    }
                    else if (!minPlacementAmount) {
                        errors[i] = 'The minimum placement is required.';
                        i++;
                    }
                    if (!maxInterestRate) {
                        errors[i] = 'The maximum interest rate is required.';
                        i++;
                    }
                    if ((!promotionPeriod) &&(jQuery.inArray(formula, AIOA) !== -1)) {
                        errors[i] = 'The criteria is required.';
                        i++;
                    }
                    else if ((!promotionPeriod) && (ongoingStatus == 'false') && (jQuery.inArray(formula, utilFormula) === -1)) {
                        errors[i] = 'The promotion period is required.';
                        i++;
                    }
                    if ((!untilEndDate) && (jQuery.inArray(formula, utilFormula) !== -1) && (ongoingStatus == 'false')) {
                        errors[i] = 'The until end date is required.';
                        i++;
                    }
                }
                if (index == 0) {
                    var productType = $.trim($('#product-type').val());
                    var currency = $.trim($('#currency').val());
                    if ((productType == '<?php echo FOREIGN_CURRENCY_DEPOSIT ;?>') && (currency.length == 0)) {
                        errors[i] = 'The currency type is required.';
                        i++;
                    }

                    if (jQuery.inArray(formula, FDP1) !== -1) {
                        var minPlacements = $('#fixDepositF1').find('input[name^="min_placement"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacements = $('#fixDepositF1').find('input[name^="max_placement"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var tenures = $('#fixDepositF1').find('input[name^="tenure[0]"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var interests = $('#fixDepositF1').find('input[name^="bonus_interest"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var tenureError = false;
                        var rangeError = false;

                        $.each(minPlacements, function (k, v) {
                            if (minPlacements[k] == '' || maxPlacements[k] == '') {
                                errors[i] = 'The placement range is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(tenures, function (k, v) {
                            if (tenures[k] == '') {
                                errors[i] = 'The tenure is required.';
                                i++;
                                tenureError = true;
                                return false;
                            }

                        });
                        $.each(interests, function (k, v) {
                            if (interests[k] == '') {
                                errors[i] = 'The bonus interest is required.';
                                i++;
                                return false;
                            }

                        });
                        /*if (tenureError == false) {
                         $.ajax({
                         method: "POST",
                         url: "
                         {{url('/admin/check-tenure')}}",
                         data: {tenures: tenures},
                         cache: false,
                         async: false,
                         success: function (data) {
                         if (data == 1) {
                         errors[i] = 'Please check tenure you input duplicate tenure';
                         i++;
                         }
                         }
                         });
                         }*/
                        /*if (rangeError == false) {
                         $.ajax({
                         method: "POST",
                         url: "
                         {{url('/admin/check-range')}}",
                         data: {max_placement: maxPlacements, min_placement: minPlacements},
                         cache: false,
                         async: false,
                         success: function (data) {
                         //
                         if (data == 1) {
                         errors[i] = 'Please check your placement range ';
                         i++;
                         }
                         if (data == 2) {
                         errors[i] = 'Max Placement must be greater than Min Placement';
                         i++;
                         }
                         }
                         });
                         }*/

                        $.each(minPlacements, function (k, v) {

                            if (Number(v) < Number(minPlacementAmount)) {
                                errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
                                i++;

                                return false;
                            }
                            if (Number(maxPlacements[k]) < Number(minPlacementAmount)) {
                                errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
                                i++;

                                return false;
                            }
                        });
                    }
                    if (jQuery.inArray(formula, SDP1) !== -1) {
                        var minPlacements = $('#savingDepositF1').find('input[name^="min_placement_sdp1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacements = $('#savingDepositF1').find('input[name^="max_placement_sdp1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterest = $('#savingDepositF1').find('input[name^="bonus_interest_sdp1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var boardInterest = $('#savingDepositF1').find('input[name^="board_rate_sdp1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var tenureError = false;
                        var rangeError = false;
                        $.each(minPlacements, function (k, v) {
                            if (minPlacements[k] == '' || maxPlacements[k] == '') {
                                errors[i] = 'The placement range is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(bonusInterest, function (k, v) {
                            if (bonusInterest[k] == '') {
                                errors[i] = 'The bonus interest is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(boardInterest, function (k, v) {
                            if (boardInterest[k] == '') {
                                errors[i] = 'The board interest is required.';
                                i++;

                                return false;
                            }

                        });
                        if (formula == '<?php echo SAVING_DEPOSIT_F2; ?>') {
                            var tenure = $('#savingDepositF1').find('input[name="tenure_sdp1"]').map(function () {
                                return $.trim($(this).val());
                            }).get();
                            if (tenure == '') {
                                errors[i] = 'The tenure is required.';
                                i++;
                            }
                        }

                        if (rangeError == false) {
                            $.ajax({
                                method: "POST",
                                url: "{{url('/admin/check-range')}}",
                                data: {max_placement: maxPlacements, min_placement: minPlacements},
                                cache: false,
                                async: false,
                                success: function (data) {
                                    if (data == 1) {
                                        errors[i] = 'Please check your placement range ';
                                        i++;
                                    }
                                    if (data == 2) {
                                        errors[i] = 'Max Placement must be greater than Min Placement';
                                        i++;
                                    }
                                }
                            });
                        }

                        $.each(minPlacements, function (k, v) {

                            if (Number(v) < Number(minPlacementAmount)) {

                                errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
                                i++;

                                return false;
                            }
                            if (Number(maxPlacements[k]) < Number(minPlacementAmount)) {
                                errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
                                i++;

                                return false;
                            }
                        });
                    }
                    if (jQuery.inArray(formula, SDP6) !== -1) {
                        var maxPlacements = $('#savingDepositF4').find('input[name^="max_placement_sdp4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterest = $('#savingDepositF4').find('input[name^="bonus_interest_sdp4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var boardInterest = $('#savingDepositF4').find('input[name^="board_rate_sdp4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var rangeError = false;
                        $.each(maxPlacements, function (k, v) {
                            if (maxPlacements[k] == '') {
                                errors[i] = 'The placement is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(bonusInterest, function (k, v) {
                            if (bonusInterest[k] == '') {
                                errors[i] = 'The bonus interest is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(boardInterest, function (k, v) {
                            if (boardInterest[k] == '') {
                                errors[i] = 'The board interest is required.';
                                i++;

                                return false;
                            }

                        });


                    }
                    if (jQuery.inArray(formula, SDP3) !== -1) {
                        var minPlacement = $('#savingDepositF3').find('input[name="min_placement_sdp3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacement = $('#savingDepositF3').find('input[name="max_placement_sdp3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var averageInterestRate = $('#savingDepositF3').find('input[name="air_sdp3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var siborRate = $('#savingDepositF3').find('input[name="sibor_rate_sdp3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                            errors[i] = 'Please check your placement range. ';
                            i++;
                        }

                        if (averageInterestRate == '') {
                            errors[i] = 'The average interest rate is required.';
                            i++;
                        }
                        if (siborRate == '') {
                            errors[i] = 'The sibor rate is required.';
                            i++;

                        }
                        if (Number(minPlacement) < Number(minPlacementAmount) || Number(maxPlacement) < Number(minPlacementAmount)) {

                            errors[i] = 'All placement must be greater than or equal minimum placement amount.';
                            i++;

                        }


                    }
                    if (jQuery.inArray(formula, SDP5) !== -1) {
                        var minPlacement = $('#savingDepositF5').find('input[name="min_placement_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacement = $('#savingDepositF5').find('input[name="max_placement_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var baseInterest = $('#savingDepositF5').find('input[name="base_interest_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterest = $('#savingDepositF5').find('input[name="bonus_interest_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var placementMonth = $('#savingDepositF5').find('input[name="placement_month_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var displayMonth = $('#savingDepositF5').find('input[name="display_month_sdp5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();

                        if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                            errors[i] = 'Please check your placement range. ';
                            i++;
                        }

                        if (baseInterest == '') {
                            errors[i] = 'The base interest rate is required.';
                            i++;
                        }
                        if (bonusInterest == '') {
                            errors[i] = 'The bonus interest is required.';
                            i++;
                        }
                        if (placementMonth == '') {
                            errors[i] = 'The placement month is required.';
                            i++;
                        }
                        if (displayMonth == '') {
                            errors[i] = 'The display month is required.';
                            i++;
                        }
                        if (parseInt(displayMonth) > parseInt(placementMonth)) {
                            errors[i] = 'The display month interval is not greater than placement month.';
                            i++;
                        }
                        if (Number(minPlacement) < Number(minPlacementAmount) || Number(maxPlacement) < Number(minPlacementAmount)) {

                            errors[i] = 'All placement must be greater than or equal minimum placement amount.';
                            i++;

                        }

                    }

                    if (formula == 7) {
                        var allInOneAccountF1 = $('#allInOneAccountF1');
                        var minPlacement = allInOneAccountF1.find('input[name="min_placement_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacement = allInOneAccountF1.find('input[name="max_placement_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryMinAmount = allInOneAccountF1.find('input[name="minimum_salary_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_salary_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroMinAmount = allInOneAccountF1.find('input[name="minimum_giro_payment_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_giro_payment_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendMinAmount = allInOneAccountF1.find('input[name="minimum_spend_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_spend_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var PrivilegeMinAmount = allInOneAccountF1.find('input[name="minimum_privilege_pa_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var PrivilegeBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_privilege_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        /*var LoanMinAmount = allInOneAccountF1.find('input[name="minimum_loan_pa_aioa1"]').map(function () {
                         return $.trim($(this).val());
                         }).get();
                         var LoanBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_loan_aioa1"]').map(function () {
                         return $.trim($(this).val());
                         }).get();*/
                        var BonusAmount = allInOneAccountF1.find('input[name="minimum_bonus_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var BonusInterest = allInOneAccountF1.find('input[name="bonus_interest_bonus_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var FirstCapAmount = allInOneAccountF1.find('input[name="first_cap_amount_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RemainingBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_remaining_amount_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();

                        if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {

                            errors[i] = 'All placement must be less than or equal maximum placement amount.';
                            i++;

                        }
                        if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                            errors[i] = 'Please check your placement range. ';
                            i++;
                        }

                        if (SalaryMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Salary) is required.';
                            i++;
                        }
                        if (SalaryBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Salary) is required.';
                            i++;
                        }
                        if (GiroMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Giro) is required.';
                            i++;
                        }
                        if (GiroBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Giro) is required.';
                            i++;
                        }
                        if (SpendMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Spend) is required.';
                            i++;
                        }
                        if (SpendBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Spend) is required.';
                            i++;
                        }
                        if (PrivilegeMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Privilege) is required.';
                            i++;
                        }
                        if (PrivilegeBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Privilege) is required.';
                            i++;
                        }
                        if (BonusAmount == '') {
                            errors[i] = 'The  first cap amount is required.';
                            i++;
                        }
                        if (BonusInterest == '') {
                            errors[i] = 'The  bonus interest (First cap) is required.';
                            i++;
                        }
                        if (FirstCapAmount == '') {
                            errors[i] = 'The  first cap amount is required.';
                            i++;
                        }
                        if (RemainingBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Remaining) is required.';
                            i++;
                        }
                        if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
                            errors[i] = 'The  first cap amount  is not greater than minimum placement.';
                            i++;
                        }
                    }
                    if (formula == 8) {
                        var allInOneAccountF2 = $('#allInOneAccountF2');
                        var SpendMinAmount = allInOneAccountF2.find('input[name="minimum_spend_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroMinAmount = allInOneAccountF2.find('input[name="minimum_giro_payment_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryMinAmount = allInOneAccountF2.find('input[name="minimum_salary_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacements = allInOneAccountF2.find('input[name^="max_placement_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterestA = allInOneAccountF2.find('input[name^="bonus_interest_criteria_a_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterestB = allInOneAccountF2.find('input[name^="bonus_interest_criteria_b_aioa2"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var rangeError = false;

                        if (SpendMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Spend) is required.';
                            i++;
                        }
                        if (GiroMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Giro) is required.';
                            i++;
                        }
                        if (SalaryMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Salary) is required.';
                            i++;
                        }

                        $.each(maxPlacements, function (k, v) {
                            if (maxPlacements[k] == '') {
                                errors[i] = 'The placement is required.';
                                i++;
                                rangeError = true;
                                return false;
                            }

                        });
                        $.each(bonusInterestA, function (k, v) {
                            if (bonusInterestA[k] == '') {
                                errors[i] = 'The bonus interest (A) is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(bonusInterestB, function (k, v) {
                            if (bonusInterestB[k] == '') {
                                errors[i] = 'The bonus interest (B) is required.';
                                i++;

                                return false;
                            }

                        });
                        var minPlacements = [];
                        var min = 0;
                        $.each(maxPlacements, function (k, v) {
                            minPlacements[k] = Number(min);
                            min = Number(v) + Number(1);
                        });

                        /*if (rangeError == false) {
                         $.ajax({
                         method: "POST",
                         url: "
                         {{url('/admin/check-range')}}",
                         data: {max_placement: maxPlacements, min_placement: minPlacements},
                         cache: false,
                         async: false,
                         success: function (data) {

                         if (data == 1) {
                         errors[i] = 'Please check your placement range ';
                         i++;
                         }
                         if (data == 2) {
                         errors[i] = 'Max Placement must be greater than Min Placement';
                         i++;
                         }
                         }
                         });
                         }

                         $.each(minPlacements, function (k, v) {

                         if (Number(maxPlacements[k]) < Number(minPlacementAmount)) {
                         errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
                         i++;

                         return false;
                         }
                         });*/

                    }
                    if (formula == 9) {
                        var allInOneAccountF3 = $('#allInOneAccountF3');
                        var minPlacement = allInOneAccountF3.find('input[name="min_placement_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacement = allInOneAccountF3.find('input[name="max_placement_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryMinAmount = allInOneAccountF3.find('input[name="minimum_salary_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroMinAmount = allInOneAccountF3.find('input[name="minimum_giro_payment_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendMinAmount = allInOneAccountF3.find('input[name="minimum_spend_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var HirePurchaseMinAmount = allInOneAccountF3.find('input[name="minimum_hire_purchase_loan_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RenovationMinAmount = allInOneAccountF3.find('input[name="minimum_renovation_loan_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var HomeMinAmount = allInOneAccountF3.find('input[name="minimum_home_loan_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var EducationMinAmount = allInOneAccountF3.find('input[name="minimum_education_loan_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var InsuranceMinAmount = allInOneAccountF3.find('input[name="minimum_insurance_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var UnitTrustMinAmount = allInOneAccountF3.find('input[name="minimum_unit_trust_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RequirementCriteria1 = allInOneAccountF3.find('input[name="requirement_criteria1_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RequirementCriteria2 = allInOneAccountF3.find('input[name="requirement_criteria2_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RequirementCriteria3 = allInOneAccountF3.find('input[name="requirement_criteria3_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var BonusInterestCriteria1 = allInOneAccountF3.find('input[name="bonus_interest_criteria1_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var BonusInterestCriteria2 = allInOneAccountF3.find('input[name="bonus_interest_criteria2_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var BonusInterestCriteria3 = allInOneAccountF3.find('input[name="bonus_interest_criteria3_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var FirstCapAmount = allInOneAccountF3.find('input[name="first_cap_amount_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RemainingBonusInterest = allInOneAccountF3.find('input[name="bonus_interest_remaining_amount_aioa3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();


                        if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {

                            errors[i] = 'All placement must be less than or equal maximum placement amount.';
                            i++;

                        }
                        if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                            errors[i] = 'Please check your placement range. ';
                            i++;
                        }
                        if (SalaryMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Salary) is required.';
                            i++;
                        }
                        if (GiroMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Giro) is required.';
                            i++;
                        }
                        if (SpendMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Spend) is required.';
                            i++;
                        }
                        if (HirePurchaseMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Hire Purchase Loan) is required.';
                            i++;
                        }
                        if (RenovationMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Renovation Loan) is required.';
                            i++;
                        }
                        if (HomeMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Home Loan) is required.';
                            i++;
                        }
                        if (EducationMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Education Loan) is required.';
                            i++;
                        }
                        if (InsuranceMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Insurance Loan) is required.';
                            i++;
                        }
                        if (UnitTrustMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Unit Trust Loan) is required.';
                            i++;
                        }
                        if (RequirementCriteria1 == '') {
                            errors[i] = 'The number of criteria (Criteria 1) is required.';
                            i++;
                        }
                        if (RequirementCriteria2 == '') {
                            errors[i] = 'The number of criteria (Criteria 2) is required.';
                            i++;
                        }
                        if (RequirementCriteria3 == '') {
                            errors[i] = 'The number of criteria (Criteria 3) is required.';
                            i++;
                        }
                        if (BonusInterestCriteria1 == '') {
                            errors[i] = 'The  bonus interest (Criteria 1) is required.';
                            i++;
                        }
                        if (BonusInterestCriteria2 == '') {
                            errors[i] = 'The  bonus interest (Criteria 1) is required.';
                            i++;
                        }
                        if (BonusInterestCriteria3 == '') {
                            errors[i] = 'The bonus interest (Criteria 1) is required.';
                            i++;
                        }
                        if (FirstCapAmount == '') {
                            errors[i] = 'The  first cap amount is required.';
                            i++;
                        }
                        if (RemainingBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Remaining) is required.';
                            i++;
                        }
                        if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
                            errors[i] = 'The  first cap amount  is not greater than minimum placement.';
                            i++;
                        }
                    }
                    if (formula == 10) {
                        var allInOneAccountF4 = $('#allInOneAccountF4');
                        var SalaryMinAmount = allInOneAccountF4.find('input[name="minimum_salary_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendMinAmount = allInOneAccountF4.find('input[name="minimum_spend_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var HomeMinAmount = allInOneAccountF4.find('input[name="minimum_home_loan_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var InsuranceMinAmount = allInOneAccountF4.find('input[name="minimum_insurance_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var InvestmentMinAmount = allInOneAccountF4.find('input[name="minimum_investment_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var boardRate = allInOneAccountF4.find('input[name="board_rate_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var firstCapAmount = allInOneAccountF4.find('input[name="first_cap_amount_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var minPlacements = allInOneAccountF4.find('input[name^="min_placement_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacements = allInOneAccountF4.find('input[name^="max_placement_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterestA = allInOneAccountF4.find('input[name^="bonus_interest_criteria_a_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var bonusInterestB = allInOneAccountF4.find('input[name^="bonus_interest_criteria_b_aioa4"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var rangeError = false;

                        if (SpendMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Spend) is required.';
                            i++;
                        }
                        if (GiroMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Giro) is required.';
                            i++;
                        }
                        if (SalaryMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Salary) is required.';
                            i++;
                        }
                        if (HomeMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Home Loan) is required.';
                            i++;
                        }
                        if (InsuranceMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Insurance) is required.';
                            i++;
                        }
                        if (InvestmentMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Investment) is required.';
                            i++;
                        }
                        if (boardRate == '') {
                            errors[i] = 'The board rate is required.';
                            i++;
                        }
                        if (firstCapAmount == '') {
                            errors[i] = 'The first cap amount is required.';
                            i++;
                        }
                        $.each(minPlacements, function (k, v) {
                            if (minPlacements[k] == '' || maxPlacements[k] == '') {
                                errors[i] = 'The placement range is required.';
                                i++;
                                rangeError = true;
                                return false;
                            }

                        });
                        $.each(bonusInterestA, function (k, v) {
                            if (bonusInterestA[k] == '') {
                                errors[i] = 'The bonus interest (A) is required.';
                                i++;

                                return false;
                            }

                        });
                        $.each(bonusInterestB, function (k, v) {
                            if (bonusInterestB[k] == '') {
                                errors[i] = 'The bonus interest (B) is required.';
                                i++;

                                return false;
                            }

                        });


                        if (rangeError == false) {
                            $.ajax({
                                method: "POST",
                                url: "{{url('/admin/check-range')}}",
                                data: {max_placement: maxPlacements, min_placement: minPlacements},
                                cache: false,
                                async: false,
                                success: function (data) {

                                    if (data == 1) {
                                        errors[i] = 'Please check your placement range ';
                                        i++;
                                    }
                                    if (data == 2) {
                                        errors[i] = 'Max Placement must be greater than Min Placement';
                                        i++;
                                    }
                                }
                            });
                        }

                        $.each(minPlacements, function (k, v) {

                            if (Number(v) > Number(minPlacementAmount)) {

                                errors[i] = 'All placement must be less than or equal to maximum placement amount.';
                                i++;

                                return false;
                            }
                            if (Number(maxPlacements[k]) > Number(minPlacementAmount)) {
                                errors[i] = 'All placement must be less than or equal to maximum placement amount.';
                                i++;

                                return false;
                            }
                        });
                    }
                    if (formula == 23) {
                        var allInOneAccountF5 = $('#allInOneAccountF5');
                        var minPlacement = allInOneAccountF5.find('input[name="min_placement_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var maxPlacement = allInOneAccountF5.find('input[name="max_placement_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendMinAmount1 = allInOneAccountF5.find('input[name="minimum_spend_1_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendBonusInterest1 = allInOneAccountF5.find('input[name="bonus_interest_spend_1_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendMinAmount2 = allInOneAccountF5.find('input[name="minimum_spend_2_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SpendBonusInterest2 = allInOneAccountF5.find('input[name="bonus_interest_spend_2_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryMinAmount = allInOneAccountF5.find('input[name="minimum_salary_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var SalaryBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_salary_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroMinAmount = allInOneAccountF5.find('input[name="minimum_giro_payment_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var GiroBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_giro_payment_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var PrivilegeMinAmount = allInOneAccountF5.find('input[name="minimum_privilege_pa_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var PrivilegeBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_privilege_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var LoanMinAmount = allInOneAccountF5.find('input[name="minimum_loan_pa_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var LoanBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_loan_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var FirstCapAmount = allInOneAccountF5.find('input[name="first_cap_amount_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var RemainingBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_remaining_amount_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var interestName1 = allInOneAccountF5.find('input[name="other_interest_name_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var minimumAmount1 = allInOneAccountF5.find('input[name="other_minimum_amount_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var interest1 = allInOneAccountF5.find('input[name="other_interest_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var status1 = allInOneAccountF5.find('input[name="status_other_aioa5"]').map(function () {
                            return $.trim($(this).val());
                        }).get();


                        if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {

                            errors[i] = 'All placement must be less than or equal maximum placement amount.';
                            i++;

                        }
                        if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                            errors[i] = 'Please check your placement range. ';
                            i++;
                        }
                        if (SpendMinAmount1 != '') {
                            if (SpendBonusInterest1 == '') {
                                errors[i] = 'The  bonus interest (Spend 1) is required.';
                                i++;
                            }
                        }
                        if (SpendMinAmount2 != '') {
                            if (SpendBonusInterest2 == '') {
                                errors[i] = 'The  bonus interest (Spend 2) is required.';
                                i++;
                            }
                        }
                        if(SpendMinAmount1 != '' && SpendMinAmount2 != '')
                        {
                            if (SpendMinAmount1 == SpendMinAmount2) {
                                errors[i] = 'You cannot input same amount for spend 1 and spend 2.';
                                i++;
                            }
                            if (SpendMinAmount1 > SpendMinAmount2) {
                                errors[i] = 'spend 2 amount must be grater than spend 1.';
                                i++;
                            }
                        }
                        if (SalaryMinAmount != '') {
                            if (SalaryBonusInterest == '') {
                                errors[i] = 'The  bonus interest (Salary) is required.';
                                i++;
                            }
                        }

                        if (GiroMinAmount != '') {
                            if (GiroBonusInterest == '') {
                                errors[i] = 'The  bonus interest (Giro) is required.';
                                i++;
                            }
                        }

                        if (PrivilegeMinAmount != '') {
                            if (PrivilegeBonusInterest == '') {
                                errors[i] = 'The  bonus interest (Privilege) is required.';
                                i++;
                            }
                        }

                        if (LoanMinAmount != '') {
                            if (LoanBonusInterest == '') {
                                errors[i] = 'The  bonus interest (Loan) is required.';
                                i++;
                            }
                        }
                        if (status1 == '1' && minimumAmount1 != '') {
                            if (interestName1 == '') {
                                errors[i] = 'The interest name is required.';
                                i++;
                            }
                            if (interest1 == '') {
                                errors[i] = 'The other interest is required.';
                                i++;
                            }

                        }
                        if (FirstCapAmount == '') {
                            errors[i] = 'The  first cap amount is required.';
                            i++;
                        }
                        if (RemainingBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Remaining) is required.';
                            i++;
                        }


                        if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
                            errors[i] = 'The  first cap amount  is not greater than minimum placement.';
                            i++;
                        }


                    }
                }
                if (errors.length) {
                    $("#error-div").removeClass('display-none');
                    $.each(errors, function (k, v) {
                        errorSection.innerHTML = errorSection.innerHTML + '<p>' + v + '</p>';
                    });
                    return false;
                }
            }
        });

    });
    $(".alert-hide").on("click", function () {
        $("#error-div").addClass('display-none');
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
        var formula = $("#formula").val();
        var range_id = $(id).data('range-id');
        range_id++;
        var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
        var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
        var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
        var SDP1 = [
            '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
            '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
            '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
        ];
        var SDP6 = [
            '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
        ];


        if (jQuery.inArray(formula, FDP1) !== -1) {

            var data = $('#fixDepositF1').find('input[name^="tenure[0]"]').serializeArray();
            var productType = $("#product-type").val();

            /*var legends = new Array();
             var data = $('#fixDepositF1').find('select[name^="legend[0]"]').serializeArray();
             $.each($('select[name^="legend"]'), function() {
             legends.push($(this).val());
             });*/
            var formula_detail_id = data.length - 1;
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula, product_type: productType}
            }).done(function (data) {
                console.log(data);
                $('#new-placement-range').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 add-placement-range-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-placement-range-button').html(addMoreRangeButton);
                var addMoreFormulaDetailButton = ' <button type="button" class="btn btn-info pull-left mr-15  " data-formula-detail-id="' + formula_detail_id + '" data-range-id="' + range_id + '"  id="add-formula-detail-' + range_id + formula_detail_id + '" onClick="addMoreFormulaDetail(this); " > ' + ' <i class="fa fa-plus"> </i> </button>';
                $('#add-formula-detail-button').html(addMoreFormulaDetailButton);
            });
        }

        if (jQuery.inArray(formula, SDP1) !== -1) {
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula}
            }).done(function (data) {
                $('#saving-placement-range-f1').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 saving-placement-range-f1-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-saving-placement-range-f1-button').html(addMoreRangeButton);
            });
        }

        if (jQuery.inArray(formula, SDP6) !== -1) {
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula}
            }).done(function (data) {
                $('#saving-placement-range-f4').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 saving-placement-range-f4-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-saving-placement-range-f4-button').html(addMoreRangeButton);
            });
        }
        if (formula == 8) {
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula}
            }).done(function (data) {
                $('#aioa-placement-range-f2').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 add-aioa-placement-range-f2-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-aioa-placement-range-f2-button').html(addMoreRangeButton);
            });
        }
        if (formula == 10) {
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula}
            }).done(function (data) {

                $('#aioa-placement-range-f4').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 add-aioa-placement-range-f4-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-aioa-placement-range-f4-button').html(addMoreRangeButton);
            });
        }
    }

    function addCounter() {
        var formula = $("#formula").val();

        var counterValue = $("#promotion-period").val();

        var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
        var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
        var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
        var SDP1 = [
            '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
            '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
            '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
        ];
        var SDP6 = [
            '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
        ];
        if (jQuery.inArray(formula, SDP3) !== -1) {
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-counter')}}",
                data: {counter_value: counterValue}
            }).done(function (data) {
                $('#saving-placement-range-f3-counter').append(data);
            });
        }
    }

    function removePlacementRange(id) {
        var formula = $("#formula").val();
        var range_id = $(id).data('range-id');
        var SDP1 = [
            '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
            '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
            '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
        ];
        var SDP6 = [
            '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
        ];

        if (jQuery.inArray(formula, SDP6) !== -1) {
            $("#saving_placement_range_f4_" + range_id).remove();
        }
        if (jQuery.inArray(formula, SDP1) !== -1) {
            $("#saving_placement_range_f1_" + range_id).remove();
        }
        if (formula == 8) {
            $("#aioa_placement_range_f2_" + range_id).remove();
        }
        if (formula == 10) {
            $("#aioa_placement_range_f4_" + range_id).remove();
        }
        else {
            $("#placement_range_" + range_id).remove();
        }


    }

    function addMoreFormulaDetail(id) {

        var formula_detail_id = $(id).data('formula-detail-id');
        var range_id = $(id).data('range-id');
        /*$(id).addClass('display-none');*/

        $("#remove-formula-detail-" + range_id + formula_detail_id).removeClass('display-none');
        formula_detail_id++;
        //alert(range_id + ' ' + formula_detail_id);
        $('#add-formula-detail-' + range_id + formula_detail_id).remove();
        // Layout options


        for (var i = 0; i <= parseInt(range_id); i++) {

            var $newTextArea = $('<div />', {
                'id': 'formula_detail_' + i + formula_detail_id,
                'class': 'form-group ' + formula_detail_id
            });
            $newTextArea.append(
                '<label for="title" class="col-sm-2 control-label">'
                + '</label>'
                + '<div class="col-sm-6 ">'
                + ' <div class="form-row">'
                + ' <div class="col-md-6 mb-3">'
                + ' <label for="">Tenure</label>'
                + '<input type="text" class="form-control only_numeric tenure-' + formula_detail_id + '" id="" name="tenure[' + i + '][' + formula_detail_id + ']" placeholder="" data-formula-detail-id=' + formula_detail_id + ' onchange="changeTenureValue(this)">'
                + '</div>'
                + '<div class="col-md-6 mb-3">'
                + '<label for="">Bonus Interest</label>'
                + '<input type="text" class="form-control only_numeric" id="" name="bonus_interest[' + i + '][' + formula_detail_id + ']" placeholder="" >'
                + '</div>'
                + '</div>'
                + '</div>'
                + '  <div class="col-sm-1 col-sm-offset-1 " id="remove-formula-detail-' + i + formula_detail_id + '">'

                + ' </div>'
                + ' <div class="col-sm-2">&emsp;</div>'
            );
            $('#new-formula-detail-' + i).append($newTextArea);
            if (i == 0) {
                var removeFormulaDetailButton = '<button type="button" class="btn btn-danger -pull-right" data-formula-detail-id ="' + formula_detail_id
                    + '" data-range-id ="' + range_id + ' " id="remove-formula-detail-' + i + formula_detail_id + '" onClick="removeFormulaDetail(this);" >'
                    + '<i class="fa fa-minus"> </i>'
                    + ' </button>';
                $('#remove-formula-detail-' + i + formula_detail_id).append(removeFormulaDetailButton);
            } else {
                $('input[name="tenure[' + i + '][' + formula_detail_id + ']"]').prop('readonly', true);
            }
            var addMoreFormulaDetailButton = ' <button type="button" class="btn btn-info pull-left mr-15  " data-formula-detail-id="' + formula_detail_id + '" data-range-id="' + range_id + '" id="add-formula-detail-' + range_id + formula_detail_id + '" onClick="addMoreFormulaDetail(this); " > ' + ' <i class="fa fa-plus"> </i> </button>';
            $('#add-formula-detail-button').html(addMoreFormulaDetailButton);
        }

    }

    function removeFormulaDetail(id) {
        var formula = $("#formula").val();
        var formula_detail_id = $(id).data('formula-detail-id');
        $("." + formula_detail_id).remove();
    }
    function changeTenureValue(id) {

        var formula_detail_id = $(id).data('formula-detail-id');
        $(".tenure-" + formula_detail_id).val($(id).val());
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

    $('.iconpicker').iconpicker();

    function dateChange(obj) {
        var ongoingButton;
        var startDate = $("#promotion_start_date").val();
        var endDate = $("#promotion_end_date").val();
        if ((startDate.length == 0) && (endDate.length == 0)) {
            ongoingButton = '<button type="button" data-status="true" id="ongoing-status" class="btn btn-block btn-success btn-social" onclick="changeOnGoingStatus(this)"><i class="fa fa-check"></i> Ongoing</button>';
            $('#promotion-period').val('Ongoing');
            /*
             $('#promotion-period').attr('readonly', true);
             $('#until-end-date').attr('disabled', false);*/
        } else {
            ongoingButton = '<button type="button" data-status="false" id="ongoing-status" class="btn btn-block btn-danger btn-social" onclick="changeOnGoingStatus(this)"><i class="fa fa-times"></i> Ongoing</button>';
            /*$('#promotion-period').attr('readonly', false);
             $('#until-end-date').val('');
             $('#until-end-date').attr('disabled', true);*/
        }
        $('#ongoing').html(ongoingButton);
    }
    function changeOnGoingStatus(obj) {
        var ongoingButton;
        var status = $(obj).data('status');
        var startDate = $("#promotion_start_date").data('date');
        var endDate = $("#promotion_end_date").data('date');

        if (status == true) {
            if ((startDate.length == 0) && (endDate.length == 0)) {
                var d = new Date();

                var month = d.getMonth() + 1;
                var day = d.getDate();

                var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;
                startDate = endDate = output;
            }
            $("#promotion_start_date").val(startDate);
            $("#promotion_end_date").val(endDate);
            ongoingButton = '<button type="button" data-status="false" id="ongoing-status" class="btn btn-block btn-danger btn-social" onclick="changeOnGoingStatus(this)"><i class="fa fa-times"></i> Ongoing</button>';
            /* $('#promotion-period').attr('readonly', false);
             $('#until-end-date').val('');
             $('#until-end-date').attr('disabled', true);*/
        } else {
            $("#promotion_start_date").val(null);
            $("#promotion_end_date").val(null);
            ongoingButton = '<button type="button" data-status="true" id="ongoing-status" class="btn btn-block btn-success btn-social" onclick="changeOnGoingStatus(this)"><i class="fa fa-check"></i> Ongoing</button>';
            /*
             $('#promotion-period').attr('readonly', true);
             $('#until-end-date').attr('disabled', false);*/
        }
        $('#ongoing').html(ongoingButton);


    }
    function changeOnGoingStatus1(obj) {
        var ongoingButton;
        var status = $(obj).data('status');

        if (status == true) {
            ongoingButton = '<button type="button" data-status="false" id="ongoing-status-1" class="btn btn-block btn-danger btn-social" onclick="changeOnGoingStatus1(this)"><i class="fa fa-times"></i> Ongoing</button>';
            $('#promotion-period').val('');
            $('#until-end-date').attr('disabled', false);
        } else {
            ongoingButton = '<button type="button" data-status="true" id="ongoing-status-1" class="btn btn-block btn-success btn-social" onclick="changeOnGoingStatus1(this)"><i class="fa fa-check"></i> Ongoing</button>';
            $('#promotion-period').val('{{ONGOING}}');
            $('#until-end-date').val('');
            $('#until-end-date').attr('disabled', true);
        }
        $('#ongoing-1').html(ongoingButton);


    }
    function changeApplyStatus(obj) {
        var applyButton;
        var status = $(obj).data('status');

        if (status == true) {
            $('#link_ad').attr('readonly', 'readonly');
            $("#apply-link-status").val("0");
            applyButton = '<button type="button" data-status="false" id="" class="btn btn-block btn-danger  btn-social" onclick="changeApplyStatus(this)"><i class="fa fa-times"></i>Disable</button>';
        } else {
            $('#link_ad').removeAttr('readonly');
            $("#apply-link-status").val("1");
            applyButton = '<button type="button" data-status="true" id="" class="btn btn-block btn-success btn-social" onclick="changeApplyStatus(this)"><i class="fa fa-check"></i>Enable</button>';
        }
        $('#apply-status').html(applyButton);

    }
    function changeAIO5Status(obj) {
        var applyButton;
        var status = $(obj).data('status');
        var id = $(obj).attr('id');
        if (status == true) {
            $("#"+id + "-input").val("0");
            $(obj).data('status', false);
            $(obj).removeClass('btn-success');
            $(obj).addClass('btn-danger');
            applyButton = '<i class="fa fa-times"></i>Disable';
        } else {
            $("#"+id + "-input").val("1");
            $(obj).data('status', true);
            $(obj).removeClass('btn-danger');
            $(obj).addClass('btn-success');
            applyButton = '<i class="fa fa-check"></i>Enable';
        }
        $(obj).html(applyButton);

    }

</script>