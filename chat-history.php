<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

<div class="container">
	<div class="col-md-10">
	<h1 class="text-center">Chat Member</h1>
	<?php 
	session_start();
	$session_id = $_SESSION['user'];
	$db = new \mysqli("localhost","root","","db_chat");
	$query = $db->query("SELECT * FROM user WHERE user_id != '$session_id'");

	echo $session_id;
	while ($fetch = $query->fetch_array()) {
		$user_id = $fetch['user_id'];
		$status = $fetch['status'];

		
		?>
		<a href="index.php?hrf=<?php echo $fetch['user_id'] ?>">
		<h4><?php echo $user_id ?></h4>
		<?php 
		if ($status == "online") {
			echo "online";
		}
		else{
			echo "Last seen ".$fetch['last_seen'];
		}
	}
	?>
		</a>

	</div>
</div>
</body>
</html>