@inject('request', 'Illuminate\Http\Request')

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p> -->
          <!-- Status -->
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->

      <!-- search form (Optional) -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">

        <!-- Call superadmin module if defined -->
        @if(Module::has('Superadmin'))
          @includeIf('superadmin::layouts.partials.sidebar')
        @endif

        <!-- Call ecommerce module if defined -->
        @if(Module::has('Ecommerce'))
          @includeIf('ecommerce::layouts.partials.sidebar')
        @endif
        <!-- <li class="header">HEADER</li> -->
        <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
          <a href="{{action('HomeController@index')}}">
            <i class="fa fa-dashboard"></i> <span>
            @lang('home.home')</span>
          </a>
        </li>
        @if(auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view'))
        <li class="treeview {{ in_array($request->segment(1), ['roles', 'users', 'sales-commission-agents']) ? 'active active-sub' : '' }}">
            <a href="#">
                <i class="fa fa-users"></i>
                <span class="title">@lang('user.user_management')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              @can( 'user.view' )
                <li class="{{ $request->segment(1) == 'users' ? 'active active-sub' : '' }}">
                  <a href="{{action('ManageUserController@index')}}">
                      <i class="fa fa-user"></i>
                      <span class="title">
                          @lang('user.users')
                      </span>
                  </a>
                </li>
              @endcan
              @can('roles.view')
                <li class="{{ $request->segment(1) == 'roles' ? 'active active-sub' : '' }}">
                  <a href="{{action('RoleController@index')}}">
                      <i class="fa fa-briefcase"></i>
                      <span class="title">
                        @lang('user.roles')
                      </span>
                  </a>
                </li>
              @endcan
              @can('user.create')
                <li class="{{ $request->segment(1) == 'sales-commission-agents' ? 'active active-sub' : '' }}">
                  <a href="{{action('SalesCommissionAgentController@index')}}">
                      <i class="fa fa-handshake-o"></i>
                      <span class="title">
                        @lang('lang_v1.sales_commission_agents')
                      </span>
                  </a>
                </li>
              @endcan
            </ul>
        </li>
        @endif
        @if(auth()->user()->can('supplier.view') || auth()->user()->can('customer.view') )
          <li class="treeview {{ in_array($request->segment(1), ['contacts', 'customer-group']) ? 'active active-sub' : '' }}" id="tour_step4">
            <a href="#" id="tour_step4_menu"><i class="fa fa-address-book"></i> <span>@lang('contact.contacts')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('supplier.view')
                <li class="{{ $request->input('type') == 'supplier' ? 'active' : '' }}"><a href="{{action('ContactController@index', ['type' => 'supplier'])}}"><i class="fa fa-star"></i> @lang('report.supplier')</a></li>
              @endcan

              @can('customer.view')
                <li class="{{ $request->input('type') == 'customer' ? 'active' : '' }}"><a href="{{action('ContactController@index', ['type' => 'customer'])}}"><i class="fa fa-star"></i> @lang('report.customer')</a></li>

                <li class="{{ $request->segment(1) == 'customer-group' ? 'active' : '' }}"><a href="{{action('CustomerGroupController@index')}}"><i class="fa fa-users"></i> @lang('lang_v1.customer_groups')</a></li>
              @endcan

              @if(auth()->user()->can('supplier.create') || auth()->user()->can('customer.create') )
                <li class="{{ $request->segment(1) == 'contacts' && $request->segment(2) == 'import' ? 'active' : '' }}"><a href="{{action('ContactController@getImportContacts')}}"><i class="fa fa-download"></i> @lang('lang_v1.import_contacts')</a></li>
              @endcan

            </ul>
          </li>
        @endif

        @if(auth()->user()->can('product.view') || 
        auth()->user()->can('product.create') || 
        auth()->user()->can('brand.view') ||
        auth()->user()->can('unit.view') ||
        auth()->user()->can('category.view') ||
        auth()->user()->can('brand.create') ||
        auth()->user()->can('unit.create') ||
        auth()->user()->can('category.create') )
          <li class="treeview {{ in_array($request->segment(1), ['variation-templates', 'products', 'labels', 'import-products', 'import-opening-stock', 'selling-price-group', 'brands', 'units', 'categories']) ? 'active active-sub' : '' }}" id="tour_step5">
            <a href="#" id="tour_step5_menu"><i class="fa fa-cubes"></i> <span>@lang('sale.products')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('product.view')
                <li class="{{ $request->segment(1) == 'products' && $request->segment(2) == '' ? 'active' : '' }}"><a href="{{action('ProductController@index')}}"><i class="fa fa-list"></i>@lang('lang_v1.list_products')</a></li>
              @endcan
              @can('product.create')
                <li class="{{ $request->segment(1) == 'products' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('ProductController@create')}}"><i class="fa fa-plus-circle"></i>@lang('product.add_product')</a></li>
              @endcan
              @can('product.view')
                <li class="{{ $request->segment(1) == 'labels' && $request->segment(2) == 'show' ? 'active' : '' }}"><a href="{{action('LabelsController@show')}}"><i class="fa fa-barcode"></i>@lang('barcode.print_labels')</a></li>
              @endcan
              @can('product.create')
                <li class="{{ $request->segment(1) == 'variation-templates' ? 'active' : '' }}"><a href="{{action('VariationTemplateController@index')}}"><i class="fa fa-circle-o"></i><span>@lang('product.variations')</span></a></li>
              @endcan
              @can('product.create')
                <li class="{{ $request->segment(1) == 'import-products' ? 'active' : '' }}"><a href="{{action('ImportProductsController@index')}}"><i class="fa fa-download"></i><span>@lang('product.import_products')</span></a></li>
              @endcan
              @can('product.opening_stock')
                <li class="{{ $request->segment(1) == 'import-opening-stock' ? 'active' : '' }}"><a href="{{action('ImportOpeningStockController@index')}}"><i class="fa fa-download"></i><span>@lang('lang_v1.import_opening_stock')</span></a></li>
              @endcan
              @can('product.create')
                <li class="{{ $request->segment(1) == 'selling-price-group' ? 'active' : '' }}"><a href="{{action('SellingPriceGroupController@index')}}"><i class="fa fa-circle-o"></i><span>@lang('lang_v1.selling_price_group')</span></a></li>
              @endcan
              
              @if(auth()->user()->can('unit.view') || auth()->user()->can('unit.create'))
                <li class="{{ $request->segment(1) == 'units' ? 'active' : '' }}">
                  <a href="{{action('UnitController@index')}}"><i class="fa fa-balance-scale"></i> <span>@lang('unit.units')</span></a>
                </li>
              @endif

              @if(auth()->user()->can('category.view') || auth()->user()->can('category.create'))
                <li class="{{ $request->segment(1) == 'categories' ? 'active' : '' }}">
                  <a href="{{action('CategoryController@index')}}"><i class="fa fa-tags"></i> <span>@lang('category.categories') </span></a>
                </li>
              @endif

              @if(auth()->user()->can('brand.view') || auth()->user()->can('brand.create'))
                <li class="{{ $request->segment(1) == 'brands' ? 'active' : '' }}">
                  <a href="{{action('BrandController@index')}}"><i class="fa fa-diamond"></i> <span>@lang('brand.brands')</span></a>
                </li>
              @endif
            </ul>
          </li>
        @endif
        @if(auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create') || auth()->user()->can('purchase.update') )
        <li class="treeview {{in_array($request->segment(1), ['purchases', 'purchase-return']) ? 'active active-sub' : '' }}" id="tour_step6">
          <a href="#" id="tour_step6_menu"><i class="fa fa-arrow-circle-down"></i> <span>@lang('purchase.purchases')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('purchase.view')
              <li class="{{ $request->segment(1) == 'purchases' && $request->segment(2) == null ? 'active' : '' }}"><a href="{{action('PurchaseController@index')}}"><i class="fa fa-list"></i>@lang('purchase.list_purchase')</a></li>
            @endcan
            @can('purchase.create')
              <li class="{{ $request->segment(1) == 'purchases' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('PurchaseController@create')}}"><i class="fa fa-plus-circle"></i> @lang('purchase.add_purchase')</a></li>
            @endcan
            @can('purchase.update')
              <li class="{{ $request->segment(1) == 'purchase-return' ? 'active' : '' }}"><a href="{{action('PurchaseReturnController@index')}}"><i class="fa fa-undo"></i> @lang('lang_v1.list_purchase_return')</a></li>
            @endcan
          </ul>
        </li>
        @endif

        @if(auth()->user()->can('sell.view') || auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access') )
          <li class="treeview {{  in_array( $request->segment(1), ['sells', 'pos', 'sell-return', 'ecommerce', 'discount']) ? 'active active-sub' : '' }}" id="tour_step7">
            <a href="#" id="tour_step7_menu"><i class="fa fa-arrow-circle-up"></i> <span>@lang('sale.sale')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('direct_sell.access')
                <li class="{{ $request->segment(1) == 'sells' && $request->segment(2) == null ? 'active' : '' }}" ><a href="{{action('SellController@index')}}"><i class="fa fa-list"></i>@lang('lang_v1.all_sales')</a></li>
              @endcan
              <!-- Call superadmin module if defined -->
              @if(Module::has('Ecommerce'))
                @includeIf('ecommerce::layouts.partials.sell_sidebar')
              @endif
              @can('direct_sell.access')
                <li class="{{ $request->segment(1) == 'sells' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('SellController@create')}}"><i class="fa fa-plus-circle"></i>@lang('sale.add_sale')</a></li>
              @endcan
              @can('sell.view')
                <li class="{{ $request->segment(1) == 'pos' && $request->segment(2) == null ? 'active' : '' }}" ><a href="{{action('SellPosController@index')}}"><i class="fa fa-list"></i>@lang('sale.list_pos')</a></li>
              @endcan
              @can('sell.create')
                <li class="{{ $request->segment(1) == 'pos' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('SellPosController@create')}}"><i class="fa fa-plus-circle"></i>@lang('sale.pos_sale')</a></li>
                <li class="{{ $request->segment(1) == 'sells' && $request->segment(2) == 'drafts' ? 'active' : '' }}" ><a href="{{action('SellController@getDrafts')}}"><i class="fa fa-pencil-square" aria-hidden="true"></i>@lang('lang_v1.list_drafts')</a></li>

                <li class="{{ $request->segment(1) == 'sells' && $request->segment(2) == 'quotations' ? 'active' : '' }}" ><a href="{{action('SellController@getQuotations')}}"><i class="fa fa-pencil-square" aria-hidden="true"></i>@lang('lang_v1.list_quotations')</a></li>
              @endcan
              @can('sell.view')
                <li class="{{ $request->segment(1) == 'sell-return' && $request->segment(2) == null ? 'active' : '' }}" ><a href="{{action('SellReturnController@index')}}"><i class="fa fa-undo"></i>@lang('lang_v1.list_sell_return')</a></li>
              @endcan
              
              @can('discount.access')
                <li class="{{ $request->segment(1) == 'discount' ? 'active' : '' }}" ><a href="{{action('DiscountController@index')}}"><i class="fa fa-percent"></i>@lang('lang_v1.discounts')</a></li>
              @endcan
              
              @if(in_array('subscription', $enabled_modules))
                <li class="{{ $request->segment(1) == 'subscriptions'? 'active' : '' }}" ><a href="{{action('SellPosController@listSubscriptions')}}"><i class="fa fa-recycle"></i>@lang('lang_v1.subscriptions')</a></li>
              @endif
            </ul>
          </li>
        @endif

        @if(Module::has('Repair'))
          @includeIf('repair::layouts.partials.sidebar')
        @endif

        @if(auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create') )
        <li class="treeview {{ $request->segment(1) == 'stock-transfers' ? 'active active-sub' : '' }}">
          <a href="#"><i class="fa fa-truck" aria-hidden="true"></i> <span>@lang('lang_v1.stock_transfers')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('purchase.view')
              <li class="{{ $request->segment(1) == 'stock-transfers' && $request->segment(2) == null ? 'active' : '' }}"><a href="{{action('StockTransferController@index')}}"><i class="fa fa-list"></i>@lang('lang_v1.list_stock_transfers')</a></li>
            @endcan
            @can('purchase.create')
              <li class="{{ $request->segment(1) == 'stock-transfers' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('StockTransferController@create')}}"><i class="fa fa-plus-circle"></i>@lang('lang_v1.add_stock_transfer')</a></li>
            @endcan
          </ul>
        </li>
        @endif

        @if(auth()->user()->can('purchase.view') || auth()->user()->can('purchase.create') )
        <li class="treeview {{ $request->segment(1) == 'stock-adjustments' ? 'active active-sub' : '' }}">
          <a href="#"><i class="fa fa-database" aria-hidden="true"></i> <span>@lang('stock_adjustment.stock_adjustment')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('purchase.view')
              <li class="{{ $request->segment(1) == 'stock-adjustments' && $request->segment(2) == null ? 'active' : '' }}"><a href="{{action('StockAdjustmentController@index')}}"><i class="fa fa-list"></i>@lang('stock_adjustment.list')</a></li>
            @endcan
            @can('purchase.create')
              <li class="{{ $request->segment(1) == 'stock-adjustments' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('StockAdjustmentController@create')}}"><i class="fa fa-plus-circle"></i>@lang('stock_adjustment.add')</a></li>
            @endcan
          </ul>
        </li>
        @endif

        @if(auth()->user()->can('expense.access'))
        <li class="treeview {{  in_array( $request->segment(1), ['expense-categories', 'expenses']) ? 'active active-sub' : '' }}">
          <a href="#"><i class="fa fa-minus-circle"></i> <span>@lang('expense.expenses')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $request->segment(1) == 'expenses' && empty($request->segment(2)) ? 'active' : '' }}"><a href="{{action('ExpenseController@index')}}"><i class="fa fa-list"></i>@lang('lang_v1.list_expenses')</a></li>
            <li class="{{ $request->segment(1) == 'expenses' && $request->segment(2) == 'create' ? 'active' : '' }}"><a href="{{action('ExpenseController@create')}}"><i class="fa fa-plus-circle"></i>@lang('messages.add') @lang('expense.expenses')</a></li>
            <li class="{{ $request->segment(1) == 'expense-categories' ? 'active' : '' }}"><a href="{{action('ExpenseCategoryController@index')}}"><i class="fa fa-circle-o"></i>@lang('expense.expense_categories')</a></li>
          </ul>
        </li>
        @endif

        @can('account.access')
          @if(in_array('account', $enabled_modules))
            <li class="treeview {{ $request->segment(1) == 'account' ? 'active active-sub' : '' }}">
              <a href="#"><i class="fa fa-money" aria-hidden="true"></i> <span>@lang('lang_v1.payment_accounts')</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  <li class="{{ $request->segment(1) == 'account' && $request->segment(2) == 'account' ? 'active' : '' }}"><a href="{{action('AccountController@index')}}"><i class="fa fa-list"></i>@lang('account.list_accounts')</a></li>

                  <li class="{{ $request->segment(1) == 'account' && $request->segment(2) == 'balance-sheet' ? 'active' : '' }}"><a href="{{action('AccountReportsController@balanceSheet')}}"><i class="fa fa-book"></i>@lang('account.balance_sheet')</a></li>

                  <li class="{{ $request->segment(1) == 'account' && $request->segment(2) == 'trial-balance' ? 'active' : '' }}"><a href="{{action('AccountReportsController@trialBalance')}}"><i class="fa fa-balance-scale"></i>@lang('account.trial_balance')</a></li>

                  <li class="{{ $request->segment(1) == 'account' && $request->segment(2) == 'cash-flow' ? 'active' : '' }}"><a href="{{action('AccountController@cashFlow')}}"><i class="fa fa-exchange"></i>@lang('lang_v1.cash_flow')</a></li>

                  <li class="{{ $request->segment(1) == 'account' && $request->segment(2) == 'payment-account-report' ? 'active' : '' }}"><a href="{{action('AccountReportsController@paymentAccountReport')}}"><i class="fa fa-file-text-o"></i>@lang('account.payment_account_report')</a></li>
              </ul>
            </li>
          @endif
        @endcan

        @if(auth()->user()->can('purchase_n_sell_report.view') 
          || auth()->user()->can('contacts_report.view') 
          || auth()->user()->can('stock_report.view') 
          || auth()->user()->can('tax_report.view') 
          || auth()->user()->can('trending_product_report.view') 
          || auth()->user()->can('sales_representative.view') 
          || auth()->user()->can('register_report.view')
          || auth()->user()->can('expense_report.view')
          )

          <li class="treeview {{  in_array( $request->segment(1), ['reports']) ? 'active active-sub' : '' }}" id="tour_step8">
            <a href="#" id="tour_step8_menu"><i class="fa fa-bar-chart-o"></i> <span>@lang('report.reports')</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('profit_loss_report.view')
                <li class="{{ $request->segment(2) == 'profit-loss' ? 'active' : '' }}" ><a href="{{action('ReportController@getProfitLoss')}}"><i class="fa fa-money"></i>@lang('report.profit_loss')</a></li>
              @endcan

              @can('purchase_n_sell_report.view')
                <li class="{{ $request->segment(2) == 'purchase-sell' ? 'active' : '' }}" ><a href="{{action('ReportController@getPurchaseSell')}}"><i class="fa fa-exchange"></i>@lang('report.purchase_sell_report')</a></li>
              @endcan

              @can('tax_report.view')
                <li class="{{ $request->segment(2) == 'tax-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getTaxReport')}}"><i class="fa fa-tumblr" aria-hidden="true"></i>@lang('report.tax_report')</a></li>
              @endcan

              @can('contacts_report.view')
                <li class="{{ $request->segment(2) == 'customer-supplier' ? 'active' : '' }}" ><a href="{{action('ReportController@getCustomerSuppliers')}}"><i class="fa fa-address-book"></i>@lang('report.contacts')</a></li>

                <li class="{{ $request->segment(2) == 'customer-group' ? 'active' : '' }}" ><a href="{{action('ReportController@getCustomerGroup')}}"><i class="fa fa-users"></i>@lang('lang_v1.customer_groups_report')</a></li>
              @endcan
              
              @can('stock_report.view')
                <li class="{{ $request->segment(2) == 'stock-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getStockReport')}}"><i class="fa fa-hourglass-half" aria-hidden="true"></i>@lang('report.stock_report')</a></li>
              @endcan

              @can('stock_report.view')
                @if(session('business.enable_product_expiry') == 1)
                <li class="{{ $request->segment(2) == 'stock-expiry' ? 'active' : '' }}" ><a href="{{action('ReportController@getStockExpiryReport')}}"><i class="fa fa-calendar-times-o"></i>@lang('report.stock_expiry_report')</a></li>
                @endif
              @endcan

              @can('stock_report.view')
                <li class="{{ $request->segment(2) == 'lot-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getLotReport')}}"><i class="fa fa-hourglass-half" aria-hidden="true"></i>@lang('lang_v1.lot_report')</a></li>
              @endcan

              @can('trending_product_report.view')
                <li class="{{ $request->segment(2) == 'trending-products' ? 'active' : '' }}" ><a href="{{action('ReportController@getTrendingProducts')}}"><i class="fa fa-line-chart" aria-hidden="true"></i>@lang('report.trending_products')</a></li>
              @endcan

              @can('stock_report.view')
                <li class="{{ $request->segment(2) == 'stock-adjustment-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getStockAdjustmentReport')}}"><i class="fa fa-sliders"></i>@lang('report.stock_adjustment_report')</a></li>
              @endcan

              @can('purchase_n_sell_report.view')

                <li class="{{ $request->segment(2) == 'items-report' ? 'active' : '' }}" ><a href="{{action('ReportController@itemsReport')}}"><i class="fa fa-tasks"></i>@lang('lang_v1.items_report')</a></li>

                <li class="{{ $request->segment(2) == 'product-purchase-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getproductPurchaseReport')}}"><i class="fa fa-arrow-circle-down"></i>@lang('lang_v1.product_purchase_report')</a></li>

                <li class="{{ $request->segment(2) == 'product-sell-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getproductSellReport')}}"><i class="fa fa-arrow-circle-up"></i>@lang('lang_v1.product_sell_report')</a></li>

                <li class="{{ $request->segment(2) == 'purchase-payment-report' ? 'active' : '' }}" ><a href="{{action('ReportController@purchasePaymentReport')}}"><i class="fa fa-money"></i>@lang('lang_v1.purchase_payment_report')</a></li>

                <li class="{{ $request->segment(2) == 'sell-payment-report' ? 'active' : '' }}" ><a href="{{action('ReportController@sellPaymentReport')}}"><i class="fa fa-money"></i>@lang('lang_v1.sell_payment_report')</a></li>
              @endcan

              @can('expense_report.view')
                <li class="{{ $request->segment(2) == 'expense-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getExpenseReport')}}"><i class="fa fa-search-minus" aria-hidden="true"></i></i>@lang('report.expense_report')</a></li>
              @endcan

              @can('register_report.view')
                <li class="{{ $request->segment(2) == 'register-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getRegisterReport')}}"><i class="fa fa-briefcase"></i>@lang('report.register_report')</a></li>
              @endcan

              @can('sales_representative.view')
                <li class="{{ $request->segment(2) == 'sales-representative-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getSalesRepresentativeReport')}}"><i class="fa fa-user" aria-hidden="true"></i>@lang('report.sales_representative')</a></li>
              @endcan

              @if(in_array('tables', $enabled_modules))
                @can('purchase_n_sell_report.view')
                  <li class="{{ $request->segment(2) == 'table-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getTableReport')}}"><i class="fa fa-table"></i>@lang('restaurant.table_report')</a></li>
                @endcan
              @endif
              @if(in_array('service_staff', $enabled_modules))
                @can('sales_representative.view')
                <li class="{{ $request->segment(2) == 'service-staff-report' ? 'active' : '' }}" ><a href="{{action('ReportController@getServiceStaffReport')}}"><i class="fa fa-user-secret"></i>@lang('restaurant.service_staff_report')</a></li>
                @endcan
              @endif

            </ul>
          </li>
        @endif

        @can('backup')
          <li class="treeview {{  in_array( $request->segment(1), ['backup']) ? 'active active-sub' : '' }}">
              <a href="{{action('BackUpController@index')}}"><i class="fa fa-dropbox"></i> <span>@lang('lang_v1.backup')</span>
              </a>
          </li>
        @endrole

        <!-- Call restaurant module if defined -->
        @if(in_array('tables', $enabled_modules) && in_array('service_staff', $enabled_modules) )
          @if(auth()->user()->can('crud_all_bookings') || auth()->user()->can('crud_own_bookings') )
          <li class="treeview {{ $request->segment(1) == 'bookings'? 'active active-sub' : '' }}">
              <a href="{{action('Restaurant\BookingController@index')}}"><i class="fa fa-calendar-check-o"></i> <span>@lang('restaurant.bookings')</span></a>
          </li>
          @endif
        @endif

        @if(in_array('kitchen', $enabled_modules))
          <li class="treeview {{ $request->segment(1) == 'modules' && $request->segment(2) == 'kitchen' ? 'active active-sub' : '' }}">
              <a href="{{action('Restaurant\KitchenController@index')}}"><i class="fa fa-fire"></i> <span>@lang('restaurant.kitchen')</span></a>
          </li>
        @endif
        @if(in_array('service_staff', $enabled_modules))
          <li class="treeview {{ $request->segment(1) == 'modules' && $request->segment(2) == 'orders' ? 'active active-sub' : '' }}">
              <a href="{{action('Restaurant\OrderController@index')}}"><i class="fa fa-list-alt"></i> <span>@lang('restaurant.orders')</span></a>
          </li>
        @endif

        @can('send_notifications')
          <li class="treeview {{  $request->segment(1) == 'notification-templates' ? 'active active-sub' : '' }}">
              <a href="{{action('NotificationTemplateController@index')}}"><i class="fa fa-envelope"></i> <span>@lang('lang_v1.notification_templates')</span>
              </a>
          </li>
        @endrole
        
        @if(auth()->user()->can('business_settings.access') || 
        auth()->user()->can('barcode_settings.access') ||
        auth()->user()->can('invoice_settings.access') ||
        auth()->user()->can('tax_rate.view') ||
        auth()->user()->can('tax_rate.create'))
        
        
        <li class="treeview @if( in_array($request->segment(1), ['business', 'tax-rates', 'barcodes', 'invoice-schemes', 'business-location', 'invoice-layouts', 'printers', 'subscription']) || in_array($request->segment(2), ['tables', 'modifiers']) ) {{'active active-sub'}} @endif">
        
          <a href="#" id="tour_step2_menu"><i class="fa fa-cog"></i> <span>@lang('business.settings')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" id="tour_step3">
            @can('business_settings.access')
              <li class="{{ $request->segment(1) == 'business' ? 'active' : '' }}">
                <a href="{{action('BusinessController@getBusinessSettings')}}" id="tour_step2"><i class="fa fa-cogs"></i> @lang('business.business_settings')</a>
              </li>
              <li class="{{ $request->segment(1) == 'business-location' ? 'active' : '' }}" >
                <a href="{{action('BusinessLocationController@index')}}"><i class="fa fa-map-marker"></i> @lang('business.business_locations')</a>
              </li>
            @endcan
            @can('invoice_settings.access')
              <li class="@if( in_array($request->segment(1), ['invoice-schemes', 'invoice-layouts']) ) {{'active'}} @endif">
                <a href="{{action('InvoiceSchemeController@index')}}"><i class="fa fa-file"></i> <span>@lang('invoice.invoice_settings')</span></a>
              </li>
            @endcan
            
            @can('barcode_settings.access')
            <li class="{{ $request->segment(1) == 'barcodes' ? 'active' : '' }}">
              <a href="{{action('BarcodeController@index')}}"><i class="fa fa-barcode"></i> <span>@lang('barcode.barcode_settings')</span></a>
            </li>
            @endcan

            <li class="{{ $request->segment(1) == 'printers' ? 'active' : '' }}">
              <a href="{{action('PrinterController@index')}}"><i class="fa fa-share-alt"></i> <span>@lang('printer.receipt_printers')</span></a>
            </li>

            @if(auth()->user()->can('tax_rate.view') || auth()->user()->can('tax_rate.create'))
              <li class="{{ $request->segment(1) == 'tax-rates' ? 'active' : '' }}">
                <a href="{{action('TaxRateController@index')}}"><i class="fa fa-bolt"></i> <span>@lang('tax_rate.tax_rates')</span></a>
              </li>
            @endif

            @if(in_array('tables', $enabled_modules))
               @can('business_settings.access')
                <li class="{{ $request->segment(1) == 'modules' && $request->segment(2) == 'tables' ? 'active' : '' }}">
                  <a href="{{action('Restaurant\TableController@index')}}"><i class="fa fa-table"></i> @lang('restaurant.tables')</a>
                </li>
              @endcan
            @endif

            @if(in_array('modifiers', $enabled_modules))
              @if(auth()->user()->can('product.view') || auth()->user()->can('product.create') )
                <li class="{{ $request->segment(1) == 'modules' && $request->segment(2) == 'modifiers' ? 'active' : '' }}">
                  <a href="{{action('Restaurant\ModifierSetsController@index')}}"><i class="fa fa-delicious"></i> @lang('restaurant.modifiers')</a>
                </li>
              @endif
            @endif

            @if(Module::has('Superadmin'))
              @includeIf('superadmin::layouts.partials.subscription')
            @endif

          </ul>
        </li>
        @endif
        <!-- call Essentials module if defined -->
        @if(Module::has('Essentials'))
          @includeIf('essentials::layouts.partials.sidebar_hrm')
          @includeIf('essentials::layouts.partials.sidebar')
        @endif
        
        @if(Module::has('Woocommerce'))
          @includeIf('woocommerce::layouts.partials.sidebar')
        @endif
      </ul>

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>