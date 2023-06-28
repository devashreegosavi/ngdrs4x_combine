<!-- Banner -->

<div id="demo" class="carousel slide" data-ride="carousel">
		<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
		</ul>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<!-- <img src="images/banner1.jpg" alt="banner 1" width="100%"> -->

                <?=  $this->Html->image('user/banner1.jpg', ["title"=>"banner 1",'alt' => 'banner 1','width'=>"100%"]); ?>

				<!-- <div class="carousel-caption" style="color:#343A40;">
					<h3>Heading 1</h3>
					<p>Description goes here.</p>
				</div>  -->
			</div>
			<div class="carousel-item">
				<!-- <img src="images/banner1.jpg" alt="Banner 2" width="100%"> -->
                <?=  $this->Html->image('user/banner1.jpg', ["title"=>"Banner 2",'alt' => 'Banner 2','width'=>"100%"]); ?>

				<!-- <div class="carousel-caption" style="color:#343A40;">
					<h3>Heading 2</h3>
					<p>Description goes here.</p>
				</div>  -->
			</div>
			<div class="carousel-item">
				<!-- <img src="images/banner1.jpg" alt="Banner 3" width="100%"> -->
                <?=  $this->Html->image('user/banner1.jpg', ["title"=>"Banner 3",'alt' => 'Banner 3','width'=>"100%"]); ?>

				<!-- <div class="carousel-caption" style="color:#343A40;">
					<h3>Heading 3</h3>
					<p>Description goes here.</p>
				</div> -->
			</div>
		</div>
		<a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span style="display:none;">Previous</span>
			<span class="far fa-angle-left" style="font-size:40px; color:#fff"></span>
		</a>
		<a class="carousel-control-next" href="#demo" data-slide="next">
			<span style="display:none;">Next</span>
			<span class="far fa-angle-right" style="font-size:40px; color:#fff"></span>
		</a>
	</div>















	<!-- Dashboard -->
	<div class="my-5" id="b-homedb">
		<div class="container">
			<div class="row text-center">
				<h2 class="col-md-12">Figures tell the story</h2>
				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fa fa-id-card" style="font-size:40px"></span></p>
						<h3 style="font-size: 16px;"><strong>Total Applications Recieved</strong></h3>
						<div class="text-left ">
							<p class="px-5">Till date  <span class="float-right">4.88 Cr</span></p>

							<p class="px-5">Current year <span class="float-right">23 Lakh</span></p>
						</div>

					</div>

				</div>
				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fa fa-check-square" style="font-size:40px"></span></p>
						<h3 style="font-size: 16px;"><strong>Total Applications Registered</strong></h3>
						<div class="text-left ">
							<p class="px-5">Till date  <span class="float-right">2.23 Cr</span></p>

							<p class="px-5">Current year <span class="float-right">1.3 Lakh</span></p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 p-4">
					<div class="bg-light py-4 b-dbcard">
						<p><span class="fas fa-rupee-sign" style="font-size:40px;"></span></p>
						<h3 style="font-size: 16px;"><strong>Total Revenue Generated</strong></h3>
						<div class="text-left ">
							<p class="px-5">Till date  <span class="float-right">2,234.40 Cr</span></p>

							<p class="px-5">Current year <span class="float-right">9,478.75 Cr</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
