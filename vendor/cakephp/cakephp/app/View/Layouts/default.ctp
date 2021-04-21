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
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">

		</div>
	</div>
</body>
</html>
