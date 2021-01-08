<script>
// WC Checkout Footer Javascript
	function hide_shipping() {
	
	if (window.location.href.includes("collection") || window.location.href.includes("delivery")) {
	
	if (window.location.href.includes("delivery")) {
		console.log("Delivery");
		jQuery("#shipping_method_0_local_pickup40").parent().parent().parent().css("display", "none");	
		jQuery('#cfw-shipping-info-action a.cfw-primary-btn.cfw-next-tab').html("Continue to shipping");
		jQuery('#jckwds-fields').css("display","none");
		
		if (jQuery('#shipping_method_0_local_pickup40').is(':checked')) {
			console.log("Local Pickup is checked.");
			jQuery('#cfw-shipping-action .cfw-primary-btn.cfw-next-tab').css("display", "none");
			jQuery('#select_shipping_message').css("display", "block");
		}
		else {console.log("Else");jQuery('#cfw-shipping-action a').css("display", "block");jQuery('#select_shipping_message').css("display", "none");}
	}
	
	if (window.location.href.includes("collection")) {
		console.log("Collection");
		jQuery(".cfw-shipping-method-inner").parent().css("display", "none");
		jQuery("#shipping_method_0_local_pickup40").parent().parent().parent().css("display", "block");
		jQuery('#cfw-shipping-info h3:nth-of-type(2)').html("Billing Address");
		jQuery('#cfw-shipping-same-billing').css('display', 'none');
		jQuery('.cfw-billing-address-heading').css('display', 'none');
		jQuery('#cfw-shipping-info-action a.cfw-primary-btn.cfw-next-tab').html("Continue");
		jQuery('#jckwds-fields').css("display", "block");
		
				if (jQuery('#shipping_method_0_local_pickup40').is(':checked')) {
			console.log("Local Pickup is checked.");
			jQuery('#cfw-shipping-action .cfw-primary-btn.cfw-next-tab').css("display", "block");
			jQuery('#select_shipping_message').css("display", "none");
		}
		else {console.log("Else");jQuery('#cfw-shipping-action a').css("display", "none");jQuery('#select_shipping_message').css("display", "block");}
	}
	}
			
	else {
		console.log("Not Collection or Delivery.");
		//jQuery('input#shipping').trigger();
		if(jQuery('input#shipping').is(':checked')) {
		window.location = "https://devfireworks.temp513.kinsta.cloud/checkout?rates=delivery";
		}
		if(jQuery('input#collection').is(':checked')) 
        {
					window.location = "https://devfireworks.temp513.kinsta.cloud/checkout?rates=collection";
					
         }
	}

			/*if (jQuery('input#shipping').is(':checked'))
			jQuery('.cfw-shipping-action a').css("display", "none");
			
			jQuery('.cfw-shipping-action a').css("display", "block");*/
	}
	
	jQuery(document).ajaxComplete(function() {
		hide_shipping();
		jQuery(document).on("click touchstart", function() {hide_shipping();});
	});

jQuery('input#shipping').click(function() {

        if(jQuery('input#shipping').is(':checked')) 
        {
         //jQuery("#shipping_method_0_local_pickup40").parent().parent().parent().css("display", "none");
				 //console.log(window.location);
					window.location = "https://devfireworks.temp513.kinsta.cloud/checkout?rates=delivery";
         }
});

jQuery('input#collection').click(function(){

        if(jQuery('input#collection').is(':checked')) 
        {
					//jQuery(".cfw-shipping-method-inner").parent().css("display", "none");
					//jQuery("#shipping_method_0_local_pickup40").parent().parent().parent().css("display", "block");		
					//jQuery('#shipping_method_0_local_pickup40').click();
					//console.log("Collection");
					window.location = "https://devfireworks.temp513.kinsta.cloud/checkout?rates=collection";
					
         }

});
</script>
