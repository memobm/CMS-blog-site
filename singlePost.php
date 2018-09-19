<?php

	include 'php/includes/config.php';
	
	$conn = OpenCon();

	if(!isset($_GET['id'])) {
		header('Location: blog.php');
		exit();
	} else {
		$id = $_GET['id'];
	}

	if(!is_numeric($id)) {
		header('Location: blog.php');
	}

	$query = $conn->query("SELECT post_title, post_author, post_body FROM posts WHERE post_id = '$id'");
	
	if ($query->num_rows != 1) {
		header('Location: blog.php');
		exit();
	}

	CloseCon($conn);

?>

<!DOCTYPE html>
  	<head>
	  	<title>Guillermo Barragan - Blog</title>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" type="text/css" href="assets/blog.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
  	</head>
  	<body>
  		<div id="fb-root"></div>

		<script>(function(d, s, id) {
  			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=2128775437368854&autoLogAppEvents=1';
			fjs.parentNode.insertBefore(js, fjs);
		}
		
		(document, 'script', 'facebook-jssdk'));</script>

  		<div class="container">
	    	<header class="py-3 text-center" id = "pageTop">
	        	<div class="blogTitle">Blog</div>
	    	</header>

	    	<div>
	        	<nav class="navbar navbar-expand-lg">
					<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span> </button>
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
					<a class="text-muted" href="php/search.php">
              			<img src="img/search2.png" class="searchmobile">
            		</a> 	 	
	       		</nav>
	    	</div>
	    </div>
	    	<div class="container">
	      		<div class="row">
		        	<div class="col-md-8 blog-main">
			        	<div class="blog-post">
			        		<br><br>
			        		<?php 

			        			$row = $query->fetch_object(); 
			        			$row->post_body = html_entity_decode($row->post_body);
			        		?>
				            <h2 class="blog-post-title title">
				            	<strong><?php echo $row->post_title;?></strong>
				            </h2>
				            <p>by <span class="text-primary"><?php echo $row->post_author;?></span></p>
				     		<?php echo $row->post_body;?>
			        	</div><!-- /.blog-post -->
			        	<hr>
			        	<div class="fb-comments" data-href="http://guillermobarragan.com/singlePost.php?id=<?php echo $id?>" data-numposts="10"></div>
			        </div><!-- .blog-main -->     

			        <aside class="col-md-4 blog-sidebar hide">
			        	<br><br>
			          	<div class="p-3 mb-3 bg-light rounded">
			          		<h4>Search</h4>
			          		<form method="get" action="php/search.php" class="inline-form mb-3">
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
	      		</div><!-- /.row -->
	    	</div><!-- /.container -->
	  	
	  	<footer class="blog-footer footer-content">
	  		<div class="hide">
		      	<a href="https://twitter.com/MemoBM"><img src="img/twitter.png" class="img"></a>
				<a href="https://www.facebook.com/memo.barragan.3"><img src="img/facebook.png" class="img"></a>
				<a href="https://www.linkedin.com/in/guillermo-barragan-307359121/"><img src="img/linkedin.png" class="img"></a>
				<a href="https://github.com/memobm"><img src="img/github.png" class="img"></a><br>
			</div>
	      <p>
	      	<a href="#pageTop">Back to top</a>
	      </p>
	    </footer>

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
