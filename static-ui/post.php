<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Font Awesome -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
		<!-- custom css link -->
		<link rel="stylesheet" type="text/css" href="lib/styles.css">



		<!--font links -->


		<link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">



		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script type="text/javascript" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jquery v3.0 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<!-- jQuery Form, Additional Methods, Validate -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

		<!-- Your JavaScript Form Validator -->
		<script src="js/form-validate.js"></script>

		<!-- Google reCAPTCHA -->
		<script src='https://www.google.com/recaptcha/api.js'></script>



		<title>ABQ Town Hall Posts</title>
	</head>

	<body class="sfooter">
		<div class="sfooter-content">
			<main class="bgimg">
				<!-- insert header and navbar -->
				<header>
					<nav class="navbar navbar-default" id="top-of-page">
						<div class="container-fluid">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand" href="">
									<img src="../src/app/images/abq-townhall.png" alt="Brand">
								</a>
							</div>
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav navbar-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Districts <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#">District 1</a></li>
											<li><a href="#">District 2</a></li>
											<li><a href="#">District 3</a></li>
											<li><a href="#">District 4</a></li>
											<li><a href="#">District 5</a></li>
											<li><a href="#">District 6</a></li>
											<li><a href="#">District 7</a></li>
											<li><a href="#">District 8</a></li>
											<li><a href="#">District 9</a></li>
										</ul>
									</li>
									<li><a href="">Posts</a></li>
									<li><a href="">About Us</a></li>
									<li><a href="">Contact Us</a></li>

								</ul>
							</div><!-- /.navbar-collapse -->
						</div><!-- /.container-fluid -->
					</nav>
				</header>



					<div class="container">
						<div class="row">

							<div class="col-md-4">
								<h2>Create New Post</h2>

								<!-- Create New Post Form -->
								<form id="contact-form">

									<div class="form-group">
										<label class="sr-only" for="postContent">Content <span class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</div>
											<textarea class="form-control" name="postContent" id="postContent" cols="30" rows="10" placeholder="1024 characters max."></textarea>
										</div>
									</div>
									<div class="text-center center-block">

									<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
										<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button></div>
								</form>

							</div>

							<div class="col-md-8">
								<h2>Posts in District 1</h2>

								<!-- Begin Post Item -->
								<div class="panel panel-default">
									<div class="panel-body">
										This is the post content
									</div>
								</div>
							</div>
						</div>
					</div>
					</main>

		</div><!--/.sfooter-content-->

		<!-- insert footer -->
		<footer class="text-center">
			<a class="up-arrow" href="#top-of-page" data-toggle="tooltip" title="TO TOP">
				<span class="glyphicon glyphicon-chevron-up"></span>
			</a><br><br>
			<p>&copy; 2017 by Albuquerque Townhall.  Photo &copy;ruimc77.  Used under <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/legalcode" data-toggle="tooltip" title="https://creativecommons.org/licenses/by-nc-sa/2.0/legalcode">Creative Commons License</a></p>
		</footer>





	</body>
</html>