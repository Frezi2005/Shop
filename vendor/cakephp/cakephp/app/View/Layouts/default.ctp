<!DOCTYPE html>
<html>
	<head>
		<?php 
			//Setting charset, loading scipts, libraries and styles
			echo $this->Html->charset();
			echo $this->Html->script("../../../components/jquery/jquery.min");
			echo $this->Html->css("../../../components/jqueryui/jquery-ui.min");
			echo $this->Html->script("../../../components/jqueryui/jquery-ui");
			echo $this->Html->script("//cdn.jsdelivr.net/npm/sweetalert2@10");
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
		<div id="rodo">
			<span>RODO</span>
			<button id="accept">Accept</button>
			<button id="denie">Denie</button>
		</div>
		<div id="container">
			<nav>
				<p class="logo"><a href="home"><?= $this->Html->image("logo.png");?></a></p>
				<div class="searchBox">
					<input class="searchInput" type="search" placeholder="Search...">
					<button class="searchBtn"><i class="fas fa-search"></i></button>
					<div class="searchResults">
						<div class="innerSearchResults"></div>
					</div>
				</div>
				
				<div class="links">
					<select class="languageSelect">
						<?php
							if ($this->Session->read("language") == "eng") {
								echo "<option value='eng'>".__("eng")."</option>";
								echo "<option value='pol'>".__("pol")."</option>";
							} else {
								echo "<option value='pol'>".__("pol")."</option>";
								echo "<option value='eng'>".__("eng")."</option>";
							}
						?>
					</select>
					<div class="logInLink navLink">
						<i class="fas fa-user"></i>
						<span><?php echo ($this->Session->read("loggedIn") == true) ? "Profile" : "Log in"?></span>
						<div class="logInModal">
							<?php
								if ($this->Session->read("loggedIn") != true) {
									echo "<a href='login'>Log In</a>";
									echo "<hr>";
									echo "<a href='register'>Register</a>";
								} else {
									echo "<a href='profile'>Profile</a>";
									echo "<hr>";
									echo "<a href='settings'>Settings</a>";
									echo "<hr>";
									echo "<a href='logout'>Logout</a>";
								}
							?>
						</div>
					</div>
					<div class="cartLink navLink">
						<span id="linkOuter">
							<i class="fas fa-shopping-cart"></i>
							<a href="cart">Cart</a>
							<span id="cartProductsAmount"></span>
						</span>
						<div class="cartModal"></div>
					</div>
				</div>
			</nav>
			<?php 
				if ($_SERVER["REDIRECT_URL"] !== "/Shop/vendor/cakephp/cakephp/app/webroot/home") {
					echo "<a id='back' href='#'><i class='fas fa-arrow-left'></i></a>";
				} 
			?>
			
			<div id="content">
				<?php
					if (strpos($_SERVER["REDIRECT_URL"], "login") === false && strpos($_SERVER["REDIRECT_URL"], "register") === false && strpos($_SERVER["REDIRECT_URL"], "contact") === false) {
						echo $this->element("side_menu");
					}
					echo $this->fetch("content");
				?>
			</div>
			<!-- <footer class="text-center justify-content-center">
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
			</footer> -->
		</div>
	</body>
</html>
