<?PHP include('header.php'); ?>

<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-3 col-md-3">
					<?php include('breadcrumbs.php'); ?>
				</div>
				
				<div class="col-lg-9 col-md-9">
					<div class="category-tools">
						<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="CurrencyMenu" data-toggle="dropdown" aria-expanded="true">
								Products grid
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="CurrencyMenu">
								<li><a href="category_list.php">Products list</a></li>
							</ul>
						</div>
						
						<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="CurrencyMenu" data-toggle="dropdown" aria-expanded="true">
								Sort by: price
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="CurrencyMenu">
								<li><a href="#">By rating</a></li>
								<li><a href="#">By date</a></li>
								<li><a href="#">By date</a></li>
								<li><a href="#">By popularity</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3">
				<?php include('categoriesbox.php'); ?>
				<?php include('layerednavigation.php'); ?>
				<?php include('poll.php'); ?>
			</div>

			<div class="col-lg-9 col-md-9">
				<?php include('products_grid.php'); ?>
			</div>
		</div>
			
		</div>
	</div>
</section>
   
<?PHP include('footer.php'); ?>