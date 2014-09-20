<?PHP include('header.php'); ?>
	
<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-col">
				<div class="row">
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 box login">	
						<h2 class="box-heading text-left">Cart <button type="button" class="hidden-xs btn btn-primary btn-lg pull-right">Place order</button><a href="#" class="btn btn-link btn-lg pull-right hidden-xs">Back to shopping</a></h2>
						<hr>
						<div class="alert alert-info" role="alert">
							If u choose bank transfer as a payment method, you will get <b>5%</b> discount on the order and <b>free shipping</b>.
						</div>
						
						
						<div class="table-responsive">
							<table class="table table-bordered table-striped products-table">
								<thead>
									<tr>
										<th colspan="2">Name</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Value</th>
										<th></th>
									</tr>
								</thead>
								
								<tbody>
									<tr>
										<td><img src="assets/img/iphone.jpg" alt="Apple iPhone 6" class=" img-rounded"></td>
										<td>
											<a href="product.php" alt="Apyl ajFo 6" />Apyl ajFo 6 <small>Color: space-gray<br />Memory: 32 GB</small></td>
										</td>
										<td>
											<b>$299.00</b><br /><del>$349.00</del>
										</td>
										<td>
											<input class="form-control text-center" type="number" value="1">
										</td>
										<td>
											<b>$299.00</b>
										</td>
										<td>
											<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
										</td>
									</tr>
									
									<tr>
										<td><img src="assets/img/ipad.jpg" alt="Apple iPhone 6" class=" img-rounded"></td>
										<td>
											<a href="product.php" alt="Apyl ajFo 6" />Apyl ajPad Cini <small>Color: space-gray<br />Memory: 32 GB</small></td>
										</td>
										<td>
											<b>$299.00</b><br /><del>$349.00</del>
										</td>
										<td>
											<input class="form-control text-center" type="number" value="1">
										</td>
										<td>
											<b>$299.00</b>
										</td>
										<td>
											<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
										</td>
									</tr>
									
									<tr>
										<td><img src="assets/img/iphone.jpg" alt="Apple iPhone 6" class=" img-rounded"></td>
										<td>
											<a href="product.php" alt="Apyl ajFo 6" />Apyl ajFo 6 <small>Color: space-gray<br />Memory: 32 GB</small></td>
										</td>
										<td>
											<b>$299.00</b><br /><del>$349.00</del>
										</td>
										<td>
											<input class="form-control text-center" type="number" value="1">
										</td>
										<td>
											<b>$299.00</b>
										</td>
										<td>
											<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
										</td>
									</tr>
									
									<tr>
										<td><img src="assets/img/ipad.jpg" alt="Apple iPhone 6" class=" img-rounded"></td>
										<td>
											<a href="product.php" alt="Apyl ajFo 6" />Apyl ajPad Cini <small>Color: space-gray<br />Memory: 32 GB</small></td>
										</td>
										<td>
											<b>$299.00</b><br /><del>$349.00</del>
										</td>
										<td>
											<input class="form-control text-center" type="number" value="1">
										</td>
										<td>
											<b>$299.00</b>
										</td>
										<td>
											<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						
						<div class="table-responsive">
							<table class="table table-bordered methods-table">
								<tbody>
									<tr class="coupon">
										<td colspan="6">
											<div class="form-inline text-right">
												<input class="form-control" type="text" placeholder="Enter discount code">
												<button type="submit" class="btn btn-info">Active</button>
											</div>
										</td>
									</tr>
								
									<tr class="methods">
										<td>
											<div class="shipping-method">
											<h4>Shipping method</h4>
											<hr>
											<div class="radio">
												<label>
													<input type="radio" name="shippingMethod" value="option1" checked>
													FedEX <b class="pull-right">$9.00</b>
												</label>
											</div>
											
											<div class="radio">	
												<label>
													<input type="radio" name="shippingMethod" value="option2" checked>
													UPS <b class="pull-right">$9.50</b>
												</label>
											</div>
											
											<div class="radio">	
												<label>
													<input type="radio" name="shippingMethod" value="option3" checked>
													Żukowice Post In.c <b class="pull-right">Free</b>
												</label>
											</div>
										</div>
										
										<div class="payment-method">
											<h4>Payment method</h4>
											<hr>
											<div class="radio">
												<label>
													<input type="radio" name="peymentMethod" value="option1" checked>
													PayPal
												</label>
											</div>
											
											<div class="radio">	
												<label>
													<input type="radio" name="peymentMethod" value="option2" checked>
													Bank Trasfer
												</label>
											</div>
										</div>	
										</td>
										
										<td>Delivery cost:</td>
										
										<td class="text-center"><b>$9.50</b></td>
									</tr>
									
									<tr class="rules-discount">
										<td colspan="2" class="text-right">You receive a discount for choosing a bank transfer!</td>
										<td class="text-center">-5%</td>
									</tr>
									
									<tr class="coupon-discount">
										<td colspan="2" class="text-right">Coupon code discount:</td>
										<td class="text-center">-10%</td>
									</tr>
									
									<tr class="summary">
										<td colspan="2" class="text-right">Total to pay: <small>Payment via Bank Transfer</small></td>
										<td class="text-center">$229.00</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="pull-right">
							<a href="#" class="btn btn-link btn-lg">Back to shopping</a>
							<button type="button" class="btn btn-primary btn-lg pull-right">Place order</button>
						</div>
					</div>	
					
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 box cross-selling-box">	
						<h2 class="box-heading text-center">Special offers</h2>
						<hr>
						<div class="row products-grid">	
							<div class="col-lg-12 col-md-12 col-sm-4 col-xs-6">
								<a href="product.php" title="Apyl ajFo 6">
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
								</a>
							</div>				

							<div class="col-lg-12 col-md-12 col-sm-4 col-xs-6">
								<a href="product.php" title="Apyl ajFo 6">
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
								</a>
							</div>		
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</section>

<?PHP include('footer.php'); ?>