<?php
 return [
"product_stock_alert" => "Productos con poco stock. <br/> <small class='text-muted'> Basado en la cantidad de alerta del producto establecida en la pantalla agregar producto. Compre este producto antes de que el stock termine. </small>",
"payment_dues" => "Pago pendiente por compras. <br/> <small class='text-muted'> Basado en el término de pago del proveedor. <br/> Mostrando pagos a ser pagados en 7 días o menos. </small>", /* modified */
"input_tax" => "Impuesto total recaudado para las ventas dentro del período de tiempo seleccionado.",
"output_tax" => "Impuesto total pagado por compras durante el período de tiempo seleccionado.",
"tax_overall" => "Diferencia entre el total de impuestos recaudados y el total de impuestos pagados dentro del período de tiempo seleccionado.",
"purchase_due" => "Importe total no pagado por compras.", /* modified */
"sell_due" => "Cantidad total que se recibirá de las ventas",
"over_all_sell_purchase" => "-ve value = Importe a pagar <br> + ve Valor = Importe a recibir",
"no_of_products_for_trending_products" => "Número de productos de tendencia superior que se compararán en el cuadro a continuación.",
"top_trending_products" => "Los productos más vendidos de su tienda. <br/> <small class='text-muted'> aplique filtros para conocer los productos en tendencia para una categoría, marca, ubicación comercial específica, etc. </small>",
"sku" => "Id único de producto o Unidad de stock de mantenimiento <br> <br> manténgalo en blanco para generar automáticamente sku. <br> <small class='text-muted'> Puede modificar el prefijo sku en Configuración de empresa . </small> ", /* modified */
"enable_stock" => "Habilitar o deshabilitar la gestión de stocks para un producto.",
"alert_quantity" => "Manténgase alerta cuando el stock del producto llegue o baje de la cantidad especificada. <br> <br> <small class='text-muted'> Los productos con poco stock se mostrarán en el panel de control - Sección de alerta de stock del producto. </small>", /* modified */
"product_type" => "<b> Producto único </ b>: Producto sin variaciones. <br> <b> Producto variable </ b>: Producto con variaciones como tamaño, color, etc.",
"profit_percent" => "Margen de beneficio predeterminado para el producto. <br> <small class='text-muted'> (<i> Puede administrar el margen de beneficio predeterminado en Configuración comercial. </i>) </small>",
"pay_term" => "Pagos pendientes por compras dentro del período de tiempo determinado. <br/> <small class='text-muted'> Todos los pagos vencidos o adeudados se mostrarán en el panel de control - Sección de pago vencido </small>", /* modified */
"order_status" => "Los productos en esta compra estarán disponibles para la venta solo si el <b> Estado del pedido </ b> es <b> Elementos recibidos </ b>.",
"purchase_location" => "Ubicación comercial donde el producto comprado estará disponible para la venta.",
"sale_location" => "Ubicación comercial desde donde desea vender",
"sale_discount" => "Establecer 'Descuento de venta predeterminado' para todas las ventas en Configuración comercial. Haga clic en el icono de editar a continuación para agregar / actualizar el descuento.",
"sale_tax" => "Establezca 'Impuesto a la venta predeterminado' para todas las ventas en Configuración comercial. Haga clic en el icono de editar a continuación para agregar / actualizar el impuesto a la orden.",
"default_profit_percent" => "Margen de beneficio predeterminado de un producto. <br> <small class='text-muted'> Se usa para calcular el precio de venta en función del precio de compra ingresado. <br/> Puede modificar este valor para productos individuales al tiempo que agrega </small> ",
"fy_start_month" => "Mes de inicio del año fiscal para su empresa", /* modified */
"business_tax" => "Número de identificación fiscal de su empresa.", /* modified */
"invoice_scheme" => "Esquema de factura significa formato de numeración de factura. Seleccione el esquema que se utilizará para esta ubicación comercial <small class='text-muted'> <i> Puede agregar un nuevo esquema de factura </ b> en configuración de factura </ i > </small> ",
"invoice_layout" => "Diseño de facturas para su ubicación comercial <small class='text-muted'> (<i> Puede agregar una nueva configuración de factura </ b> en <b> Configuración de factura <b> < /i>) </small> ",
"invoice_scheme_name" => "Dé un nombre breve y significativo al Esquema de factura",
"invoice_scheme_prefix" => "Prefijo para un esquema de factura. <br> Un prefijo puede ser un texto personalizado o un año actual. Ej .: # XXXX0001, # 2018-0002",
"invoice_scheme_start_number" => "Número de inicio para la numeración de la factura. <br> <small class='text-muted'> Puede hacer que sea 1 o cualquier otro número desde el que se inicie la numeración. </small>",
"invoice_scheme_count" => "Número total de facturas generadas para el esquema de facturación",
"invoice_scheme_total_digits" => "Longitud del número de factura excluyendo el prefijo de factura",
"tax_groups" => "Tasas impositivas grupales - definidas anteriormente, para usar en combinación en las secciones Compra / Venta.",
"unit_allow_decimal" => "Decimales le permite vender los productos relacionados en fracciones.",
"print_label" => "Agregar productos -> Elegir información para mostrar en Etiquetas -> Seleccionar configuración del código de barras -> Etiquetas de vista previa -> Imprimir",
"expense_for" => "Elija el usuario para el que está relacionado el gasto. <I> (Opcional) </i> <br/> <small> Ejemplo: salario de un empleado. </small>",
"all_location_permission" => "Si <b> Todas las ubicaciones </ b> seleccionadas, esta función tendrá permiso para acceder a todas las ubicaciones comerciales",
"dashboard_permission" => "Si no se selecciona, solo se mostrará el mensaje de bienvenida en Inicio.",
"access_locations_permission" => "Elija todas las ubicaciones a las que pueda acceder esta función. Todos los datos de la ubicación seleccionada solo se mostrarán al usuario. <br/> <br/> <small> Por ejemplo: puede usar esto para definir <i> Administrador / Cajero / Gestionar stock / Gestionar marcas, </i> de una ubicación particular. </small> ", /* modified */
"print_receipt_on_invoice" => "Habilitar o deshabilitar la impresión automática de la factura al finalizar",
"receipt_printer_type" => "<i> Impresión basada en navegador </i>: mostrar el cuadro de diálogo Imprimir en el navegador con una vista previa de la factura <br/> <br/> <i> Usar impresora de recibos configurada </i>: seleccione una impresora térmica / recibo configurada para impresión",
"adjustment_type" => "<i> Normal </i>: Ajuste por razones normales, como fugas, daños, etc. <br/> <br/> <i> Anormal </i>: ajuste por motivos como Incendio, Accidente, etc.",
"total_amount_recovered" => "Importe recuperado del seguro o venta de desechos u otros", /* modified */
"express_checkout" => "Marcar el pago en efectivo completo y pagar",
"total_card_slips" => "Número total de pagos con tarjeta usados ​​en este registro",
"total_cheques" => "Número total de cheques utilizados en este registro",
"capability_profile" => "La compatibilidad con los comandos y las páginas de códigos varía entre los proveedores de impresoras y los modelos. Si no está seguro, es una buena idea usar el perfil de capacidad simple ",
"purchase_different_currency" => "Seleccione esta opción si compra en una moneda diferente a la moneda de su empresa",
"currency_exchange_factor" => "1 Moneda de compra =? moneda base<br> <small class='text-muted'> Puede activar / desactivar 'Comprar en otra moneda' desde la configuración comercial. </small> '",
"accounting_method" => "Método de contabilidad",
"transaction_edit_days" => "Número de días desde la Fecha de transacción hasta la cual se puede editar una transacción",
"stock_expiry_alert" => "Lista de existencias con vencimiento en :days días <br> <small class ='text-muted'> Puede establecer el número de días en Configuración empresarial </small>",
];
