<?php 
    echo $this->Html->css("home");
	echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js");
?>
<div class="boxRight">
	<div class="slider carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner h-100">
			<div class="carousel-item active h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center">1</div>
			</div>
			<div class="carousel-item h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center">2</div>
			</div>
			<div class="carousel-item h-100" data-bs-interval="3000">
				<div class="d-block slider-item w-100 h-100 text-center">3</div>
			</div>
		</div>
	</div>
	<div class="productsList">
		<div class="products">
			<?php
				for ($i = 0; $i < 4; $i++) {
					echo "<div class=\"productOnMainPage\"><p><a href=\"product?product_id=".$randomProducts[$i]["Product"]["id"]."\" target=\"_self\">".$randomProducts[$i]["Product"]["name"]."</a><br/><span>".$randomProducts[$i]["Product"]["price"]."USD</span></p></div>";
				}
			?>
		</div>
	</div>
</div>
<div class="contact col-lg-2 col-md-2">
	<a href="contact">Contact</a>
	<a href="site-map">Site Map</a>
</div>
<?php
if ($this->Session->read("verified")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your account has been verified! You can login now.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["verified"] = false;
} else if ($this->Session->read("loggedModal")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"You have been logged in!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["loggedModal"] = false;
} else if ($this->Session->read("registeredModal")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your account has been created!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["registeredModal"] = false;
} else if ($this->Session->read("changeEmailSent")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Email has been sent!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["changeEmailSent"] = false;
} else if ($this->Session->read("orderedModal")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Thank you for using our service! Your order will be processed soon!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["orderedModal"] = false;
} else if ($this->Session->read("changePassword")) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your password has been changed!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["changePassword"] = false;
}
?>

