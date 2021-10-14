<?php

    echo $this->Html->css("cooperation");

?>

<h1>Cooperation</h1>
<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <?php echo $this->Html->image('slider-img-1.png', ["class" => "d-block w-100"]); ?>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
    <?php echo $this->Html->image('slider-img-2.jpg', ["class" => "d-block w-100"]); ?>
    </div>
    <div class="carousel-item">
    <?php echo $this->Html->image('slider-img-3.png', ["class" => "d-block w-100"]); ?>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>