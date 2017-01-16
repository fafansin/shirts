<?php 
	ob_start();
	session_start();
	include_once "../lib/functions.php"; 
	$current_page = basename($_SERVER['PHP_SELF']);
	//
	$user = null;
	if(isset($_SESSION['user']) && !is_null($_SESSION['user'])){
		$user = $_SESSION['user'];
	}else{
		header("Location:login.php?url=$current_page");
		exit();
		/*
		if(!isset($_GET['url'])){
			var_dump($_SESSION);
			header("Location:login.php?url=$current_page");
			//exit();
		}
		*/
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Grilled Cheese | Admin</title>
    
    <link rel="stylesheet" type="text/css" href="/assets/css/main-style.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:600px)" href="/assets/css/style-tab.css"/>
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:786px)" href="/assets/css/style-desk.css"/>
    
    
    <script type="text/javascript" src="../assets/js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="../assets/js/admin-script.js"></script>

</head>

<body>
    <header>
        <div class="head-wrap site">
            <div class="logo-wrap left">
            	<a href="/"><img class="logo left" src="/assets/images/logo-invert.png"/></a>
                <div class="brand-wrap left">
                	<a href="/"><h1>GrilledCheese</h1></a>
                    <a href="/"><h2>Clothing</h2></a>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="nav-wrap">
                <ul class="topnav">
	                <li class="icon"><a style="font-size:15px;" href="javascript:void(0);">☰</a></li>
	                <?php if(!is_null($user)): ?>
                        <li class="special">Hi! <?php echo $user->firstname; ?></li>
                        <li><a id="btLogout" href="/admin/login.php?action=logout">logout</a></li>
                    <?php endif ?>
                    <li><a href="/admin/index.php">Home</a></li>
                    <li><a href="/admin/users.php">Users</a></li>
                </ul>
            </div>
            <div style="clear:both"></div>
        </div>
    </header>
    <main>
    	<div class="content site">