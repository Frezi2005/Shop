<!DOCTYPE html>
<html>
<head>
	<?php 
		//Setting charset
		echo $this->Html->charset();
		//Loading jQuery
		echo $this->Html->script("../../../components/jquery/jquery.min");
		//Loading SweetAlert 2
		echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@10");
		//Loading Popper.js 2
		echo $this->Html->script("https://unpkg.com/@popperjs/core@2");
		//Loading scripts for Bootstrap 5
		echo $this->Html->script("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js");
		//Loading styles for Bootstrap 5
		echo $this->Html->css("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css");
		//Loading script for FontAwesome
		echo $this->Html->script("https://kit.fontawesome.com/b7d5b9359e.js");

		echo $this->Html->css("layout");
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<nav>
			<p class="logo">LOGO</p>
			<div class="searchBox">
				<input class="searchInput" type="search" name="" id="">
				<button class="searchBtn"><i class="fas fa-search"></i></button>
			</div>
			<div class="links">
				<div class="logInLink navLink">
					<i class="fas fa-user"></i>
					<a href="">Log in</a>
				</div>
				<div class="cartLink navLink">
					<i class="fas fa-shopping-cart"></i>
					<a href="">Cart</a>
				</div>
			</div>
		</nav>
		<div id="content">
			<ul class="categoriesList">
				<?php 
					foreach($categories as $category) {
						echo "<li>".$category["Category"]["category_name"]."</li>";
						echo "<ul class=\"subCategoriesList\">";
						foreach($subCategoriesArray[$category["Category"]["id"]] as $subCategory) {
							echo "<li>".$subCategory["SubCategory"]["sub_category_name"]."</li>";
						}
						echo "</ul>";
					}
				?>
			</ul>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			Kamil Waniczek <?= date("Y"); ?> &copy; All rights reserved.
		</div>
	</div>
</body>
</html>
