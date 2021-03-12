<script src="{{ asset('plugins/mousetrap/mousetrap.min.js?v=' . $asset_v) }}"></script>
<script type="text/javascript">
	$(document).ready( function() {
		//Shortcuts to go recent product quantity
		@if(!empty($shortcuts["pos"]["recent_product_quantity"]))
			shortcut_length_prev = 0;
			shortcut_position_now = null;

			Mousetrap.bind('{{$shortcuts["pos"]["recent_product_quantity"]}}', function(e, combo) {
				
				var length_now = $('table#purchase_entry_table tr').length;

				if(length_now != shortcut_length_prev){
					shortcut_length_prev = length_now;
					shortcut_position_now = length_now;
				} else {
					shortcut_position_now = shortcut_position_now - 1;
				}

				var last_qty_field = $('table#purchase_entry_table tr').eq(shortcut_position_now - 1).contents().find('input.purchase_quantity');
				if(last_qty_field.length >=1){
					last_qty_field.focus().select();
				} else {
					shortcut_position_now = length_now + 1;
					Mousetrap.trigger('{{$shortcuts["pos"]["recent_product_quantity"]}}');
				}
			});

			//On focus of quantity field go back to search when stop typing
			var timeout = null;
			$('table#purchase_entry_table').on('focus', 'input.purchase_quantity', function () {
			    var that = this;

			    $(this).on('keyup', function(e){

			    	if (timeout !== null) {
			        	clearTimeout(timeout);
			    	}

			    	var code = e.keyCode || e.which;
			    	if (code != '9') {
    					timeout = setTimeout(function () {
			        		$('input#search_product').focus().select();
			    		}, 5000);
    				}
			    });
			});
		@endif

		//shortcut to go to add new products
		@if(!empty($shortcuts["pos"]["add_new_product"]))
			Mousetrap.bind('{{$shortcuts["pos"]["add_new_product"]}}', function(e) {
				$('input#search_product').focus().select();
			});
		@endif
	});
</script>