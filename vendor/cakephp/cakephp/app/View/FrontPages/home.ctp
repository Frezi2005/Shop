<?php 
    echo $this->Html->css("home");
?>
<div class="boxRight">
    <div class="slider">
        <div class="sliderLeftArrow sliderArrow"><</div>
        <div class="sliderRightArrow sliderArrow">></div>
    </div>
    <div class="productsList">
        <h2><?php echo __("test");?></h2>
        <div class="products">
            <div class="productOnMainPage"><p><a href="product?product_id=639adc99-c700-11eb-a8c6-9822efb9cbff" target="_blank">Product</a></p></div>
            <div class="productOnMainPage"><p>Product</p></div>
            <div class="productOnMainPage"><p>Product</p></div>
            <div class="productOnMainPage"><p>Product</p></div>
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
}
?>

<!-- <h1>Home page</h1>
<h4><a href="register">Register Page</a></h4>
<h4><a href="login">Login Page</a></h4> -->

