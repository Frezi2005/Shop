<?php 
    echo $this->Html->css("home");
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
			<div class="productOnMainPage">
				<p><a href="product?product_id=639adc99-c700-11eb-a8c6-9822efb9cbff" target="_blank">Product</a></p>
			</div>
			<div class="productOnMainPage">
				<p>Product</p>
			</div>
			<div class="productOnMainPage">
				<p>Product</p>
			</div>
			<div class="productOnMainPage">
				<p>Product</p>
			</div>
		</div>
	</div>
</div>
<div class="contact"></div>
<?php
if ($this->Session->read("verified") == true) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your account has been verified! You can login now.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["verified"] = false;
} else if ($this->Session->read("loggedModal") == true) {
    echo "<script>Swal.fire({icon: \"success\",text: \"You have been logged in!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["loggedModal"] = false;
} else if ($this->Session->read("loggedModal") == true) {
    echo "<script>Swal.fire({icon: \"success\",text: \"You have been logged in!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["loggedModal"] = false;
} else if ($this->Session->read("registeredModal") == true) {
    echo "<script>Swal.fire({icon: \"success\",text: \"Your account has been created!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["registeredModal"] = false;
}
?>

<!-- <h1>Home page</h1>
<h4><a href="register">Register Page</a></h4>
<h4><a href="login">Login Page</a></h4> -->

