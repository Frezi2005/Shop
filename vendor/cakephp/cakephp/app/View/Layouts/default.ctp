<!DOCTYPE html>
<html>
	<head>
		<?php 
			//Setting charset, loading scipts, libraries and styles
			echo $this->Html->charset();
			echo $this->Html->script("../../../components/jquery/jquery.min");
			echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@10");
			echo $this->Html->script("https://unpkg.com/@popperjs/core@2");
			echo $this->Html->script("https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js");
			echo $this->Html->css("https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css");
			echo $this->Html->script("https://kit.fontawesome.com/b7d5b9359e.js");
			echo $this->Html->css("layout");
			echo $this->Html->script("product");
			echo $this->Html->script("main");
			
			echo $this->fetch("meta");
			echo $this->fetch("css");
			echo $this->fetch("script");
		?>
	</head>
	<body>
		<div id="container">
			<nav>
				<p class="logo"><a href="home"><?= $this->Html->image("logo.png");?></a></p>
				<div class="searchBox">
					<input class="searchInput" type="search">
					<button class="searchBtn"><i class="fas fa-search"></i></button>
					<div class="searchResults">
						<div class="innerSearchResults"></div>
					</div>
				</div>
				
				<div class="links">
					<select class="languageSelect">
						<?php
							if ($this->Session->read("language") == "eng") {
								echo "<option value=\"eng\">ENG</option>";
								echo "<option value=\"pol\">POL</option>";
							} else {
								echo "<option value=\"pol\">POL</option>";
								echo "<option value=\"eng\">ENG</option>";
							}
						?>
					</select>
					<div class="logInLink navLink">
						<i class="fas fa-user"></i>
						<a href=""><?php echo ($this->Session->read("loggedIn") == true) ? "Profile" : "Log in"?></a>
						<div class="logInModal">
							<?php
								if ($this->Session->read("loggedIn") != true) {
									echo "<a href=\"login\">Log In</a>";
									echo "<hr>";
									echo "<a href=\"register\">Register</a>";
								} else {
									echo "<a href=\"profile\">Profile</a>";
									echo "<hr>";
									echo "<a href=\"settings\">Settings</a>";
								}
							?>
						</div>
					</div>
					<div class="cartLink navLink">
						<i class="fas fa-shopping-cart"></i>
						<a href="">Cart</a>
						<span id="cartProductsAmount"></span>
						<div class="cartModal"></div>
					</div>
				</div>
			</nav>
			<div id="content">
				<div class="categories col-lg-2 col-md-2">			
					<ul class="categoriesList">
						<?php 
							$index = 0;
							foreach ($categories as $category) {
								echo "<div class=\"category\">";
								echo "<li data-category-id=".$category["Category"]["id"].">".$category["Category"]["category_name"]."</li>";
								echo "<div class=\"subCategories\"></div>";
								echo "</div>";
								if ($index != count($categories) - 1) {
									echo "<hr />";
								}
								$index++;
							}
						?>
					</ul>
				</div>
				<?php echo $this->fetch("content"); ?>
			</div>
			<footer class="text-center justify-content-center">
				<p class="col-lg-12 h-20">Kamil Waniczek <?= date("Y"); ?> &copy; All rights reserved.</p>
				<div class="col-lg-10 h-80 mx-auto">
					<div class="col-lg-3 float-start">
						<ul class="footerUsefulLinks1">
							<li><span>Useful links</span></li>
							<li><a href="about-us">About us</a></li>
							<li><a href="cooperation">Cooperation</a></li>
							<li><a href="contact">Contact</a></li>
						</ul>
					</div>
					<div class="col-lg-3 float-start mt-50">
						<ul class="footerUsefulLinks2">
							<li><a href="partnership">Partnership</a></li>
							<li><a href="terms-of-service">Terms of Service</a></li>
							<li><a href="privacy-policy-and-cookies">Privacy policy & Cookies</a></li>
						</ul>
					</div>
					<div class="col-lg-6 float-start socialMediaDiv">
						<ul class="socialMedia">
							<li><a href=""><i class="fab fa-twitter"></i> - Twitter </a></li>
							<li><a href=""><i class="fab fa-facebook-f"></i> - Facebook </a></li>
							<li><a href=""><i class="fab fa-instagram"></i> - Instagram </a></li>
						</ul>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>
