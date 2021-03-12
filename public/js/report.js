$(document).ready(function() {
    //Purchase & Sell report
    //Date range as a button
    if ($('#purchase_sell_date_filter').length == 1) {
        $('#purchase_sell_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#purchase_sell_date_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            updatePurchaseSell();
        });
        $('#purchase_sell_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#purchase_sell_date_filter').html(
                '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
            );
        });
        updatePurchaseSell();
    }

    //Supplier report
    supplier_report_tbl = $('#supplier_report_tbl').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/reports/customer-supplier',
        columnDefs: [
            { targets: [5], orderable: false, searchable: false },
            { targets: [1, 2, 3, 4], searchable: false },
        ],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'total_purchase', name: 'total_purchase' },
            { data: 'total_purchase_return', name: 'total_purchase_return' },
            { data: 'total_invoice', name: 'total_invoice' },
            { data: 'total_sell_return', name: 'total_sell_return' },
            { data: 'opening_balance_due', name: 'opening_balance_due' },
            { data: 'due', name: 'due' },
        ],
        fnDrawCallback: function(oSettings) {
            var total_purchase = sum_table_col($('#supplier_report_tbl'), 'total_purchase');
            $('#footer_total_purchase').text(total_purchase);

            var total_purchase_return = sum_table_col(
                $('#supplier_report_tbl'),
                'total_purchase_return'
            );
            $('#footer_total_purchase_return').text(total_purchase_return);

            var total_sell = sum_table_col($('#supplier_report_tbl'), 'total_invoice');
            $('#footer_total_sell').text(total_sell);

            var total_sell_return = sum_table_col($('#supplier_report_tbl'), 'total_sell_return');
            $('#footer_total_sell_return').text(total_sell_return);

            var total_opening_bal_due = sum_table_col(
                $('#supplier_report_tbl'),
                'opening_balance_due'
            );
            $('#footer_total_opening_bal_due').text(total_opening_bal_due);

            var total_due = sum_table_col($('#supplier_report_tbl'), 'total_due');
            $('#footer_total_due').text(total_due);

            __currency_convert_recursively($('#supplier_report_tbl'));
        },
    });

    //Stock report table
    stock_report_table = $('#stock_report_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/reports/stock-report',
            data: function(d) {
                d.location_id = $('#location_id').val();
                d.category_id = $('#category_id').val();
                d.sub_category_id = $('#sub_category_id').val();
                d.brand_id = $('#brand').val();
                d.unit_id = $('#unit').val();
            },
        },
        columns: [
            { data: 'sku', name: 'variations.sub_sku' },
            { data: 'product', name: 'p.name' },
            { data: 'unit_price', name: 'variations.sell_price_inc_tax' },
            { data: 'stock', name: 'stock', searchable: false },
            { data: 'total_sold', name: 'total_sold', searchable: false },
            { data: 'total_transfered', name: 'total_transfered', searchable: false },
            { data: 'total_adjusted', name: 'total_adjusted', searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            $('#footer_total_stock').html(__sum_stock($('#stock_report_table'), 'current_stock'));
            $('#footer_total_sold').html(__sum_stock($('#stock_report_table'), 'total_sold'));
            $('#footer_total_transfered').html(
                __sum_stock($('#stock_report_table'), 'total_transfered')
            );
            $('#footer_total_adjusted').html(
                __sum_stock($('#stock_report_table'), 'total_adjusted')
            );
            __currency_convert_recursively($('#stock_report_table'));
        },
    });

    if ($('#tax_report_date_filter').length == 1) {
        $('#tax_report_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#tax_report_date_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            updateTaxReport();
        });
        $('#tax_report_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#tax_report_date_filter').html(
                '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
            );
        });
        updateTaxReport();
    }

    if ($('#trending_product_date_range').length == 1) {
        get_sub_categories();
        $('#trending_product_date_range').daterangepicker({
            ranges: ranges,
            autoUpdateInput: false,
            locale: {
                format: moment_date_format,
                cancelLabel: LANG.clear,
                applyLabel: LANG.apply,
                customRangeLabel: LANG.custom_range,
            },
        });
        $('#trending_product_date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(
                picker.startDate.format(moment_date_format) +
                    ' ~ ' +
                    picker.endDate.format(moment_date_format)
            );
        });

        $('#trending_product_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    }

    $(
        '#stock_report_filter_form #location_id, #stock_report_filter_form #category_id, #stock_report_filter_form #sub_category_id, #stock_report_filter_form #brand, #stock_report_filter_form #unit,#stock_report_filter_form #view_stock_filter'
    ).change(function() {
        stock_report_table.ajax.reload();
        stock_expiry_report_table.ajax.reload();
    });

    $('#purchase_sell_location_filter').change(function() {
        updatePurchaseSell();
    });
    $('#tax_report_location_filter').change(function() {
        updateTaxReport();
    });

    //Stock Adjustment Report
    if ($('#stock_adjustment_date_filter').length == 1) {
        $('#stock_adjustment_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#stock_adjustment_date_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            updateStockAdjustmentReport();
        });
        $('#purchase_sell_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#purchase_sell_date_filter').html(
                '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
            );
        });
        updateStockAdjustmentReport();
    }

    $('#stock_adjustment_location_filter').change(function() {
        updateStockAdjustmentReport();
    });

    //Register report
    register_report_table = $('#register_report_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/reports/register-report',
        columnDefs: [{ targets: [6], orderable: false, searchable: false }],
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'closed_at', name: 'closed_at' },
            { data: 'user_name', name: 'user_name' },
            { data: 'total_card_slips', name: 'total_card_slips' },
            { data: 'total_cheques', name: 'total_cheques' },
            { data: 'closing_amount', name: 'closing_amount' },
            { data: 'action', name: 'action' },
        ],
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#register_report_table'));
        },
    });
    $('.view_register').on('shown.bs.modal', function() {
        __currency_convert_recursively($(this));
    });
    $(document).on('submit', '#register_report_filter_form', function(e) {
        e.preventDefault();
        updateRegisterReport();
    });

    $('#register_user_id, #register_status').change(function() {
        updateRegisterReport();
    });

    //Sales representative report
    if ($('#sr_date_filter').length == 1) {
        //date range setting
        $('input#sr_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('input#sr_date_filter').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            updateSalesRepresentativeReport();
        });
        $('input#sr_date_filter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(
                picker.startDate.format(moment_date_format) +
                    ' ~ ' +
                    picker.endDate.format(moment_date_format)
            );
        });

        $('input#sr_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        //Sales representative report -> Total expense
        if ($('span#sr_total_expenses').length > 0) {
            salesRepresentativeTotalExpense();
        }
        //Sales representative report -> Total sales
        if ($('span#sr_total_sales').length > 0) {
            salesRepresentativeTotalSales();
        }

        //Sales representative report -> Sales
        sr_sales_report = $('table#sr_sales_report').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: {
                url: '/sells',
                data: function(d) {
                    var start = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    var end = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');

                    (d.created_by = $('select#sr_id').val()),
                        (d.location_id = $('select#sr_business_id').val()),
                        (d.start_date = start),
                        (d.end_date = end);
                },
            },
            columns: [
                { data: 'transaction_date', name: 'transaction_date' },
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'name', name: 'contacts.name' },
                { data: 'business_location', name: 'bl.name' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'final_total', name: 'final_total' },
                { data: 'total_paid', name: 'total_paid' },
                { data: 'total_remaining', name: 'total_remaining' },
            ],
            columnDefs: [
                {
                    searchable: false,
                    targets: [6],
                },
            ],
            fnDrawCallback: function(oSettings) {
                $('#sr_footer_sale_total').text(
                    sum_table_col($('#sr_sales_report'), 'final-total')
                );

                $('#sr_footer_total_paid').text(sum_table_col($('#sr_sales_report'), 'total-paid'));

                $('#sr_footer_total_remaining').text(
                    sum_table_col($('#sr_sales_report'), 'payment_due')
                );
                $('#sr_footer_total_sell_return_due').text(
                    sum_table_col($('#sr_sales_report'), 'sell_return_due')
                );

                $('#sr_footer_payment_status_count ').html(
                    __sum_status_html($('#sr_sales_report'), 'payment-status-label')
                );
                __currency_convert_recursively($('#sr_sales_report'));
            },
        });

        //Sales representative report -> Expenses
        sr_expenses_report = $('table#sr_expenses_report').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: {
                url: '/expenses',
                data: function(d) {
                    var start = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    var end = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');

                    (d.expense_for = $('select#sr_id').val()),
                        (d.location_id = $('select#sr_business_id').val()),
                        (d.start_date = start),
                        (d.end_date = end);
                },
            },
            columnDefs: [
                {
                    targets: 7,
                    orderable: false,
                    searchable: false,
                },
            ],
            columns: [
                { data: 'transaction_date', name: 'transaction_date' },
                { data: 'ref_no', name: 'ref_no' },
                { data: 'category', name: 'ec.name' },
                { data: 'location_name', name: 'bl.name' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'final_total', name: 'final_total' },
                { data: 'expense_for', name: 'expense_for' },
                { data: 'additional_notes', name: 'additional_notes' },
            ],
            fnDrawCallback: function(oSettings) {
                var expense_total = sum_table_col($('#sr_expenses_report'), 'final-total');
                $('#footer_expense_total').text(expense_total);
                $('#er_footer_payment_status_count').html(
                    __sum_status_html($('#sr_expenses_report'), 'payment-status')
                );
                __currency_convert_recursively($('#sr_expenses_report'));
            },
        });

        //Sales representative report -> Sales with commission
        sr_sales_commission_report = $('table#sr_sales_with_commission_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: {
                url: '/sells',
                data: function(d) {
                    var start = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    var end = $('input#sr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');

                    (d.commission_agent = $('select#sr_id').val()),
                        (d.location_id = $('select#sr_business_id').val()),
                        (d.start_date = start),
                        (d.end_date = end);
                },
            },
            columns: [
                { data: 'transaction_date', name: 'transaction_date' },
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'name', name: 'contacts.name' },
                { data: 'business_location', name: 'bl.name' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'final_total', name: 'final_total' },
                { data: 'total_paid', name: 'total_paid' },
                { data: 'total_remaining', name: 'total_remaining' },
            ],
            columnDefs: [
                {
                    searchable: false,
                    targets: [6],
                },
            ],
            fnDrawCallback: function(oSettings) {
                $('#footer_sale_total').text(
                    sum_table_col($('#sr_sales_with_commission_table'), 'final-total')
                );

                $('#footer_total_paid').text(
                    sum_table_col($('#sr_sales_with_commission_table'), 'total-paid')
                );

                $('#footer_total_remaining').text(
                    sum_table_col($('#sr_sales_with_commission_table'), 'payment_due')
                );
                $('#footer_total_sell_return_due').text(
                    sum_table_col($('#sr_sales_with_commission_table'), 'sell_return_due')
                );

                $('#footer_payment_status_count ').html(
                    __sum_status_html($('#sr_sales_with_commission_table'), 'payment-status-label')
                );
                __currency_convert_recursively($('#sr_sales_with_commission_table'));
                __currency_convert_recursively($('#sr_sales_with_commission'));
            },
        });

        //Sales representive filter
        $('select#sr_id, select#sr_business_id').change(function() {
            updateSalesRepresentativeReport();
        });
    }

    //Stock expiry report table
    stock_expiry_report_table = $('table#stock_expiry_report_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/reports/stock-expiry',
            data: function(d) {
                d.location_id = $('#location_id').val();
                d.category_id = $('#category_id').val();
                d.sub_category_id = $('#sub_category_id').val();
                d.brand_id = $('#brand').val();
                d.unit_id = $('#unit').val();
                d.exp_date_filter = $('#view_stock_filter').val();
            },
        },
        order: [[4, 'asc']],
        columns: [
            { data: 'product', name: 'p.name' },
            { data: 'sku', name: 'p.sku' },
            // { data: 'ref_no', name: 't.ref_no' },
            { data: 'location', name: 'l.name' },
            { data: 'stock_left', name: 'stock_left', searchable: false },
            { data: 'lot_number', name: 'lot_number' },
            { data: 'exp_date', name: 'exp_date' },
            { data: 'mfg_date', name: 'mfg_date' },
            // { data: 'edit', name: 'edit' },
        ],
        fnDrawCallback: function(oSettings) {
            __show_date_diff_for_human($('#stock_expiry_report_table'));
            $('button.stock_expiry_edit_btn').click(function() {
                var purchase_line_id = $(this).data('purchase_line_id');

                $.ajax({
                    method: 'GET',
                    url: '/reports/stock-expiry-edit-modal/' + purchase_line_id,
                    dataType: 'html',
                    success: function(data) {
                        $('div.exp_update_modal')
                            .html(data)
                            .modal('show');
                        $('input#exp_date_expiry_modal').datepicker({
                            autoclose: true,
                            format: datepicker_date_format,
                        });

                        $('form#stock_exp_modal_form').submit(function(e) {
                            e.preventDefault();

                            $.ajax({
                                method: 'POST',
                                url: $('form#stock_exp_modal_form').attr('action'),
                                dataType: 'json',
                                data: $('form#stock_exp_modal_form').serialize(),
                                success: function(data) {
                                    if (data.success == 1) {
                                        $('div.exp_update_modal').modal('hide');
                                        toastr.success(data.msg);
                                        stock_expiry_report_table.ajax.reload();
                                    } else {
                                        toastr.error(data.msg);
                                    }
                                },
                            });
                        });
                    },
                });
            });
            $('#footer_total_stock_left').html(
                __sum_stock($('#stock_expiry_report_table'), 'stock_left')
            );
            __currency_convert_recursively($('#stock_expiry_report_table'));
        },
    });

    //Profit / Loss
    if ($('#profit_loss_date_filter').length == 1) {
        $('#profit_loss_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#profit_loss_date_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            updateProfitLoss();
        });
        $('#profit_loss_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#profit_loss_date_filter').html(
                '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
            );
        });
        updateProfitLoss();
    }
    $('#profit_loss_location_filter').change(function() {
        updateProfitLoss();
    });

    //Product Purchase Report
    if ($('#product_pr_date_filter').length == 1) {
        $('#product_pr_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#product_pr_date_filter').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            product_purchase_report.ajax.reload();
        });
        $('#product_pr_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#product_pr_date_filter').val('');
            product_purchase_report.ajax.reload();
        });
        $('#product_pr_date_filter')
            .data('daterangepicker')
            .setStartDate(moment());
        $('#product_pr_date_filter')
            .data('daterangepicker')
            .setEndDate(moment());
    }
    $(
        '#product_purchase_report_form #variation_id, #product_purchase_report_form #location_id, #product_purchase_report_form #supplier_id, #product_purchase_report_form #product_pr_date_filter'
    ).change(function() {
        product_purchase_report.ajax.reload();
    });
    product_purchase_report = $('table#product_purchase_report_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[3, 'desc']],
        ajax: {
            url: '/reports/product-purchase-report',
            data: function(d) {
                var start = '';
                var end = '';
                if ($('#product_pr_date_filter').val()) {
                    start = $('input#product_pr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#product_pr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
                d.variation_id = $('#variation_id').val();
                d.supplier_id = $('select#supplier_id').val();
                d.location_id = $('select#location_id').val();
            },
        },
        columns: [
            { data: 'product_name', name: 'p.name' },
            { data: 'supplier', name: 'c.name' },
            { data: 'ref_no', name: 't.ref_no' },
            { data: 'transaction_date', name: 't.transaction_date' },
            { data: 'purchase_qty', name: 'purchase_lines.quantity' },
            { data: 'quantity_adjusted', name: 'purchase_lines.quantity_adjusted' },
            { data: 'unit_purchase_price', name: 'purchase_lines.purchase_price_inc_tax' },
            { data: 'subtotal', name: 'subtotal', searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            $('#footer_subtotal').text(
                sum_table_col($('#product_purchase_report_table'), 'row_subtotal')
            );
            $('#footer_total_purchase').html(
                __sum_stock($('#product_purchase_report_table'), 'purchase_qty')
            );
            $('#footer_total_adjusted').html(
                __sum_stock($('#product_purchase_report_table'), 'quantity_adjusted')
            );
            __currency_convert_recursively($('#product_purchase_report_table'));
        },
    });

    if ($('#search_product').length > 0) {
        $('#search_product').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/purchases/get_products?check_enable_stock=false',
                    dataType: 'json',
                    data: {
                        term: request.term,
                    },
                    success: function(data) {
                        response(
                            $.map(data, function(v, i) {
                                if (v.variation_id) {
                                    return { label: v.text, value: v.variation_id };
                                }
                                return false;
                            })
                        );
                    },
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $('#variation_id')
                    .val(ui.item.value)
                    .change();
                event.preventDefault();
                $(this).val(ui.item.label);
            },
            focus: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item.label);
            },
        });
    }

    //Product Sell Report
    if ($('#product_sr_date_filter').length == 1) {
        $('#product_sr_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#product_sr_date_filter').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            product_sell_report.ajax.reload();
            product_sell_grouped_report.ajax.reload();
        });
        $('#product_sr_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#product_sr_date_filter').val('');
            product_sell_report.ajax.reload();
            product_sell_grouped_report.ajax.reload();
        });
        $('#product_sr_date_filter')
            .data('daterangepicker')
            .setStartDate(moment());
        $('#product_sr_date_filter')
            .data('daterangepicker')
            .setEndDate(moment());
    }
    product_sell_report = $('table#product_sell_report_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[3, 'desc']],
        ajax: {
            url: '/reports/product-sell-report',
            data: function(d) {
                var start = '';
                var end = '';
                if ($('#product_sr_date_filter').val()) {
                    start = $('input#product_sr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#product_sr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;

                d.variation_id = $('#variation_id').val();
                d.customer_id = $('select#customer_id').val();
                d.location_id = $('select#location_id').val();
            },
        },
        columns: [
            { data: 'product_name', name: 'p.name' },
            { data: 'customer', name: 'c.name' },
            { data: 'invoice_no', name: 't.invoice_no' },
            { data: 'transaction_date', name: 't.transaction_date' },
            { data: 'sell_qty', name: 'transaction_sell_lines.quantity' },
            { data: 'unit_price', name: 'transaction_sell_lines.unit_price_before_discount' },
            { data: 'discount_amount', name: 'transaction_sell_lines.line_discount_amount' },
            { data: 'tax', name: 'tax_rates.name' },
            { data: 'unit_sale_price', name: 'transaction_sell_lines.unit_price_inc_tax' },
            { data: 'subtotal', name: 'subtotal', searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            $('#footer_subtotal').text(
                sum_table_col($('#product_sell_report_table'), 'row_subtotal')
            );
            $('#footer_total_sold').html(__sum_stock($('#product_sell_report_table'), 'sell_qty'));
            $('#footer_tax').html(__sum_stock($('#product_sell_report_table'), 'tax', 'left'));
            __currency_convert_recursively($('#product_sell_report_table'));
        },
    });

    product_sell_grouped_report = $('table#product_sell_grouped_report_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'desc']],
        ajax: {
            url: '/reports/product-sell-grouped-report',
            data: function(d) {
                var start = '';
                var end = '';
                if ($('#product_sr_date_filter').val()) {
                    start = $('input#product_sr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#product_sr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;

                d.variation_id = $('#variation_id').val();
                d.customer_id = $('select#customer_id').val();
                d.location_id = $('select#location_id').val();
            },
        },
        columns: [
            { data: 'product_name', name: 'p.name' },
            { data: 'transaction_date', name: 't.transaction_date' },
            { data: 'current_stock', name: 'current_stock', searchable: false, orderable: false },
            { data: 'total_qty_sold', name: 'total_qty_sold', searchable: false },
            { data: 'subtotal', name: 'subtotal', searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            $('#footer_grouped_subtotal').text(
                sum_table_col($('#product_sell_grouped_report_table'), 'row_subtotal')
            );
            $('#footer_total_grouped_sold').html(
                __sum_stock($('#product_sell_grouped_report_table'), 'sell_qty')
            );
            __currency_convert_recursively($('#product_sell_grouped_report_table'));
        },
    });

    $(
        '#product_sell_report_form #variation_id, #product_sell_report_form #location_id, #product_sell_report_form #customer_id'
    ).change(function() {
        product_sell_report.ajax.reload();
        product_sell_grouped_report.ajax.reload();
    });

    $('#product_sell_report_form #search_product').keyup(function() {
        if (
            $(this)
                .val()
                .trim() == ''
        ) {
            $('#product_sell_report_form #variation_id')
                .val('')
                .change();
        }
    });

    $(document).on('click', '.remove_from_stock_btn', function() {
        swal({
            title: LANG.sure,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(willDelete => {
            if (willDelete) {
                $.ajax({
                    method: 'GET',
                    url: $(this).data('href'),
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            stock_expiry_report_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });

    //Product lot Report
    lot_report = $('table#lot_report').DataTable({
        processing: true,
        serverSide: true,
        // aaSorting: [[3, 'desc']],

        ajax: {
            url: '/reports/lot-report',
            data: function(d) {
                d.location_id = $('#location_id').val();
                d.category_id = $('#category_id').val();
                d.sub_category_id = $('#sub_category_id').val();
                d.brand_id = $('#brand').val();
                d.unit_id = $('#unit').val();
            },
        },
        columns: [
            { data: 'sub_sku', name: 'v.sub_sku' },
            { data: 'product', name: 'products.name' },
            { data: 'lot_number', name: 'pl.lot_number' },
            { data: 'exp_date', name: 'pl.exp_date' },
            { data: 'stock', name: 'stock', searchable: false },
            { data: 'total_sold', name: 'total_sold', searchable: false },
            { data: 'total_adjusted', name: 'total_adjusted', searchable: false },
        ],

        fnDrawCallback: function(oSettings) {
            $('#footer_total_stock').html(__sum_stock($('#lot_report'), 'total_stock'));
            $('#footer_total_sold').html(__sum_stock($('#lot_report'), 'total_sold'));
            $('#footer_total_adjusted').html(__sum_stock($('#lot_report'), 'total_adjusted'));

            __currency_convert_recursively($('#lot_report'));
            __show_date_diff_for_human($('#lot_report'));
        },
    });

    if ($('table#lot_report').length == 1) {
        $('#location_id, #category_id, #sub_category_id, #unit, #brand').change(function() {
            lot_report.ajax.reload();
        });
    }

    //Purchase Payment Report
    purchase_payment_report = $('table#purchase_payment_report_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[2, 'desc']],
        ajax: {
            url: '/reports/purchase-payment-report',
            data: function(d) {
                d.supplier_id = $('select#supplier_id').val();
                d.location_id = $('select#location_id').val();
                var start = '';
                var end = '';
                if ($('input#ppr_date_filter').val()) {
                    start = $('input#ppr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#ppr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
        columns: [
            {
                orderable: false,
                searchable: false,
                data: null,
                defaultContent: '',
            },
            { data: 'payment_ref_no', name: 'payment_ref_no' },
            { data: 'paid_on', name: 'paid_on' },
            { data: 'amount', name: 'transaction_payments.amount' },
            { data: 'supplier', orderable: false, searchable: false },
            { data: 'method', name: 'method' },
            { data: 'ref_no', name: 't.ref_no' },
            { data: 'action', orderable: false, searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            var total_amount = sum_table_col($('#purchase_payment_report_table'), 'paid-amount');
            $('#footer_total_amount').text(total_amount);
            __currency_convert_recursively($('#purchase_payment_report_table'));
        },
        createdRow: function(row, data, dataIndex) {
            if (!data.transaction_id) {
                $(row)
                    .find('td:eq(0)')
                    .addClass('details-control');
            }
        },
    });

    // Array to track the ids of the details displayed rows
    var ppr_detail_rows = [];

    $('#purchase_payment_report_table tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = purchase_payment_report.row(tr);
        var idx = $.inArray(tr.attr('id'), ppr_detail_rows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            ppr_detail_rows.splice(idx, 1);
        } else {
            tr.addClass('details');

            row.child(show_child_payments(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                ppr_detail_rows.push(tr.attr('id'));
            }
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    purchase_payment_report.on('draw', function() {
        $.each(ppr_detail_rows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

    if ($('#ppr_date_filter').length == 1) {
        $('#ppr_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#ppr_date_filter span').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            purchase_payment_report.ajax.reload();
        });
        $('#ppr_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#ppr_date_filter').val('');
            purchase_payment_report.ajax.reload();
        });
    }

    $(
        '#purchase_payment_report_form #location_id, #purchase_payment_report_form #supplier_id'
    ).change(function() {
        purchase_payment_report.ajax.reload();
    });

    //Sell Payment Report
    sell_payment_report = $('table#sell_payment_report_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[2, 'desc']],
        ajax: {
            url: '/reports/sell-payment-report',
            data: function(d) {
                d.supplier_id = $('select#customer_id').val();
                d.location_id = $('select#location_id').val();

                var start = '';
                var end = '';
                if ($('input#spr_date_filter').val()) {
                    start = $('input#spr_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#spr_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
        columns: [
            {
                orderable: false,
                searchable: false,
                data: null,
                defaultContent: '',
            },
            { data: 'payment_ref_no', name: 'payment_ref_no' },
            { data: 'paid_on', name: 'paid_on' },
            { data: 'amount', name: 'transaction_payments.amount' },
            { data: 'customer', orderable: false, searchable: false },
            { data: 'method', name: 'method' },
            { data: 'invoice_no', name: 't.invoice_no' },
            { data: 'action', orderable: false, searchable: false },
        ],
        fnDrawCallback: function(oSettings) {
            var total_amount = sum_table_col($('#sell_payment_report_table'), 'paid-amount');
            $('#footer_total_amount').text(total_amount);
            __currency_convert_recursively($('#sell_payment_report_table'));
        },
        createdRow: function(row, data, dataIndex) {
            if (!data.transaction_id) {
                $(row)
                    .find('td:eq(0)')
                    .addClass('details-control');
            }
        },
    });
    // Array to track the ids of the details displayed rows
    var spr_detail_rows = [];

    $('#sell_payment_report_table tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = sell_payment_report.row(tr);
        var idx = $.inArray(tr.attr('id'), spr_detail_rows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            spr_detail_rows.splice(idx, 1);
        } else {
            tr.addClass('details');

            row.child(show_child_payments(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                spr_detail_rows.push(tr.attr('id'));
            }
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    sell_payment_report.on('draw', function() {
        $.each(spr_detail_rows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

    if ($('#spr_date_filter').length == 1) {
        $('#spr_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#spr_date_filter span').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            sell_payment_report.ajax.reload();
        });
        $('#spr_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#spr_date_filter').val('');
            sell_payment_report.ajax.reload();
        });
    }

    $('#sell_payment_report_form #location_id, #sell_payment_report_form #customer_id').change(
        function() {
            sell_payment_report.ajax.reload();
        }
    );

    //Items report
    items_report_table = $('#items_report_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/reports/items-report',
            data: function(d) {
                var purchase_start = '';
                var purchase_end = '';
                if ($('#ir_purchase_date_filter').val()) {
                    purchase_start = $('input#ir_purchase_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    purchase_end = $('input#ir_purchase_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }

                var sale_start = '';
                var sale_end = '';
                if ($('#ir_sale_date_filter').val()) {
                    sale_start = $('input#ir_sale_date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    sale_end = $('input#ir_sale_date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }

                d.purchase_start = purchase_start;
                d.purchase_end = purchase_end;

                d.sale_start = sale_start;
                d.sale_end = sale_end;

                d.supplier_id = $('select#ir_supplier_id').val();
                d.customer_id = $('select#ir_customer_id').val();
            },
        },
        columns: [
            { data: 'product_name', name: 'p.name' },
            { data: 'purchase_date', name: 'purchase.transaction_date' },
            { data: 'purchase_ref_no', name: 'purchase.ref_no' },
            { data: 'supplier', name: 'suppliers.name' },
            { data: 'purchase_price', name: 'PL.purchase_price_inc_tax' },
            { data: 'sell_date', searchable: false },
            { data: 'sale_invoice_no', name: 'sale_invoice_no' },
            { data: 'customer', searchable: false },
            { data: 'quantity', searchable: false },
            { data: 'selling_price', searchable: false },
            { data: 'subtotal', searchable: false }
        ],
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#items_report_table'));
        },
    });

    if ($('#ir_purchase_date_filter').length == 1) {
        $('#ir_purchase_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#ir_purchase_date_filter').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            items_report_table.ajax.reload();
        });
        $('#ir_purchase_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#ir_purchase_date_filter').val('');
            items_report_table.ajax.reload();
        });
    }
    if ($('#ir_sale_date_filter').length == 1) {
        $('#ir_sale_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#ir_sale_date_filter').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            items_report_table.ajax.reload();
        });
        $('#ir_sale_date_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#ir_sale_date_filter').val('');
            items_report_table.ajax.reload();
        });
    }
    $(document).on('change', '#ir_supplier_id, #ir_customer_id', function(){
        items_report_table.ajax.reload();
    });
});

function updatePurchaseSell() {
    var start = $('#purchase_sell_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('#purchase_sell_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');
    var location_id = $('#purchase_sell_location_filter').val();

    var data = { start_date: start, end_date: end, location_id: location_id };

    var loader = __fa_awesome();
    $('.total_purchase').html(loader);
    $('.purchase_due').html(loader);
    $('.total_sell').html(loader);
    $('.invoice_due').html(loader);
    $('.purchase_return_inc_tax').html(loader);
    $('.total_sell_return').html(loader);

    $.ajax({
        method: 'GET',
        url: '/reports/purchase-sell',
        dataType: 'json',
        data: data,
        success: function(data) {
            $('.total_purchase').html(
                __currency_trans_from_en(data.purchase.total_purchase_exc_tax, true)
            );
            $('.purchase_inc_tax').html(
                __currency_trans_from_en(data.purchase.total_purchase_inc_tax, true)
            );
            $('.purchase_due').html(__currency_trans_from_en(data.purchase.purchase_due, true));

            $('.total_sell').html(__currency_trans_from_en(data.sell.total_sell_exc_tax, true));
            $('.sell_inc_tax').html(__currency_trans_from_en(data.sell.total_sell_inc_tax, true));
            $('.sell_due').html(__currency_trans_from_en(data.sell.invoice_due, true));
            $('.purchase_return_inc_tax').html(
                __currency_trans_from_en(data.total_purchase_return, true)
            );
            $('.total_sell_return').html(__currency_trans_from_en(data.total_sell_return, true));

            $('.sell_minus_purchase').html(__currency_trans_from_en(data.difference.total, true));
            __highlight(data.difference.total, $('.sell_minus_purchase'));

            $('.difference_due').html(__currency_trans_from_en(data.difference.due, true));
            __highlight(data.difference.due, $('.difference_due'));

            // $('.purchase_due').html( __currency_trans_from_en(data.purchase_due, true));
        },
    });
}

function get_stock_details(rowData) {
    var div = $('<div/>')
        .addClass('loading')
        .text('Loading...');
    var location_id = $('#location_id').val();
    $.ajax({
        url: '/reports/stock-details?location_id=' + location_id,
        data: {
            product_id: rowData.DT_RowId,
        },
        dataType: 'html',
        success: function(data) {
            div.html(data).removeClass('loading');
            __currency_convert_recursively(div);
        },
    });

    return div;
}

function updateTaxReport() {
    var start = $('#tax_report_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('#tax_report_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');
    var location_id = $('#tax_report_location_filter').val();
    var data = { start_date: start, end_date: end, location_id: location_id };

    var loader = '<i class="fa fa-refresh fa-spin fa-fw margin-bottom"></i>';
    $('.input_tax').html(loader);
    $('.output_tax').html(loader);
    $('.tax_diff').html(loader);
    $.ajax({
        method: 'GET',
        url: '/reports/tax-report',
        dataType: 'json',
        data: data,
        success: function(data) {
            $('.input_tax').html(data.input_tax);
            __currency_convert_recursively($('.input_tax'));
            $('.output_tax').html(data.output_tax);
            __currency_convert_recursively($('.output_tax'));
            $('.tax_diff').html(__currency_trans_from_en(data.tax_diff, true));
            __highlight(data.tax_diff, $('.tax_diff'));
        },
    });
}

function updateStockAdjustmentReport() {
    var location_id = $('#stock_adjustment_location_filter').val();
    var start = $('#stock_adjustment_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('#stock_adjustment_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');

    var data = { start_date: start, end_date: end, location_id: location_id };

    var loader = __fa_awesome();
    $('.total_amount').html(loader);
    $('.total_recovered').html(loader);
    $('.total_normal').html(loader);
    $('.total_abnormal').html(loader);

    $.ajax({
        method: 'GET',
        url: '/reports/stock-adjustment-report',
        dataType: 'json',
        data: data,
        success: function(data) {
            $('.total_amount').html(__currency_trans_from_en(data.total_amount, true));
            $('.total_recovered').html(__currency_trans_from_en(data.total_recovered, true));
            $('.total_normal').html(__currency_trans_from_en(data.total_normal, true));
            $('.total_abnormal').html(__currency_trans_from_en(data.total_abnormal, true));
        },
    });

    stock_adjustment_table.ajax
        .url(
            '/stock-adjustments?location_id=' +
                location_id +
                '&start_date=' +
                start +
                '&end_date=' +
                end
        )
        .load();
}

function updateRegisterReport() {
    var data = {
        user_id: $('#register_user_id').val(),
        status: $('#register_status').val(),
    };
    var out = [];

    for (var key in data) {
        out.push(key + '=' + encodeURIComponent(data[key]));
    }
    url_data = out.join('&');
    register_report_table.ajax.url('/reports/register-report?' + url_data).load();
}

function updateSalesRepresentativeReport() {
    //Update total expenses and total sales
    salesRepresentativeTotalExpense();
    salesRepresentativeTotalSales();
    salesRepresentativeTotalCommission();

    //Expense and expense table refresh
    sr_expenses_report.ajax.reload();
    sr_sales_report.ajax.reload();
    sr_sales_commission_report.ajax.reload();
}

function salesRepresentativeTotalExpense() {
    var start = $('input#sr_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('input#sr_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');

    var data_expense = {
        expense_for: $('select#sr_id').val(),
        location_id: $('select#sr_business_id').val(),
        start_date: start,
        end_date: end,
    };

    $('span#sr_total_expenses').html(__fa_awesome());

    $.ajax({
        method: 'GET',
        url: '/reports/sales-representative-total-expense',
        dataType: 'json',
        data: data_expense,
        success: function(data) {
            $('span#sr_total_expenses').html(__currency_trans_from_en(data.total_expense, true));
        },
    });
}

function salesRepresentativeTotalSales() {
    var start = $('input#sr_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('input#sr_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');

    var data_expense = {
        created_by: $('select#sr_id').val(),
        location_id: $('select#sr_business_id').val(),
        start_date: start,
        end_date: end,
    };

    $('span#sr_total_sales').html(__fa_awesome());
    $('span#sr_total_sales_return').html(__fa_awesome());
    $('span#sr_total_sales_final').html(__fa_awesome());

    $.ajax({
        method: 'GET',
        url: '/reports/sales-representative-total-sell',
        dataType: 'json',
        data: data_expense,
        success: function(data) {
            $('span#sr_total_sales').html(__currency_trans_from_en(data.total_sell_exc_tax, true));
            $('span#sr_total_sales_return').html(
                __currency_trans_from_en(data.total_sell_return_exc_tax, true)
            );
            $('span#sr_total_sales_final').html(__currency_trans_from_en(data.total_sell, true));
        },
    });
}

function salesRepresentativeTotalCommission() {
    var start = $('input#sr_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('input#sr_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');

    var data_sell = {
        commission_agent: $('select#sr_id').val(),
        location_id: $('select#sr_business_id').val(),
        start_date: start,
        end_date: end,
    };

    $('span#sr_total_commission').html(__fa_awesome());
    if (data_sell.commission_agent) {
        $('div#total_commission_div').removeClass('hide');
        $.ajax({
            method: 'GET',
            url: '/reports/sales-representative-total-commission',
            dataType: 'json',
            data: data_sell,
            success: function(data) {
                var str =
                    '<div style="padding-right:15px; display: inline-block">' +
                    __currency_trans_from_en(data.total_commission, true) +
                    '</div>';
                if (data.commission_percentage != 0) {
                    str +=
                        ' <small>(' +
                        data.commission_percentage +
                        '% of ' +
                        __currency_trans_from_en(data.total_sales_with_commission) +
                        ')</small>';
                }

                $('span#sr_total_commission').html(str);
            },
        });
    } else {
        $('div#total_commission_div').addClass('hide');
    }
}

function updateProfitLoss() {
    var start = $('#profit_loss_date_filter')
        .data('daterangepicker')
        .startDate.format('YYYY-MM-DD');
    var end = $('#profit_loss_date_filter')
        .data('daterangepicker')
        .endDate.format('YYYY-MM-DD');
    var location_id = $('#profit_loss_location_filter').val();

    var data = { start_date: start, end_date: end, location_id: location_id };

    var loader = __fa_awesome();
    $(
        '.opening_stock, .total_transfer_shipping_charges, .closing_stock, .total_sell, .total_purchase, \
        .total_expense, .net_profit, .total_adjustment, .total_recovered, .total_sell_discount, \
        .total_purchase_discount, .total_purchase_return, .total_sell_return, .gross_profit'
    ).html(loader);

    $.ajax({
        method: 'GET',
        url: '/reports/profit-loss',
        dataType: 'json',
        data: data,
        success: function(data) {
            $('.opening_stock').html(__currency_trans_from_en(data.opening_stock, true));
            $('.closing_stock').html(__currency_trans_from_en(data.closing_stock, true));
            $('.total_sell').html(__currency_trans_from_en(data.total_sell, true));
            $('.total_purchase').html(__currency_trans_from_en(data.total_purchase, true));
            $('.total_expense').html(__currency_trans_from_en(data.total_expense, true));
            $('.net_profit').html(__currency_trans_from_en(data.net_profit, true));
            $('.gross_profit').html(__currency_trans_from_en(data.gross_profit, true));
            $('.total_adjustment').html(__currency_trans_from_en(data.total_adjustment, true));
            $('.total_recovered').html(__currency_trans_from_en(data.total_recovered, true));
            $('.total_purchase_return').html(
                __currency_trans_from_en(data.total_purchase_return, true)
            );
            $('.total_transfer_shipping_charges').html(
                __currency_trans_from_en(data.total_transfer_shipping_charges, true)
            );
            $('.total_purchase_discount').html(
                __currency_trans_from_en(data.total_purchase_discount, true)
            );
            $('.total_sell_discount').html(
                __currency_trans_from_en(data.total_sell_discount, true)
            );
            $('.total_sell_return').html(__currency_trans_from_en(data.total_sell_return, true));
            __highlight(data.net_profit, $('.net_profit'));
            __highlight(data.net_profit, $('.gross_profit'));
        },
    });
}

function show_child_payments(rowData) {
    var div = $('<div/>')
        .addClass('loading')
        .text('Loading...');
    $.ajax({
        url: '/payments/show-child-payments/' + rowData.DT_RowId,
        dataType: 'html',
        success: function(data) {
            div.html(data).removeClass('loading');
            __currency_convert_recursively(div);
        },
    });

    return div;
}
