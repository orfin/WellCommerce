<?php include('head.php') ?>

<body>
	<header>
		<div class="tools">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 left">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="CurrencyMenu" data-toggle="dropdown" aria-expanded="true">
								Currency: USD
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="CurrencyMenu">
								<li><a href="#">PLN</a></li>
								<li><a href="#">EU</a></li>
								<li><a href="#">USD</a></li>
							</ul>
						</div>
					</div>
					
					<div class="col-lg-6 text-right right">
						<a href="#" class="btn btn-default btn-sm">Sign in</a>
						<a href="#" class="btn btn-default btn-sm">Sign up</a>
					</div>
				</div>
			</div>
		</div>
	
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				
					<a class="navbar-brand" href="#">
						<img alt="Brand" src="assets/img/logo.png">
					</a>
				</div>
				
				<ul class="steps pull-right">
					<li class="passed">
						Step 1
						<small>Address</small>
					</li>
					
					<li class="active">
						Step 2
						<small>Finalization</small>
					</li>
					
					<li>
						Step 3
						<small>Payment and confirmation</small>
					</li>
				</ul>
			</div>
		</nav>

	</header>   