<?php
//PHP Snippets used in Premium Features on WC Checkout
add_action('cfw_checkout_before_shipping_address', 'choose_checkout_shipping');

function choose_checkout_shipping() {
	echo '<h3>Delivery Method</h3>
	<div class="checkout_delivery_methods">
	<div class="radio-button-div">
	<label for="delivery">Delivery</label>
  <input type="radio" id="shipping" name="collection_or_delivery" value="delivery">
	</div>
	<div class="radio-button-div">
	<label for="collection">Collection</label>
  <input type="radio" id="collection" name="collection_or_delivery" value="collection">
	</div>
	</div>';
}

//Red Shipping Message
add_action('cfw_checkout_after_shipping_methods', 'add_shipping_message', 1);
function add_shipping_message() {
	echo '<p id="select_shipping_message" style="color: #ff0000;">Please select a shipping option from the menu above.</p>';
}
?>
