<?php     	

	include 'php/includes/config.php';
	
	$conn = OpenCon();

	$record_count = $conn->query("SELECT * FROM posts");
	$per_page = 5;
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
  	<head>
	  	<title>Guillermo Barragan - Blog</title>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" type="text/css" href="assets/blog.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
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
						     	<a class="nav-link" href="../learnMore.html">Back to Site</a>
							</li>
						</ul>
					</div>	
					<a class="text-muted" href="php/search.php">
              			<img src="img/search2.png" class="searchmobile">
            		</a> 	
	       		</nav>
	    	</div>

	    <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
	        <div class="col-md-6 px-0">
	        	<?php 
	        		$feature = $conn->query("SELECT post_title, LEFT(post_body, 120) AS post_body, post_id FROM posts WHERE category_id = 2");

					while ($row = $feature->fetch_object()) {
						
						$lastspace1 = strrpos($row->post_body, ' ');
	   					$row->post_body = html_entity_decode($row->post_body);
	        	?>
      			<h1 class="display-4 font-italic title"><?php echo $row->post_title?></h1>
      			<p><?php echo substr($row->post_body, 0, $lastspace1)?>...</p>
		         
		        <a href="singlePost.php?id=<?php echo $row->post_id; ?>" class="btn btn-primary button">Read More</a>
		    <?php } ?>
		    </div>
	    </div>

	    <div class="container">
	      	<div class="row">
	        	<div class="col-md-8 blog-main">
	   				
	   				<?php 

	   					if($query = $conn->prepare("SELECT post_id, post_title, post_author, LEFT(post_body, 250) AS post_body, DATE_FORMAT(posted, '%M %e, %Y') FROM posts ORDER BY post_id DESC LIMIT $start, $per_page")) {
							
							$query->execute();
							$query->bind_result($post_id, $title, $author, $body, $posted);

	   							while($query->fetch()) { 

	   							$lastspace2 = strrpos($body, ' ');
	   							$body = html_entity_decode($body);
	   				?>
		        	
		        	<div class="blog-post">
			            <h2 class="blog-post-title title">
			            	<a href="singlePost.php?id=<?php echo $post_id; ?>" class="text-dark"><strong><?php echo $title ?></strong></a>
			            </h2>
			            <p>by <span class="text-primary"><?php echo $author ?></span><?php echo " <small class='text-muted'>".$posted."</small>" ?> </p>
			     		<p><?php echo substr($body, 0, $lastspace2)?>...</p>
			            
			            <a href="singlePost.php?id=<?php echo $post_id; ?>" class="btn btn-primary button">Read More</a><br><br><br>		        	</div><!-- /.blog-post -->
		        	<?php } } CloseCon($conn); ?>
		        	<div>
		        		<?php
		        			if($prev > 0) {
            					echo "<a class='btn btn-outline-primary' href='blog.php?p=$prev'>Older</a>";
            				}

            				if($page < $pages) {
            					echo "<a class='btn btn-outline-primary' href='blog.php?p=$next'>Newer</a>";
            				}
            			?>
         			 </div>
		        </div><!-- /.blog-main -->     

		        <aside class="col-md-4 blog-sidebar hide">
		        	<h4>Search</h4>
		          		<form method="get" action="php/search.php" class="inline-form mb-3">
		          			<div class="form-group">
		          				<input type="text" name="q" placeholder="Search..." class="form-control">
		          			</div>
		          		</form>
		          	<div class="p-3 mb-3 bg-light rounded">
		            	<h4 class="font-italic">About</h4>
		            	<p class="mb-3">A blog to share my journey through computer programming.</p>
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
			</div><br><br>
	      <p><a href="#pageTop">Back to top</a></p>
	      <p><a href="php/login.php">Admin</a> |
	      <a href="privacypolicy.htm">Private Policy</a></p><br><br>
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


    