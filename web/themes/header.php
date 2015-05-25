<?php include('head.php') ?>

<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&appId=318369768271930&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

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
				
				<div class="collapse navbar-collapse" id="main-nav">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Category <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Smart TVs</a></li>
								<li class="divider"></li>
								<li><a href="#">Electronics</a></li>
								<li class="divider"></li>
								<li><a href="#">Smartphones</a></li>
								<li class="divider"></li>
								<li><a href="#">Something else here</a></li>
							</ul>
						</li>
						<li><a href="#">Promotions</a></li>
						<li><a href="#">New products <span class="sr-only">(current)</span></a></li>
						<li><a href="#">Help</a></li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right" id="topCart">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle cartQty" data-toggle="dropdown" role="button" aria-expanded="false">Cart<span class="cart-qty">2</span></a>
							<ul class="dropdown-menu" role="menu">
								<li>
									<table>
										<tbody>
											<tr>
												<td>
													<a href="#" class="delete"><img src="../assets/img/delete-ico.png" /></a>
												</td>
												<td>
													<a href="#">Nowy Apple TV® - Black</a></li>
												</td>
												<td>
													<input type="text" value="2" class="text-center" />
												</td>
												<td class="text-right">
													$499,00
												</td>
											</tr>
										</tbody>
									</table>
								</li>	
								<li class="divider"></li>
								<li>
									<table>
										<tbody>
											<tr>
												<td>
													<a href="#" class="delete"><img src="../assets/img/delete-ico.png" /></a>
												</td>
												<td>
													<a href="#">Garmin Fitness Band - Red</a></li>
												</td>
												<td>
													<input type="text" value="1" class="text-center" />
												</td>
												<td class="text-right">
													$299,00
													<small>$349,00</small>
												</td>
											</tr>
										</tbody>
									</table>
								</li>
								<li class="clearfix">
									<a href="cart.php">Checkout <img src="../assets/img/arrow-right-ico.png" /></a>
									
									<span class="pull-right">$798,00</span>
								</li>	
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>

	</header>   