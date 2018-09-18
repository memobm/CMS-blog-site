<?php
	
	$result = $_GET['q'];

	if($_GET['q'] !== ''){
		$db = mysqli_connect('198.57.247.222', 'memobm09', 'rm*umxe-Wc8y', 'memobm09_blogPage');

?>


<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="../assets/blog.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
	<div class="container">
	    <header class="py-3 text-center" id = "pageTop">
	       	<div class="blogTitle">Blog</div>
	   	</header>

	   	<div>
	       	<nav class="navbar navbar-expand-lg">
				<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav d-flex justify-content-center title">
				    	<li class="nav-item">
					   	 	<a class="nav-link" href="../blog.php">Blog</a>
						</li>
						<li class="nav-item">
						     <a class="nav-link" href="../index.html">Back to Site</a>
						</li>
					</ul>
				</div>	 	
	       	</nav>
	    </div>
	    <div class="container">
	      	<div class="row">
	        	<div class="col-md-8 blog-main">
	    			<div class="container search">
						<h4>Search</h4>
						<form method="get" action="search.php" class="inline-form mb-3">
							<div class="form-group">
			        			<input type="text" name="q" placeholder="Search..." class="form-control">
							</div>
			  			</form>
						<?php

							if(!isset($result)){
								echo "";
							} else {
								
								$search = mysqli_query($db, "SELECT post_id, post_title, LEFT(post_body, 220) AS post_body FROM posts WHERE post_title LIKE '%result%' OR post_body LIKE '%$result%' ORDER BY post_id DESC");
								$num_rows = mysqli_num_rows($search);

								while($row = mysqli_fetch_array($search)) {
									$id = $row['post_id'];
									$title = $row['post_title'];
									$body = $row['post_body'];

									$lastspace = strrpos($body, ' ');
									$body = html_entity_decode($body);

									echo "<h3><a href='../singlePost.php?id=$id'><span class=text-primary>".$title."</a></span></h3>";
									echo "<p>".substr($body, 0, $lastspace)."...</p>";
									echo "<a href='../singlePost.php?id=$id' class='btn btn-primary button'>Read More</a>";
								}
							}
						?>
					</div>
				</div>
				<aside class="col-md-4 blog-sidebar hide">
				        	<br><br>
				          	<div class="p-3 mb-3 bg-light rounded">
				          		<h4>Search</h4>
				          		<form method="get" action="search.php" class="inline-form mb-3">
				          			<div class="form-group">
				          				<input type="text" name="q" placeholder="Search..." class="form-control">
				          			</div>
				          		</form>

				          		<h4 class="font-italic">About</h4>
				            	<p class="mb-3">A blog to share my journey through computer programming</p>
				          	</div>

				          	<div class="p-3">
				            	<h4 class="font-italic">Elsewhere</h4>
				            	<ol class="list-unstyled">
				              		<li><a href="https://twitter.com/MemoBM">Twitter</a></li>
				              		<li><a href="https://www.facebook.com/memo.barragan.3">Facebook</a></li>
				              		<li><a href="https://www.linkedin.com/in/guillermo-barragan-307359121/">Linkedin</a></li>
				              		<li><a href="https://github.com/memobm">GitHub</a></li>
				            	</ol>
				          	</div>
		        </aside><!-- /.blog-sidebar -->
			</div>
		</div>
	</div>
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
<?php } else {
	
	header("Location: search.php");
}

	mysqli_close($db);
?>

