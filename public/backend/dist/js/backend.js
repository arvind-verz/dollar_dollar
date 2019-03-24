$(document).ready(function () {
//Initialize Select2 Elements
    $('.select2').select2();
    var productsTable =
        $('#products').DataTable(
            {
                dom: 'lrtip',
                "pageLength": 100,
                'ordering': true,
                'order': [[9, 'desc']],
                "columnDefs": [],
                "aoColumnDefs": [{
                    "aTargets": [],
                    "bSortable": false,
                },
                    {width: 60, targets: 0},
                    {width: 100, targets: 1},
                    {width: 100, targets: 2},
                    {width: 100, targets: 3},
                    {width: 100, targets: 4},
                    {width: 100, targets: 5},
                    {width: 100, targets: 6},
                    {width: 100, targets: 7},
                    {width: 100, targets: 8},
                    {width: 100, targets: 9}
                ]
            });
    $('#product-filter').on('change', function () {
        productsTable.search(this.value).draw();
    });
    $('#ads').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[16, 'desc'], [15, 'desc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 100, targets: 4},
                {width: 150, targets: 5},
                {width: 100, targets: 6},
                {width: 100, targets: 7},
                {width: 100, targets: 8},
                {width: 100, targets: 9},
                {width: 100, targets: 10},
                {width: 100, targets: 11},
                {width: 100, targets: 12},
                {width: 100, targets: 13},
                {width: 100, targets: 14},
                {width: 100, targets: 15},
                {width: 100, targets: 16}
            ]
        });
    $('#banners').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[11, 'desc'], [10, 'desc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 200, targets: 0},
                {width: 100, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 100, targets: 4},
                {width: 150, targets: 5},
                {width: 100, targets: 6},
                {width: 100, targets: 7},
                {width: 100, targets: 8},
                {width: 100, targets: 9},
                {width: 100, targets: 10},
                {width: 100, targets: 11}
            ]
        });
    $('#brands').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[7, 'asc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 150, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 100, targets: 4},
                {width: 150, targets: 5},
                {width: 100, targets: 6},
                {width: 100, targets: 7},
                {width: 100, targets: 8},
                {width: 100, targets: 9}
            ]
        });
    $('#menus').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[2, 'asc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 200, targets: 0}
            ]
        });
    $('#pages').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [
                [6, 'desc'],
                [5, 'desc']
            ],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 120, targets: 0}
            ]
        });
    $('#blogs').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [
                [7, 'desc'],
                [6, 'desc']
            ],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 120, targets: 0}
            ]
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
                {width: 300, targets: 0},
                {width: 300, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 150, targets: 4},
                {width: 100, targets: 5},
                {width: 100, targets: 6},
                {width: 100, targets: 7}
            ]
        });


    $('#customer-deletion-report').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    },
                    title: 'Customer Deletion',
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
                        return 'Customer deletion ' + today;
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
                        return 'Customer deletion ' + today;
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [[6, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false,
            },
                {width: 60, targets: 0},
                {width: 300, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 150, targets: 4},
                {width: 100, targets: 5}
            ]
        });
    $('#tags').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[5, 'desc'], [4, 'desc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1}
            ]
        });
    $('#users').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[9, 'desc'], [8, 'desc'], [7, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1},

            ]
        });
    $('#admins').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[7, 'desc'], [6, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1}

            ]
        });
    $('#reports').DataTable();
    $('#activities').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        return 'Activity log ' + today;
                    }
                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        return 'Activity log ' + today;
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [[6, 'asc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false,
            },
                {width: 300, targets: 0},
                {width: 300, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 150, targets: 4},
                {width: 100, targets: 5},
                {width: 100, targets: 6}
            ]
        });
    $('#customer-update-detail-report').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
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
                        return 'Activity log ' + today;
                    }
                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
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
                        return 'Activity log ' + today;
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [[5, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false,
            },
                {width: 100, targets: 0},
                {width: 500, targets: 1},
                {width: 300, targets: 2},
                {width: 300, targets: 3},
                {width: 150, targets: 4},
                {width: 100, targets: 5}
            ]
        });

    $('#rate-types').DataTable(
        {
            "pageLength": 100,
            'ordering': true,
            'order': [[5, 'desc'], [4, 'desc']],
            "columnDefs": [],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 100, targets: 0},

            ]
        });
    /*$('#product-ads').DataTable(
     {
     "pageLength": 100,
     'ordering': true,
     'order': [[11, 'desc'], [10, 'desc']],
     "columnDefs": []
     });
     $('#email-ads').DataTable(
     {
     "pageLength": 100,
     'ordering': true,
     'order': [[10, 'desc'], [9, 'desc']],
     "columnDefs": []
     });*/


    $('#contact-table').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    title: 'Contact enquiry',
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7]
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
                        columns: [2, 3, 4, 5, 6, 7]
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
                        columns: [2, 3, 4, 5, 6, 7]
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
            'order': [[7, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1},
                {width: 100, targets: 2},
                {width: 100, targets: 3},
                {width: 100, targets: 4},
                {width: 100, targets: 5},
                {width: 400, targets: 6},
                {width: 100, targets: 7}
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
            'order': [[11, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1},

            ]
        });
    $('#investment').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
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
            'order': [[13, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1}

            ]
        });
    $('#health').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10]
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10]
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
            'order': [[10, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1}

            ]
        });
    $('#loan-enquiry').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    },
                    title: 'Loan enquiry',
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
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                        return 'Loan ' + today;
                    }
                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                        return 'Loan ' + today;
                    }
                }
            ],
            "pageLength": 100,
            'ordering': true,
            'order': [[11, 'desc']],
            "aoColumnDefs": [{
                "aTargets": [],
                "bSortable": false
            },
                {width: 60, targets: 0},
                {width: 100, targets: 1}

            ]
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


});
