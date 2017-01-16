<?php require_once "header-admin.php"; 
	$userTypes = get_results("SELECT id, name FROM user_types");
	
	$msg = '';
	$userId = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'new';
	$user = NULL;
	
		switch($action){
			case 'new':
				if(isset($_REQUEST['btSave'])){
					$ref = insert('users', array('first_name'=>$_REQUEST['firstname'],
												'last_name'=>$_REQUEST['lastname'],
												'username'=>$_REQUEST['username'],
												'email'=>$_REQUEST['email'],
												'usertype'=>$_REQUEST['usertype'],
												'password'=>password_hash($_REQUEST['password'], PASSWORD_DEFAULT)));
					//
					$msg = !$ref ? 'ERROR:' . $db->error : 'Record Saved';
				}
			break;
			case 'edit':
				if(isset($_REQUEST['btSave'])){
					//
					$firstname = $_REQUEST['firstname'];
					$lastname = $_REQUEST['lastname'];
					$username = $_REQUEST['username'];
					$email = $_REQUEST['email'];
					$usertype = $_REQUEST['usertype'];
					$password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
					//
					$ref = query("UPDATE users SET first_name='$firstname', last_name='$lastname', username='$username', email='$email', usertype=$usertype WHERE id=$userId");
					//
					$msg = $ref ? 'Record Saved' : '';
				}
					
				if($userId){
					$user = get_row("SELECT first_name, last_name, username, email, usertype FROM users WHERE id = $userId");
				}	
				
			break;
		}
	
?>
	<form action="" method="post" enctype="multipart/form-data">
    	<input type="hidden" id="id" name="id" value="<?php echo $userId; ?>"/>
        <input type="hidden" id="action" name="action" value="<?php echo $action; ?>"/>
        <fieldset>
        	<legend>User Details</legend>
            <?php if($msg != '') echo "<h4 class='center'>$msg</h4>"; ?>
	        <p><label for="firstname">First Name</label><input type="text" id="firstname" name="firstname" placeholder="first name" autofocus required value="<?php echo !is_null($user) ? $user->first_name : ''; ?>" /></p>
        	<p><label for="lastname">Last Name</label><input type="text" id="lalstname" name="lastname" placeholder="last name" required value="<?php echo !is_null($user) ? $user->last_name : ''; ?>" /></p>
	        <p><label for="username">Login Name</label><input type="text" id="username" name="username" placeholder="login name" required value="<?php echo !is_null($user) ? $user->username : ''; ?>" /></p>
	        <p><label for="email">E Mail</label><input type="email" id="email" name="email" placeholder="e mail" required value="<?php echo !is_null($user) ? $user->email : ''; ?>" /></p>
	        <p><label for="usertype">Type</label>
            <select id="usertype" name="usertype" required>
                <option disabled <?php echo !is_null($user) ? '' : 'selected'; ?> value>-- select type--</option>
                <?php foreach($userTypes as $type): ?>
                    <option <?php echo !is_null($user) && $user->usertype == $type->id ? 'selected' : ''; ?> value="<?php echo $type->id; ?>"><?php echo ucfirst($type->name); ?></option>
                <?php endforeach ?>
            </select>
	        </p>
        	<p><label for="password">Password</label><input type="password" name="password" id="password" placeholder="password" <?php echo !is_null($user) ? '' : 'required'; ?>/></p>        
            <p><input class="button" id="btSave" name="btSave" type="submit" value="Save"/><a class="button" href="/admin/users.php">Cancel</a></p>
        </fieldset>
	</form>	
<?php require_once "footer-admin.php"; ?>