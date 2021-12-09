<?php

    echo $this->Html->script("order")

?>

<span id="sum"></span>
Payment method: 
<select id="paymentMethod">
    <option value="credit-card">Credit card</option>
    <option value="bank-transfer">Bank transfer</option>
    <option value="paypal">PayPal</option>
    <option value="paysafecard">PaySafeCard</option>
    <option value="blik">BLIK</option>
</select>
Delivery type
<select id="deliveryType">
    <option value="courier">Courier</option>
    <option value="pickup-point">Pickup point</option>
    <option value="parcel-locker">Parcel locker</option>
</select>
<button id="buy">Buy</button>
