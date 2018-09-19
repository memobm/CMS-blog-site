<?php 

	include 'create.php'; 
	
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM posts WHERE post_id = $id");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$title = $n['post_title'];
			$author = $n['post_author'];
			$body = $n['post_body'];
		}
	}

	$record_count = mysqli_query($db, "SELECT * FROM posts");
  	$per_page = 20;
	$pages = ceil($record_count->num_rows/$per_page);

	if(isset($_GET['p']) && is_numeric($_GET['p'])) {
	    $page = $_GET['p'];
	} else {
	    $page = 1;
	}

	if($page <= 0) {
	    $start = 0;
	} else {
	    $start = $page * $per_page - $per_page;
	}

	$prev = $page - 1;
	$next = $page + 1;	

?>

<!DOCTYPE html>
	<html>
		<head>
			<title>Edit - Admin</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<link rel="stylesheet" type="text/css" href="css/admin.css">
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
			<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
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
						<h2>Edit Post</h2>
					</div>
					<div>
						<?php 
							if (isset($_SESSION['message'])){ ?>
								<div class="alert alert-success">
									<?php 
										echo $_SESSION['message']; 
										unset($_SESSION['message']);
									?>
								</div>
						<?php } ?>
						<?php 
							if (isset($_SESSION['errorMessage'])){ ?>
								<div class="alert alert-danger">
									<?php 
										echo $_SESSION['errorMessage']; 
										unset($_SESSION['errorMessage']);
									?>
								</div>
						<?php } ?>
						<form method="post" action="create.php">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<div class="form-group">
								<label>Title</label>
								<input type="text" name="title" value="<?php echo $title ; ?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Author</label>
								<input type="text" name="author" value="<?php echo $author; ?>" class="form-control">
							</div>
							</div>
							<div class="form-group">
								<label>Body</label>
								<textarea name="body" class="form-control" cols=50 rows=10><?php echo $body?></textarea>
							</div>
							<div class="form-group">
								<label>Category</label>
								<select name="category" class="form-control">
									<?php $category = mysqli_query($db, "SELECT * FROM categories"); 
										while($row = mysqli_fetch_array($category)) {

										echo "<option value=".$row['category_id'].">".$row['category']."</option>";
								
									 } ?>

								</select>
							</div>

							<div class="form-group">
								<?php if ($update == true): ?>
									<button class="btn btn-success" type="submit" name="update">Update</button>
									<a href="editPost.php" class="btn btn-primary">New</a>
								<?php else: ?>
									<button class="btn btn-primary" type="submit" name="save">Save</button>
								<?php endif ?>
							</div>
						</form><br>

						<?php $results = mysqli_query($db, "SELECT * FROM posts ORDER BY post_id DESC LIMIT $start, $per_page"); ?>

						<table class="table table-striped">
							<thead>
								<tr>
									<th>Title</th>
									<th>Author</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
	
							<?php while ($row = mysqli_fetch_array($results)) { ?>
								<tr>
									<td><?php echo $row['post_title']; ?></td>
									<td><?php echo $row['post_author']; ?></td>
									<td class="text-center">
										
										<a href="editPost.php?edit=<?php echo $row['post_id']; ?>" class="btn btn-primary">Edit</a>
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del<?php echo $row['post_id']?>">Delete</button>
									</td>
								</tr>
								
								<!-- delete modal -->
								<div class="modal fade" id="del<?php echo $row['post_id']?>" tabindex="-1" role="dialog" aria-labelledby="deletePost" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">	
											<div class="modal-header">
												<h5 class="modal-title" id="deletePost">Delete Post</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											</div>
											<div class="modal-body">
												<p>Are you sure you want to delete this post?</p>
												<h8><strong><?php echo $row['post_title']?></strong></h8>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<a href="editPost.php?del=<?php echo $row['post_id']; ?>" class="btn btn-danger">Delete</a>
											</div>	
										</div>
									</div>
								</div>
								<!-- End of delete modal -->	
							<?php } ?>
						</table>
					</div>
					<div>
		            <?php
		              	if($prev > 0) {
		                	echo "<a class='btn btn-outline-primary' href='editPost.php?p=$prev'>Older</a>";
		              	}
		                
		              	if($page < $pages) {
		                	echo "<a class='btn btn-outline-primary' href='editPost.php?p=$next'>Newer</a>";
		              	}
		            ?>
		        </div>
				</div>	
			</div><!-- div.row -->
		</div><!-- div.main -->

		<footer class="editPost-footer footer-content">
			<p><a href="#pageTop">Back to Top</a></p>
		</footer>
	
		<?php mysqli_close($db); ?>

		<script>CKEDITOR.replace('body');</script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
	      	$(document).ready(function() {
		        $('a[href^="#"]').on('click',function(e) {
		          e.preventDefault();

		         	var target = this.hash;
		          	var $target = $(target);

		          	$('html, body').animate({
		            	'scrollTop': $target.offset().top
		          	}, 1000, 'swing');    
		        });
	      	});
   		</script>

	</body>
</html>
