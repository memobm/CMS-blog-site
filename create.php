<?php 
	session_start();
	//Change the information to what goes in there instead of the actual info to connect to the db
	$db = mysqli_connect('localhost', 'username', 'password', 'database');

	if(!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
	}

	// initialize variables
	$title = "";
	$author = "";
	$body = "";
	$category = "";
	$id = 0;
	$update = false;

	// To add new posts
	if (isset($_POST['save'])) {
		$title = $_POST['title'];
		$author = $_POST['author'];
		$body = $_POST['body'];
		$category = $_POST['category'];
		$title = mysqli_real_escape_string($db, $title);
		$author = mysqli_real_escape_string($db, $author);
		$body = mysqli_real_escape_string($db, $body);
		$user_id = $_SESSION['user_id'];
		$date = date('Y-m-d');
		$title = htmlentities($title);
		$author = htmlentities($author);
		$body = htmlentities($body);

		if ($title && $author && $body) {
			mysqli_query($db, "INSERT INTO posts (user_id, post_title, post_author, post_body, category_id, posted) VALUES ('$user_id', '$title', '$author', '$body', '$category', '$date')"); 
			$_SESSION['message'] = "Blog post saved"; 
			header('location: editPost.php');
		} else {
			$_SESSION['errorMessage'] = "Error. Missing fields"; 
			header('location: editPost.php');
		}
	}


	// To update posts
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$body = $_POST['body'];
		$category = $_POST['category'];
		$title = mysqli_real_escape_string($db, $title);
		$author = mysqli_real_escape_string($db, $author);
		$body = mysqli_real_escape_string($db, $body);
		$title = htmlentities($title);
		$author = htmlentities($author);
		$body = htmlentities($body);

		mysqli_query($db, "UPDATE posts SET post_title = '$title', post_author = '$author', post_body = '$body', category_id = '$category' WHERE post_id = $id");
		
		$_SESSION['message'] = "Blog post updated!"; 
		header('location: editPost.php');
	}

	// To delete posts
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM posts WHERE post_id = $id");
		$_SESSION['message'] = "Address deleted!"; 
		header('location: editPost.php');
	}

?>
