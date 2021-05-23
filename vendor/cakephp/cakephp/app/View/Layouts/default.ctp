<!DOCTYPE html>
<html>
	<head>
		<?php 
			//Setting charset, loading scipts, libraries and styles
			echo $this->Html->charset();
			echo $this->Html->script("../../../components/jquery/jquery.min");
			echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@10");
			echo $this->Html->script("https://unpkg.com/@popperjs/core@2");
			echo $this->Html->script("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js");
			echo $this->Html->css("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css");
			echo $this->Html->script("https://kit.fontawesome.com/b7d5b9359e.js");
			echo $this->Html->css("layout");
			echo $this->Html->script("main");
			
			echo $this->fetch("meta");
			echo $this->fetch("css");
			echo $this->fetch("script");
		?>
	</head>
	<body>
		<div id="container">
			<nav>
				<p class="logo">LOGO</p>
				<div class="searchBox">
					<input class="searchInput" type="search">
					<button class="searchBtn"><i class="fas fa-search"></i></button>
				</div>
				<select>
					<option value="eng">ENG</option>
					<option value="pol">POL</option>
				</select>
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
						foreach ($categories as $category) {
							echo "<div class=\"category\">";
							echo "<li data-category-id=".$category["Category"]["id"].">".$category["Category"]["category_name"]."</li>";
							echo "<div class=\"subCategories\"></div>";
							echo "</div>";
						}
					?>
				</ul>
				<?php echo $this->fetch("content"); ?>
			</div>
			<div id="footer">
				Kamil Waniczek <?= date("Y"); ?> &copy; All rights reserved.
			</div>
		</div>
	</body>
</html>
