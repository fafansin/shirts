<?php require_once "header-admin.php"; 
	$users = get_results("SELECT u.id as ID, username, first_name, last_name, email, t.name as user_type FROM users u LEFT JOIN user_types t ON u.usertype = t.id");
?>
	<h1>User List</h1>

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Second Name</th>
                <th>E-Mail</th>
                <th>User Type</th>
                <th></th>
            </tr>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user->username;?></td>
                <td><?php echo $user->first_name;?></td>
                <td><?php echo $user->last_name;?></td>
                <td><?php echo $user->email;?></td>
                <td><?php echo $user->user_type;?></td>
                <td>
                	<a href="user-detail.php?action=edit&id=<?php echo $user->ID; ?>"><img title="edit" class="icon-buttons" src="/assets/images/edit-icon.png"/></a>
                	<a href="user-detail.php?action=delete&id=<?php echo $user->ID; ?>"><img title="delete" class="icon-buttons" src="/assets/images/delete-icon.png"/></a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>  
        <tfoot>
        <tr>
        	<td colspan="99">
            <div class="button-link">
                <a href="user-detail.php?action=new"><img class="icon-buttons" src="/assets/images/add-icon.png"/><span>Create User</span></a>
            </div>	
            </td>
        </tr>
        
        </tfoot>          
    </table>
    
<?php require_once "footer-admin.php"; ?>