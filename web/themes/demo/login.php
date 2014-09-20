<?PHP include('header.php'); ?>
	
<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-col">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 box login">	
						<h2 class="box-heading text-left">Sign in</h2>
						<hr>
						<div class="well">
							<div class="row">
								<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">	
									<h4>I have account<small class="pull-right">*required fields</small></h4>
									<hr>
								
									<form role="form">
										<div class="form-group">
											<label for="email" class="control-label required">Email address</label>
											<input type="email" class="form-control" id="email">
										</div>
										<div class="form-group has-error">
											<label for="password" class="control-label required">Password</label>
											<input type="password" class="form-control" id="password">
										</div>
										<div class="has-error">
											<div class="checkbox">
												<label>
													<input type="checkbox"> Remember me
												</label>
											</div>
										</div>
										
										<a href="#">I forgot my password</a>
										
										<button type="button" class="btn btn-primary pull-right">Sign in</button>
									</form>
								</div>
								
								<div class="col-lg-4 col-md-5 col-sm-4 hidden-xs">
									<div class="form-info">
										<h4>When you're our client</h4>
										<ul>
											<li>Fast and easy shopping</li>
											<li>You can see status of your order</li>
											<li>You have access to many profits and discounts</li>
										</ul>
									</div>
								</div>	
							</div>
						</div>
					</div>	
					
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 box registration">	
						<h2 class="box-heading text-left">Sign up</h2>
						<hr>
						<div class="well">
							<div class="row">
								<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">	
									<h4>New account<small class="pull-right">*required fields</small></h4>
									<hr>
								
									<div class="form-group">
										<label for="wellcomm" class="control-label required">First name</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group">
										<label for="wellcomm" class="control-label required">Last name</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group">
										<label for="wellcomm" class="control-label required">Phone number</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group">
										<label for="wellcomm" class="control-label required">E-mail address</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group has-error">
										<label for="wellcomm" class="control-label required">Password</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group has-error">
										<label for="wellcomm" class="control-label required">Type it again</label>
										<input type="text" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-5 col-sm-4 hidden-xs">
									<div class="form-info">
										<h4>What you get?</h4>
										<ul>
											<li>Full order history</li>
											<li>You can see status of your order</li>
											<li>Easy way to truck your package</li>
											<li>Much faster next shopping</li>
											<li>Ypu can add opinion about products</li>
										</ul>
									</div>
								</div>	
							</div>
						</div>
						
						<div class="well">
							<h4>Our store rules and conditions</h4>
							<hr>
							<div>
								<div class="checkbox">
									<label>
										<input type="checkbox"> Accept <a href="#">conditions</a> of Demo Store
									</label>
								</div>
							</div>

							<div class="has-error">
								<div class="checkbox">
									<label>
										<input type="checkbox"> I want to get newsletter with information about sales, promotions, news and discounts
									</label>
								</div>
							</div>									
						</div>
						
						<button type="button" class="btn btn-primary btn-lg pull-right">Sign up</button>
					</div>	
				</div>
			</div>
		</div>
	</div>
</section>

<?PHP include('footer.php'); ?>