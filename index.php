<?php require_once "header.php"; ?>
    	<div class="slider-wrap jcarousel">
        	<ul>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_01.png'); background-position:50% 0%; background-size:cover;"></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_02.png'); background-position:50% 0%; background-size:cover;"></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_03.png'); background-position:50% 0%; background-size:cover;"></div></li>

            </ul>
        </div>
        <div class="shirts-wrap site">
	        <?php 
				$list = array();
				for($i = 0; $i < 12; $i++){
					$item = new stdClass;
					$item->title = "Shirt Name_" . $i;
					$item->price = 50+$i;
					$item->id = $i;
					$item->img_url = "/assets/images/shirt_01.jpg";
					$item->link = "http://www.google.com";
					
					array_push($list, $item);
				}
				foreach($list as $item){ include "views/shirt-thumb.php"; }
			?>
            <div style="clear:both"></div>
        </div>
<?php require_once "footer.php"; ?>        