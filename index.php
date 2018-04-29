<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>
<?php 
session_start();
if (empty($_SESSION['user'])) {
	?>
	<script type="text/javascript">
		document.location="login.php";
	</script>
<?php }
$hrf = $_GET['hrf'];
$user_session = $_SESSION['user'];
$arr = array($user_session,$hrf);

	$db = new \mysqli("localhost","root","","db_chat");

		/*
		Check pada database message_session menggunakan 2 kondisi dalam 1 koloum
		*/
		$query2 = $db->query("SELECT * FROM message_session WHERE user_id IN ($user_session,$hrf) GROUP BY message_session_id HAVING COUNT(*) = 2");

		$fetch2 = $query2->fetch_array();
		$message_session_id = $fetch2['message_session_id'];

		if (mysqli_num_rows($query2) > 0) {
		$fetch3 = $query2 -> fetch_array();
		$chat_session = $message_session_id;
		$_SESSION['chat_session'] = $chat_session;
		}
		else{
			$time = time();
			foreach ($arr as $arr_val) {
			$db->query("INSERT INTO message_session (message_session_id,user_id) VALUES ($time,$arr_val)");
			$_SESSION['chat_session'] = $time;
			}
		}
		$active_chat = $_SESSION['chat_session'];
		$db->query("UPDATE user SET active_chat = $active_chat WHERE user_id = $user_session");
?>

<!-- Online Status -->
<div class="container">
	<div class="col-md-12">
		<h2>Chating</h2>
		<h4></h4>
		<p id="status"></p>


			<div id="result-message">
			</div>
		<div class="form-group">
		<input type="text" id="text" name="" class="form-control">
		</div>
		<button id="btn" class="btn btn-info">Kirim</button>

	</div>
</div>

<script src="jquery-3.1.1.js"></script>
<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	//create a new WebSocket object.
	var wsUri = "ws://localhost:9000/chat/chat-server.php"; 	
	websocket = new WebSocket(wsUri); 
	var session = "<?php echo $_SESSION['user'] ?>"
	var hrf = "<?php echo $_SESSION['chat_session'] ?>"


	websocket.onopen = function(e){
		/*console.log("Connection established!");*/
		$('#status').html('You are Online')
			var j = {
				"app"			:"open_client",
				"user_session"	:session
			}
			/*membuat file JSON dengan stringify*/
			websocket.send(JSON.stringify(j));
	}

		$('#btn').click(function(){
			var r = $("#text").val();
			var j = {
				"app"			:"chat",
				"msg_session"	:hrf,
				"user_id"		:session,
				"message"		:r
			}
			websocket.send(JSON.stringify(j));

		$("#text").val("");
		})

	websocket.onclose = function(e){
		$('#status').html('You are Offline')
	}
	websocket.onerror = function(e){
		console.log(e);
	}
	websocket.onmessage = function(evt){
		$("#result-message").append("<p>"+evt.data+"<br></p>");
	}


});
</script>
</body>
</html>