<?PHP include('header.php'); ?>
	
<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 main-col">
				<div class="row">
					<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
						<div class="row">		
							<div class="col-lg-12 box">	
								<div class="list-group">
									<a href="#" class="list-group-item active">Category</a>
									<a href="#" class="list-group-item">Category</a>
									<a href="#" class="list-group-item">Category</a>
									<a href="#" class="list-group-item">Category</a>
									<a href="#" class="list-group-item">Category</a>
									<a href="#" class="list-group-item">Category</a>
								</div>
							</div>
							
							<div class="col-lg-12 box">	
								<div class="panel panel-default">
									<div class="panel-heading">
										Filters
									</div>
									<div class="panel-body">
										<fieldset>
											<h5>Price:</h5>
											
											<div class="row">
													<div class="col-lg-5 col-xs-2">
														<input type="number" class="form-control input-sm" id="price-from" placeholder="0">
													</div>
													<div class="col-lg-2 col-xs-2 text-center">-</div>
													<div class="col-lg-5 col-xs-2">
														<input type="number" class="form-control input-sm" id="price-to" placeholder="9999">
													</div>
											</div>
										</fieldset>
										
										<hr>
										
										<fieldset>
											<h5>Sizes:</h5>
										
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													XS
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													S
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													M
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													L
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													L w chuj!
												</label>
											</div>
										</fieldset>

										<hr>

										<fieldset>
											<h5>Producers:</h5>
										
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Bonus BGC
												</label>
											</div>
										
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Najki
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Ribuk
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Abibas
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Pumba
												</label>
											</div>
											
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													Ruchałełe
												</label>
											</div>
										</fieldset>
										<hr>
										<button type="button" class="btn btn-primary">Make magic</button>
										<button type="button" class="btn btn-default">Clear</button>
									</div>
								</div>							
							</div>
						</div>
					</div>
					
					<div class="col-lg-9 col-md-9">
						<div class="col-lg-12 box">	
							<h2 class="box-heading text-left">Buty dobre w chuj</h2>
							<hr>
							
							<div class="well">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							
							<div class="panel panel-default">
							  	<div class="panel-body">
							  		<form class="form-inline" role="form">
							  			<div class="row">
									  		<div class="form-group col-lg-3">
									  			<label>Sort by: </label> 
										  		<select class="form-control">
													<option>default</option>
													<option>price</option>
													<option>date</option>
													<option>opinions</option>
												</select>
									  		</div>
									  		
									  		<div class="form-group col-lg-3">
									  			<label>Show: </label> 
										  		<select class="form-control">
													<option>16 items</option>
													<option>32 items</option>
													<option>w chuj items</option>
												</select>
									  		</div>
									  		<div class="form-group col-lg-3">
									  			<label>Display: </label> 
									  			<div class="btn-group">
													<button type="button" class="btn btn-default active">Grid</button>
													<button type="button" class="btn btn-default">List</button>
												</div>
									  		</div>
							  			</div>
							  		</form>							  	
								</div>
							</div>
							
							<div class="hidden-lg hidden-md">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													Filter by price
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-right"><label>From:</label></div>
													<div class="col-lg-5  col-md-5  col-sm-4 col-xs-4">
														<input type="number" class="form-control input-sm" id="price-from" placeholder="0">
													</div>
													<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-right"><label>To:</label></div>
													<div class="col-lg-5  col-md-5  col-sm-4 col-xs-4">
														<input type="number" class="form-control input-sm" id="price-to" placeholder="9999">
													</div>
												</div>
											</div>
										</div>
									</div>
	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
													Filter by size
												</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														XS
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														S
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														M
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														L
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														L w chuj!
													</label>
												</div>

											</div>
										</div>
									</div>
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
													Filter by producer
												</a>
											</h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Bonus BGC
													</label>
												</div>
											
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Najki
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Ribuk
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Abibas
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Pumba
													</label>
												</div>
												
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Ruchałełe
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
							
							<div class="clearfix">
								<ul class="pagination pull-right">
									<li class="disabled"><a href="#">&laquo;</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li><a href="#">&raquo;</a></li>
								</ul>
							</div>
							
							<div class="row products-grid">	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>				
	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>				
	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>				
	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>	
								
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<div class="thumbnail">
										<div class="labels">
											<span class="label label-info">Promotion</span>
										</div>
									
										<img src="assets/img/iphone.jpg" alt="Apple iPhone 6">
										<div class="caption">
											<h3>Apple iPhone 4s</h3>
											<p class="clearfix">
												<span class="pull-left"><b>$12,99</b></span>
												<span class="pull-right"><small><del>$14,99</del></small></span>
											</p>
											<a href="#" class="btn btn-primary btn-group-justified" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</a> 
										</div>
									</div>
								</div>	
							</div>
							
							<div class="clearfix">
								<ul class="pagination pull-right">
									<li class="disabled"><a href="#">&laquo;</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li><a href="#">&raquo;</a></li>
								</ul>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
   
<?PHP include('footer.php'); ?>