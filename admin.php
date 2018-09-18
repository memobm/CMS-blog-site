<?php 

	include 'includes/config.php';

	session_start();
	$conn = OpenCon();

	if(!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
	}

	$post_count = $conn->query("SELECT * FROM posts");
	$comment_count = $conn->query("SELECT * FROM comments");

	if(isset($_POST['submit'])) {
		$newCategory = $_POST['newCategory'];
		$newCategory = real_escape_string($newCategory);
		if(!empty($newCategory)) {
			$query = $conn->query("INSERT INTO categories(category) VALUES('".$newCategory."')");
			if ($query) {
				$categoryPosted = "New cateogry added";
			} else {
				echo "error";
			}
		} else {
			 "Error, missing category";
		}
	}

	CloseCon($conn);
?>

<!DOCTYPE html>
	<head>
		<title>Admin Home Page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="css/admin.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
	</head>

	<body>
		<header id="pageTop">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			  	<h2 class="text-light">Admin - Dashboard</h2>
			  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			  	<div class="collapse navbar-collapse mr-auto" id="navbarText">
			  		<ul class="navbar-nav mr-auto">
		  				<li class="nav-item mobileMenu">
          					<a class="nav-link text-light" href="admin.php"><img src="img/dashboard.png" class="dashboardIcon">Home</a>
           				</li>
           				<li class="nav-item mobileMenu">
               				<a class="nav-link text-light" href="editPost.php"><img src="img/post.png" class="dashboardIcon">Edit Post</a></li>
              			<li class="nav-item mobileMenu">
               				<a class="nav-link text-light" href="#"><img src="img/post.png" class="dashboardIcon">Delete Category</a>
              			</li>
              			<li class="nav-item mobileMenu">
              				<a href="logout.php" class="nav-link"><img src="img/logout.png" class="dashboardIcon"><span class="navbar-text text-light">Logout</span></a>
              			</li>
			  		</ul>
			    	<a href="logout.php" class="nav-link logout"><span class="navbar-text">Sign out</span></a>
			  </div>
			</nav>
		</header>

	    <div class="container-fluid">
      		<div class="row">
        		<nav class="col-sm d-none d-md-block bg-light sidebar">
          			<div class="sidebar-sticky">
            			<ul class="nav flex-column">
              				<li class="nav-item dashboard">
              					<a class="nav-link" href="admin.php"><img src="img/dashboard.png" class="dashboardIcon">Home</a>
              				</li>
              				<li class="nav-item">
                				<a class="nav-link" href="editPost.php"><img src="img/post.png" class="dashboardIcon">Edit Post</a>
                			</li>
            			</ul><br>
            			<div class="container">
            				<h4>Note</h4>
            				<p>When editing a post, the category options resets to uncategorized.</p>
            			</div>
            		</div>
    			</nav>

				<div class="col-md-9 ml-sm-auto col-lg-10 px-4">
		          	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		            	<h2>Dashboard</h2>
		         	</div>
		         	<div>
						<table>
							<tr>
								<td><strong>Total Blog Post:</strong></td>
								<td><?php echo $post_count->num_rows; ?></td>
							</tr>
						</table>
						<br>
						<div>
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="form-inline">
								<div class="form-group">
									<label for="category">Add New Category:</label>
								</div>
								<div class="form-group mx-sm-3">
									<input type="text" name="newCategory" class="form-control">
								</div>
									<input type="submit" name="submit" value="Submit" class="btn btn-primary button"><br>
									<?php echo $categoryPosted ?>
							</form><br>
							<!--<p><a href="../blog.php">Go back to Blog home page</a></p>-->
						</div>
					</div>
		        </div>
		    </div>
	    </div>
		 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>