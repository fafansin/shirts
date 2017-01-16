<?php
	ob_start();
	session_start();
	include_once "../lib/functions.php";
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
	$redirect = isset($_REQUEST['url']) && !is_null($_REQUEST['url']) ? $_REQUEST['url'] : 'index.php';
	$msg = ''; 
	switch($action){
		case 'login':
			if(isset($_POST['lbuser']) && isset($_POST['lbpass'])){
				$user = get_row("SELECT username, password, email, first_name FROM users WHERE username='".$_POST['lbuser']."'");
				if(!is_null($user)){
					if(password_verify($_POST['lbpass'], $user->password)){
						$ref = new stdClass();
						$ref->username = $user->username;
						$ref->firstname = $user->first_name;
						$ref->email = $user->email;
						$_SESSION['user'] = $ref;
						//var_dump($_SESSION);
						
						header("Location:$redirect");
						exit();
					}else{
						$msg = "Wrong Password";
					}
				}else{
					$msg = "User Not Found";
				}
			}
		break;
		case 'logout':
			session_destroy();
		break;
	}
	
	//
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Grilled Cheese | Admin</title>
</head>
<body>
	<?php switch($action): case "login":?>    
        <form name="login" action="" method="post" autocomplete="off">
            <input type="hidden" name="url" value="<?php echo $redirect; ?>"/>
            <input type="hidden" name="action" value="<?php echo $action; ?>"/>
            <div class="login-wrap">
                <input type="text" name="lbuser" placeholder="User Name"/>
                <input type="password" name="lbpass" placeholder="Password"/>
                <input type="submit" value="Login"/>
                <div class="msg-box">
                    <?php echo $msg; ?>
                </div>
            </div>
        </form>
    <?php break; case "logout": ?>
    	<div>
	        <h4>Logged out</4>
            <a href="/">back</a>
            <a href="/admin">login</a>
        </h4>
	<?php break; endswitch; ?>
</body>
