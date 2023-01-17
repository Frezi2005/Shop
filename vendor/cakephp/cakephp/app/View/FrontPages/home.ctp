<?php
    echo $this->Html->css("home");
	echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js");
?>
<div class="boxRight col-xxl-6 col-xl-6 col-lg-5 col-10 float-end">
	<div class="slider carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner h-100">
			<div class="carousel-item active h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center"><img src="http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/slider-img-1.png"/></div>
				<span class="img-text">MSI MEG Z590 GODLIKE<br /><b><?=__("now_only");?> </b><span class="line-through"><span class="price">1150</span> <span class="currency"></span></span><b> <span class="price">1000</span> <span class="currency"></span></b></span>
			</div>
			<div class="carousel-item h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center"><img src="http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/slider-img-2.png"/></div>
				<span class="img-text">Samsung Galaxy A52s<br /><b><?=__("now_only");?> </b><span class="line-through"><span class="price">510</span> <span class="currency"></span></span><b> <span class="price">450</span> <span class="currency"></span></b></span>
			</div>
			<div class="carousel-item h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center"><img src="http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/slider-img-3.png"/></div>
				<span class="img-text">HP DesignJet T650<br /><b><?=__("now_only");?> </b><span class="line-through"><span class="price">2300</span> <span class="currency"></span></span><b> <span class="price">2000</span> <span class="currency"></span></b></span>
			</div>
		</div>
	</div>
	<div class="productsList">
		<div class="products">
			<div class="col-xxl-6 col-12 float-start">
				<a href='product?product_id=<?=$randomProducts[0]["Product"]["id"]?>' target='_self'><div class='productOnMainPage col-5'><p><?=$randomProducts[0]["Product"]["name"]?><br/><span class='price'><?=$randomProducts[0]["Product"]["price"]?>USD</span></p></div></a>
				<a href='product?product_id=<?=$randomProducts[1]["Product"]["id"]?>' target='_self'><div class='productOnMainPage col-5 ms-xxl-5 offset-xxl-0 offset-2'><p><?=$randomProducts[1]["Product"]["name"]?><br/><span class='price'><?=$randomProducts[1]["Product"]["price"]?>USD</span></p></div></a>
			</div>
			<div class="ps-xxl-4 col-12 col-xxl-6 float-start my-xxl-0 my-5">
				<a href='product?product_id=<?=$randomProducts[2]["Product"]["id"]?>' target='_self'><div class='productOnMainPage col-5'><p><?=$randomProducts[2]["Product"]["name"]?><br/><span class='price'><?=$randomProducts[2]["Product"]["price"]?>USD</span></p></div></a>
				<a href='product?product_id=<?=$randomProducts[3]["Product"]["id"]?>' target='_self'><div class='productOnMainPage col-5 ms-xxl-5 offset-xxl-0 offset-2'><p><?=$randomProducts[3]["Product"]["name"]?><br/><span class='price'><?=$randomProducts[3]["Product"]["price"]?>USD</span></p></div></a>
			</div>
		</div>
	</div>
</div>
<div class="contact offset-1 col-xxl-3 col-xl-3 col-lg-4 col-10">
	<a href="contact"><?=__("contact")?></a>
	<a href="site-map"><?=__("site_map")?></a>
</div>
<?php
	if ($this->Session->read("verified")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("account_verification_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["verified"] = false;
	} else if ($this->Session->read("loggedModal")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("login_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["loggedModal"] = false;
	} else if ($this->Session->read("registeredModal")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("register_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["registeredModal"] = false;
	} else if ($this->Session->read("changeEmailSent")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("email_sent_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["changeEmailSent"] = false;
	} else if ($this->Session->read("orderedModal")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("order_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["orderedModal"] = false;
	} else if ($this->Session->read("changePassword")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("password_change_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["changePassword"] = false;
	} else if ($this->Session->read("changedAddress")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("address_change_alert")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["changedAddress"] = false;
	} else if ($this->Session->read("orderPriceError")) {
		echo "<script>Swal.fire({icon: 'success',text: '".__("order_price_error")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["orderPriceError"] = false;
	} else if ($this->Session->read("contactEmailSent") === true) {
		echo "<script>Swal.fire({icon: \"success\",text: \"".__("message_sent_alert")."\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["contactEmailSent"] = null;
	} else if ($this->Session->read("contactEmailSent") === false) {
		echo "<script>Swal.fire({icon: \"error\",text: \"".__("message_sending_error_alert")."\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["contactEmailSent"] = null;
	} else if ($this->Session->read("accountTerminatedError") === true) {
		echo "<script>Swal.fire({icon: \"error\",text: \"Your account has been terminated!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["accountTerminatedError"] = false;
	}
?>

