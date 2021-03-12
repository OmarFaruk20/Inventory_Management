//This file contains all common functionality for the application

$(document).ready(function() {
    $.ajaxSetup({
        beforeSend: function(jqXHR, settings) {
            if (settings.url.indexOf('http') === -1) {
                settings.url = base_path + settings.url;
            }
        },
    });

    update_font_size();
    if ($('#status_span').length) {
        var status = $('#status_span').attr('data-status');
        if (status === '1') {
            toastr.success($('#status_span').attr('data-msg'));
        } else if (status === '0') {
            toastr.error($('#status_span').attr('data-msg'));
        }
    }

    //Default setting for select2
    $.fn.select2.defaults.set('minimumResultsForSearch', 6);
    if ($('html').attr('dir') == 'rtl') {
        $.fn.select2.defaults.set('dir', 'rtl');
    }
    $.fn.datepicker.defaults.todayHighlight = true;

    //Toastr setting
    toastr.options.preventDuplicates = true;

    //Play notification sound on success, error and warning
    toastr.options.onShown = function() {
        if ($(this).hasClass('toast-success')) {
            var audio = $('#success-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass('toast-error')) {
            var audio = $('#error-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass('toast-warning')) {
            var audio = $('#warning-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        }
    };

    //Default setting for jQuey validator
    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('select2')) {
                error.insertAfter(element.next('span.select2-container'));
            } else if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else if (element.parent().hasClass('multi-input')) {
                error.insertAfter(element.closest('.multi-input'));
            } else {
                error.insertAfter(element);
            }
        },

        invalidHandler: function() {
            toastr.error(LANG.some_error_in_input_field);
        },
    });

    jQuery.validator.addMethod(
        'max-value',
        function(value, element, param) {
            return this.optional(element) || !(param < __number_uf(value));
        },
        function(params, element) {
            return $(element).data('msg-max-value');
        }
    );

    jQuery.validator.addMethod('abs_digit', function(value, element) {
        return this.optional(element) || Number.isInteger(Math.abs(__number_uf(value)));
    });

    //Set global currency to be used in the application
    __currency_symbol = $('input#__symbol').val();
    __currency_thousand_separator = $('input#__thousand').val();
    __currency_decimal_separator = $('input#__decimal').val();
    __currency_symbol_placement = $('input#__symbol_placement').val();
    if ($('input#__precision').length > 0) {
        __currency_precision = $('input#__precision').val();
    } else {
        __currency_precision = 2;
    }

    if ($('input#__quantity_precision').length > 0) {
        __quantity_precision = $('input#__quantity_precision').val();
    } else {
        __quantity_precision = 2;
    }

    //Set page level currency to be used for some pages. (Purchase page)
    if ($('input#p_symbol').length > 0) {
        __p_currency_symbol = $('input#p_symbol').val();
        __p_currency_thousand_separator = $('input#p_thousand').val();
        __p_currency_decimal_separator = $('input#p_decimal').val();
    }

    __currency_convert_recursively($(document), $('input#p_symbol').length);

    var buttons = [
        {
            extend: 'copy',
            text: '<i class="fa fa-files-o" aria-hidden="true"></i> ' + LANG.copy,
            className: 'bg-info',
            exportOptions: {
                columns: ':visible',
            },
            footer: true,
        },
        {
            extend: 'csv',
            text: '<i class="fa fa-file-text-o" aria-hidden="true"></i> ' + LANG.export_to_csv,
            className: 'bg-info',
            exportOptions: {
                columns: ':visible',
            },
            footer: true,
        },
        {
            extend: 'excel',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> ' + LANG.export_to_excel,
            className: 'bg-info',
            exportOptions: {
                columns: ':visible',
            },
            footer: true,
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print" aria-hidden="true"></i> ' + LANG.print,
            className: 'bg-info',
            exportOptions: {
                columns: ':visible',
                stripHtml: false,
            },
            footer: true,
        },
        {
            extend: 'colvis',
            text: '<i class="fa fa-columns" aria-hidden="true"></i> ' + LANG.col_vis,
            className: 'bg-info',
        },
    ];

    var pdf_btn = {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ' + LANG.export_to_pdf,
        className: 'bg-info',
        exportOptions: {
            columns: ':visible',
        },
        footer: true,
    };

    if (non_utf8_languages.indexOf(app_locale) == -1) {
        buttons.push(pdf_btn);
    }

    //Datables
    jQuery.extend($.fn.dataTable.defaults, {
        fixedHeader: true,
        dom:
            '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right margin-left-10"B><"pull-right"fr>>>tip',
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fa fa-list" aria-hidden="true"></i> &nbsp;' + LANG.action,
                className: 'btn-info',
                init: function(api, node, config) {
                    $(node).removeClass('btn-default');
                },
                buttons: buttons,
            },
        ],
        aLengthMenu: [[25, 50, 100, 200, 500, 1000, -1], [25, 50, 100, 200, 500, 1000, LANG.all]],
        iDisplayLength: 25,
        language: {
            search: LANG.search + ':',
            lengthMenu: LANG.show + ' _MENU_ ' + LANG.entries,
            emptyTable: LANG.table_emptyTable,
            info: LANG.table_info,
            infoEmpty: LANG.table_infoEmpty,
            loadingRecords: LANG.table_loadingRecords,
            processing: LANG.table_processing,
            zeroRecords: LANG.table_zeroRecords,
            paginate: {
                first: LANG.first,
                last: LANG.last,
                next: LANG.next,
                previous: LANG.previous,
            },
        },
    });

    if ($('input#iraqi_selling_price_adjustment').length > 0) {
        iraqi_selling_price_adjustment = true;
    } else {
        iraqi_selling_price_adjustment = false;
    }

    //Input number
    $(document).on('click', '.input-number .quantity-up, .input-number .quantity-down', function() {
        var input = $(this)
            .closest('.input-number')
            .find('input');
        var qty = __read_number(input);
        var step = 1;
        if (input.data('step')) {
            step = input.data('step');
        }
        var min = parseFloat(input.data('min'));
        var max = parseFloat(input.data('max'));

        if ($(this).hasClass('quantity-up')) {
            //if max reached return false
            if (typeof max != 'undefined' && qty + step > max) {
                return false;
            }

            __write_number(input, qty + step);
            input.change();
        } else if ($(this).hasClass('quantity-down')) {
            //if max reached return false
            if (typeof min != 'undefined' && qty - step < min) {
                return false;
            }

            __write_number(input, qty - step);
            input.change();
        }
    });

    $('div.pos-tab-menu>div.list-group>a').click(function(e) {
        e.preventDefault();
        $(this)
            .siblings('a.active')
            .removeClass('active');
        $(this).addClass('active');
        var index = $(this).index();
        $('div.pos-tab>div.pos-tab-content').removeClass('active');
        $('div.pos-tab>div.pos-tab-content')
            .eq(index)
            .addClass('active');
    });
});

//Default settings for daterangePicker
var ranges = {};
ranges[LANG.today] = [moment(), moment()];
ranges[LANG.yesterday] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
ranges[LANG.last_7_days] = [moment().subtract(6, 'days'), moment()];
ranges[LANG.last_30_days] = [moment().subtract(29, 'days'), moment()];
ranges[LANG.this_month] = [moment().startOf('month'), moment().endOf('month')];
ranges[LANG.last_month] = [
    moment()
        .subtract(1, 'month')
        .startOf('month'),
    moment()
        .subtract(1, 'month')
        .endOf('month'),
];
ranges[LANG.this_financial_year] = [financial_year.start, financial_year.end];
var dateRangeSettings = {
    ranges: ranges,
    startDate: financial_year.start,
    endDate: financial_year.end,
    locale: {
        cancelLabel: LANG.clear,
        applyLabel: LANG.apply,
        customRangeLabel: LANG.custom_range,
        format: moment_date_format,
        toLabel: '~',
    },
};

//Check for number string in input field, if data-decimal is 0 then don't allow decimal symbol
$(document).on('keypress', 'input.input_number', function(event) {
    var is_decimal = $(this).data('decimal');

    if (is_decimal == 0) {
        if (__currency_decimal_separator == '.') {
            var regex = new RegExp(/^[0-9,-]+$/);
        } else {
            var regex = new RegExp(/^[0-9.-]+$/);
        }
    } else {
        var regex = new RegExp(/^[0-9.,-]+$/);
    }

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

//Select all input values on click
$(document).on('click', 'input, textarea', function(event) {
    $(this).select();
});

$(document).on('click', '.toggle-font-size', function(event) {
    localStorage.setItem('upos_font_size', $(this).data('size'));
    update_font_size();
});
$(document).on('click', '.sidebar-toggle', function() {
    var sidebar_collapse = localStorage.getItem('upos_sidebar_collapse');
    if ($('body').hasClass('sidebar-collapse')) {
        localStorage.setItem('upos_sidebar_collapse', 'false');
    } else {
        localStorage.setItem('upos_sidebar_collapse', 'true');
    }
});

//Ask for confirmation for links
$(document).on('click', 'a.link_confirmation', function(e) {
    e.preventDefault();
    swal({
        title: LANG.sure,
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then(confirmed => {
        if (confirmed) {
            window.location.href = $(this).attr('href');
        }
    });
});

//Change max quantity rule if lot number changes
$('table#stock_adjustment_product_table tbody').on('change', 'select.lot_number', function() {
    var qty_element = $(this)
        .closest('tr')
        .find('input.product_quantity');
    if ($(this).val()) {
        var lot_qty = $('option:selected', $(this)).data('qty_available');
        var max_err_msg = $('option:selected', $(this)).data('msg-max');
        qty_element.attr('data-rule-max-value', lot_qty);
        qty_element.attr('data-msg-max-value', max_err_msg);

        qty_element.rules('add', {
            'max-value': lot_qty,
            messages: {
                'max-value': max_err_msg,
            },
        });
    } else {
        var default_qty = qty_element.data('qty_available');
        var default_err_msg = qty_element.data('msg_max_default');
        qty_element.attr('data-rule-max-value', default_qty);
        qty_element.attr('data-msg-max-value', default_err_msg);

        qty_element.rules('add', {
            'max-value': default_qty,
            messages: {
                'max-value': default_err_msg,
            },
        });
    }
    qty_element.trigger('change');
});
$('button#btnCalculator').hover(function() {
    $(this).tooltip('show');
});
$(document).on('mouseleave', 'button#btnCalculator', function(e) {
    $(this).tooltip('hide');
});

jQuery.validator.addMethod(
    'min-value',
    function(value, element, param) {
        return this.optional(element) || !(param > __number_uf(value));
    },
    function(params, element) {
        return $(element).data('min-value');
    }
);

$(document).on('click', '.view_uploaded_document', function(e) {
    e.preventDefault();
    var src = $(this).data('href');
    var html =
        '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><img src="' +
        src +
        '" class="img-responsive" alt="Uploaded Document"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <a href="' +
        src +
        '" class="btn btn-success" download=""><i class="fa fa-download"></i> Download</a></div></div></div>';
    $('div.view_modal')
        .html(html)
        .modal('show');
});

$(document).on('click', '#accordion .box-header', function(e) {
    if (e.target.tagName == 'A' || e.target.tagName == 'I') {
        return false;
    }
    $(this)
        .find('.box-title a')
        .click();
});
