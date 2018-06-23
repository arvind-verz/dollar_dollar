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
                    'order': [[7, 'desc'], [6, 'desc']],
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
                                columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                                return today + '-Customers-Report';
                            }
                        }
                    ],
                });

        $('#rootwizard').bootstrapWizard({

            'tabClass': 'nav nav-pills',
            'onPrevious': function (tab, navigation, index) {
                $("#error-div").addClass('display-none');
                var product_id = $.trim($("#product-id").val());
                var errorSection = document.getElementById("js-errors");
                var minPlacementAmount = $.trim($('#minimum-placement-amount').val());
                errorSection.innerHTML = '';
                var formula = $.trim($('#formula').val());
                var errors = new Array();
                var i = 0;

                if (index == 1) {
                    var name = $.trim($('#name').val());
                    var bank = $.trim($('#bank').val());
                    var productType = $.trim($('#product-type').val());
                    var maxInterestRate = $.trim($('#maximum-interest-rate').val());
                    var promotionPeriod = $.trim($('#promotion-period').val());
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
                    if (!formula) {
                        errors[i] = 'The formula is required.';
                        i++;
                    }
                    if (!startDate) {
                        errors[i] = 'The start date is required.';
                        i++;
                    }
                    if (!endDate) {
                        errors[i] = 'The end date is required.';
                        i++;
                    }
                    if (!minPlacementAmount) {
                        errors[i] = 'The minimum placement is required.';
                        i++;
                    }
                    if (!maxInterestRate) {
                        errors[i] = 'The maximum interest rate is required.';
                        i++;
                    }
                    if (!promotionPeriod) {
                        errors[i] = 'The promotion period is required.';
                        i++;
                    }
                }
                if (index == 0) {
                    if (formula == 1) {
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
                                }
                            });
                        }
                        if (tenureError == false) {
                            $.ajax({
                                method: "POST",
                                url: "{{url('/admin/check-tenure')}}",
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
                        }
                    }
                    if (formula == 2 || formula == 3 || formula == 5) {
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
                                }
                            });
                        }
                    }
                    if (formula == 4) {
                        var rateCounter = $('#savingDepositF3').find('input[name^="counter_sdp3"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
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
                        $.each(rateCounter, function (k, v) {
                            if (rateCounter[k] == '') {
                                errors[i] = 'The counter rate is required.';
                                i++;

                                return false;
                            }
                        });

                        if (averageInterestRate == '') {
                            errors[i] = 'The average interest rate is required.';
                            i++;
                        }
                        if (siborRate == '') {
                            errors[i] = 'The sibor rate is required.';
                            i++;

                        }


                    }
                    if (formula == 6) {
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
                        var WealthMinAmount = allInOneAccountF1.find('input[name="minimum_wealth_pa_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var WealthBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_wealth_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var LoanMinAmount = allInOneAccountF1.find('input[name="minimum_loan_pa_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
                        var LoanBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_loan_aioa1"]').map(function () {
                            return $.trim($(this).val());
                        }).get();
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


                        if (parseInt(minPlacementAmount) > parseInt(minPlacement)) {
                            errors[i] = 'The  minimum placement range  is not greater than or equal to minimum placement amount.';
                            i++;
                        } else {
                            if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
                                errors[i] = 'Please check your placement range. ';
                                i++;
                            }
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
                        if (WealthMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Wealth) is required.';
                            i++;
                        }
                        if (WealthBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Wealth) is required.';
                            i++;
                        }
                        if (LoanMinAmount == '') {
                            errors[i] = 'The minimum requirement amount (Loan) is required.';
                            i++;
                        }
                        if (LoanBonusInterest == '') {
                            errors[i] = 'The  bonus interest (Loan) is required.';
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
        if (formula == 1) {
            var data = $('#fixDepositF1').find('input[name^="tenure[0]"]').serializeArray();
            var formula_detail_id = data.length - 1;
            jQuery.ajax({
                type: "POST",
                url: "{{url('/admin/add-more-placement-range')}}",
                data: {detail: data, range_id: range_id, formula: formula}
            }).done(function (data) {
                $('#new-placement-range').append(data);
                var addMoreRangeButton = ' <button type="button" class="btn btn-info pull-left mr-15 add-placement-range-button" data-range-id= ' + range_id + ' onClick="addMorePlacementRange(this);"><i class="fa fa-plus"></i> </button>';
                $('#add-placement-range-button').html(addMoreRangeButton);
                var addMoreFormulaDetailButton = ' <button type="button" class="btn btn-info pull-left mr-15  " data-formula-detail-id="' + formula_detail_id + '" data-range-id="' + range_id + '" id="add-formula-detail-' + range_id + formula_detail_id + '" onClick="addMoreFormulaDetail(this); " > ' + ' <i class="fa fa-plus"> </i> </button>';
                $('#add-formula-detail-button').html(addMoreFormulaDetailButton);
            });
        }
        if (formula == 2 || formula == 3 || formula == 5) {
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
    }

    function addCounter(id) {
        var formula = $("#formula").val();
        var counterValue = $(id).val();
        if (formula == 4) {
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
        var range_id = $(id).data('range-id');
        $("#placement_range_" + range_id).remove();

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
</script>