<!DOCTYPE html>
<html>
	<head>
		<?php
			//Setting charset, loading scipts, libraries and styles
			echo $this->Html->charset();
			if ($this->Session->read("language") == "eng"){
				$this->Html->script("lang_en", array("inline" => false));
			} else {
				$this->Html->script("lang_pl", array("inline" => false));
			}
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
			echo $this->Html->script("config");

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
				<p class="logo offset-1 col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 float-start"><a href="home"><?= $this->Html->image("logo.png");?></a></p>
				<div class="searchBox col-xxl-3 col-xl-3 col-lg-3 col-md-7 col-sm-6 col-7 float-start">
					<input class="searchInput" type="search" placeholder="<?=__("search")?>...">
					<button class="searchBtn"><i class="fas fa-search"></i></button>
					<div class="searchResults">
						<div class="innerSearchResults"></div>
					</div>
				</div>
				<div class="links col-xxl-5 col-xl-5 col-lg-5 col-md-1 col-sm-1 float-start">
					<p class="menu float-end">
						<i class="fas fa-bars"></i>
					</p>
					<div class="hoverMenu">
						<p class="close">
							X
						</p>
						<div class="logInLink navLink float-start col-3">
							<i class="fas fa-user"></i>
							<span><?php echo ($this->Session->read("loggedIn") == true) ? "<a href='profile'>".__("profile")."</a>" : "<a href='login'>".__("log_in")."</a>"?></span>
							<div class="logInModal">
								<?php
								if ($this->Session->read("loggedIn") != true) {
									echo "<a href='register'>".__("register")."</a>";
								} else {
									echo "<a href='settings'>".__("settings")."</a>";
									echo "<hr>";
									echo "<a href='logout'>".__("logout")."</a>";
								}
								?>
							</div>
						</div>
						<div class="cartLink navLink float-start col-3">
							<span id="linkOuter">
								<a href="cart">
									<i class="fas fa-shopping-cart"></i>
									<?=__("cart")?>
									<span id="cartProductsAmount"></span>
								</a>
							</span>
							<div class="cartModal"></div>
						</div>
						<div class="select float-start col-3">
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
						</div>
						<div class="select float-start col-3">
							<select class="currencySelect">
								<option value="USD">USD</option>
								<option value="PLN">PLN</option>
								<option value="EUR">EUR</option>
							</select>
						</div>
					</div>
				</div>
			</nav>
			<?php
				preg_match("/(?<!\/ )[^\/]+$/", $_SERVER["REDIRECT_URL"], $matches);

				if ($_SERVER["REDIRECT_URL"] !== "/Shop/vendor/cakephp/cakephp/app/webroot/home" && $matches !== "order") {
					echo "<a id='back' href='#'><i class='fas fa-arrow-left'></i></a>";
				}
			?>

			<div id="content" class="col-12">
				<?php

					$sites = [
						"login",
						"register",
						"contact",
						"ask-for-account",
						"admin-panel",
						"settings",
						"add-product-to-database",
						"change-email-form",
						"change-address-form",
						"order-history",
						"orders-report",
						"update-employee-page",
						"forgot-password-page",
						"privacy-policy-and-cookies-eng",
						"privacy-policy-and-cookies-pol",
						"terms-of-service-eng",
						"terms-of-service-pol",
						"remove-employee-page",
						"delivery-form",
						"remove-products-form",
						"update-image-form",
						"edit-product-form",
						"profile",
						"gifts-catalog",
						"change-password-form",
						"update-password-page",
						"regulations-of-loyalty-program-pol",
						"regulations-of-loyalty-program-eng"
					];
					$display = true;

					for($i = 0; $i < count($sites); $i++) {
						preg_match("/(?<!\/ )[^\/]+$/", $_SERVER["REDIRECT_URL"], $matches);
						if($matches[0] == $sites[$i]) {
							$display = false;
							break;
						}
					}

					if ($display) {
						echo $this->element("side_menu");
					}
					echo $this->fetch("content");
				?>
			</div>
			<footer class="text-center justify-content-center">
				<p class="col-lg-12 h-20">Kamil Waniczek <?= date("Y"); ?> &copy; <?=__("all_rights_reserved")?> <a href="privacy-policy-and-cookies-<?=$this->Session->read("language")?>"><?=__("privacy_policy")?></a>&nbsp;<a href="terms-of-service-<?=$this->Session->read("language")?>"><?=__("terms_of_service")?></a></p>
				<!-- <div class="col-lg-10 h-80 mx-auto">
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
				</div> -->
			</footer>
		</div>
	</body>
</html>
