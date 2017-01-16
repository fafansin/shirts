<?php require_once "lib/config.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title>Grilled Cheese</title>
    <script type="text/javascript" src="assets/js/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="assets/js/main-script.js"></script>
    
    <!--
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:600px)" href="assets/css/style-mob.css"/>
    -->
    <link rel="stylesheet" type="text/css" href="assets/css/main-style.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:600px)" href="assets/css/style-tab.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:786px)" href="assets/css/style-desk.css"/>
    
    
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
	?>
</head>

<body>
	<header><?php include_once 'views/header.php'; ?></header>
    <main>
    	<div class="slider-wrap jcarousel">
        	<ul>
            	<!--
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_01.png');"><img src="assets/images/wide/wide_01.png"/></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_02.png');"><img src="assets/images/wide/wide_02.png"/></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_03.png');"><img src="assets/images/wide/wide_03.png"/></div></li>
                -->
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_01.png'); background-position:50% 0%; background-size:cover;"></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_02.png'); background-position:50% 0%; background-size:cover;"></div></li>
                <li><div class="slider-item" style="background:url('assets/images/wide/wide_03.png'); background-position:50% 0%; background-size:cover;"></div></li>

            </ul>
        </div>
        <div class="content site">
        	<?php foreach($list as $item){
				include "views/shirt-thumb.php";
			}?>
            <div style="clear:both"></div>
        </div>
    </main>
    <footer></footer>
</body>
</html>