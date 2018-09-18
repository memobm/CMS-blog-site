<?php
	
	include 'includes/config.php';
	

	session_start();
	$conn = OpenCon();

	if(isset($_POST['submit'])) {
		$user = $_POST['username'];
		$pwrd = $_POST['pwrd'];

		if (empty($user) || empty($pwrd)) {
			echo "Missing Information";
		} else {
			$user = strip_tags($user);
			$user = $conn->real_escape_string($user);
			$pwrd = strip_tags($pwrd);
			$pwrd = $conn->real_escape_string($pwrd);
			$pwrd = md5($pwrd);
			$query = $conn->query("SELECT user_id, username FROM user WHERE username = '$user' AND password = '$pwrd'");
			if($query->num_rows === 1) {
				while ($row = $query->fetch_object()) {
					$_SESSION['user_id'] = $row->user_id;
				}
				header('Location: admin.php');
				exit();
			} else {
				$error = 'Wrong Information';
			}
		}
	}

	CloseCon($conn);
?>



<!DOCTYPE html>
	<head>
		<title>Login Page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" type="text/css" href="css/login.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
	</head>

	<body>
		 <form class="form-signin text-center" action="login.php" method="post">
		    <img src="img/gb-logo.jpg" alt="" class="logo" width="72" height="72">
		    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		    <label class="sr-only">Username</label>
		    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
		    <label class="sr-only">Password</label>
		    <input type="password" name="pwrd" class="form-control" placeholder="Password" required>

		    <div class="checkbox mb-3">
		      	<span class="text-danger"><?php echo $error ?></span><br><br>
		        <label><input type="checkbox" value="remember-me"> Remember me<br></label>
		    </div>
		    <input type="submit" name="submit" value="Sign In" class="btn btn-primary button">
		    <p class="mt-5 mb-3"><a href="../blog.php">Back to Blog</a></p>
		    <p class="mb-3 text-muted">&copy; Guillermo Barragan 2018</p>
		    
    	</form>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>