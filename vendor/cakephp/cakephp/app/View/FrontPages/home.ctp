<?php 
    echo $this->Html->script("home");
    echo $this->Html->css("home");
    
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
?>
<div class="boxRight">
    <div class="slider">
        <div class="leftArrow arrow"><</div>
        <div class="rightArrow arrow">></div>
    </div>
    <div class="productsList">
        <h2>Today's Deals</h2>
        <div class="products">
            <div class="product"><p>Product</p></div>
            <div class="product"><p>Product</p></div>
            <div class="product"><p>Product</p></div>
            <div class="product"><p>Product</p></div>
        </div>
    </div>
</div>
<div class="contact"></div>

<!-- <h1>Home page</h1>
<h4><a href="register">Register Page</a></h4>
<h4><a href="login">Login Page</a></h4> -->

