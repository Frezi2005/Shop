<?php

	echo $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js");
	echo $this->Html->script("marketing_materials")

?>
<img width="400px" id="flyer" src="../cakephp/app/webroot/img/flyer-<?=$this->Session->read("language");?>.png" alt="">
<button class="btn btn-primary">Pobierz</button>
