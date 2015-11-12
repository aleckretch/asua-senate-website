<?php
	echo ( isset( $_POST['username'] ) ? "Username: {$_POST['username']}<br>" : "Username not found<br>" );
	echo ( isset( $_POST['password'] ) ? "Password: {$_POST['password']}<br>" : "Password not found<br>" );
?>
