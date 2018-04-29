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
	<h1 class="text-center">Login Chat</h1>
	<form method="POST">
	<div class="form-group">
		<label>Masukanu Username</label>
		<input type="text" name="text" class="form-control">
	</div>
	<input type="submit" value="Kirim" name="kirim" class="btn btn-info">
	</form>
		
	</div>
</div>

<?php 
	session_start();
if (isset($_POST['kirim'])) {
	$text = $_POST['text'];
	$_SESSION['user'] = $text;
	header('Location:chat-history.php');
}
?>

</body>
</html>