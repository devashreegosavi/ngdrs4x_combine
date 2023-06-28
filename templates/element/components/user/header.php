<div style="display:none;">
		<h1>Heading1</h1><h2>Heading2</h2>
	</div>

	<!-- Accessibility -->
	<div class="container d-flex clearfix" id="b-accessibility">
		<div class="b-ministryname">
			<div class="text-end d-inline-block fw-bold b-acc-goi my-sm-1 pe-2">
				<span>भारत सरकार</span> <br> <span>GOVERNMENT OF INDIA</span>
			</div>

			<div class="fw-bold d-inline-block b-acc-ministry my-sm-1 ps-1">
				<span>मंत्रालय / विभाग नाम</span> <br> <span>MINISTRY / DEPT. NAME</span>
			</div>
		</div>


		<div class="ms-auto d-flex b-acc-icons">
			<div class="align-self-center">

				<div class="d-inline-block h-100 px-3">

               <?=  $this->Html->image('user/icons/ico-site-search.png', ['alt' => 'site search icon','title'=>"Site search",'class'=>"dropdown-toggle","data-toggle"=>"dropdown","style"=>"cursor: pointer;"]); ?>
					<!-- <img src="images/icons/ico-site-search.png" alt="site search icon" title="Site search" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;"> -->

					<div class="dropdown-menu p-0 border-0 b-search">
						<label for="site-search" style="display:none;">Site search</label>
				        <input type="text" class="form-control float-start b-site-search" id="site-search" placeholder="Search" style="width: 150px; border-radius: 0;">
					    <div class="input-group-btn float-start">
					      <button class="btn" type="submit" style="border-radius: 0; background: #505050; color: white; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0);">
					      	<span style="display:none;">Search</span>
					        <span class="fas fa-search"></span>
					      </button>
					    </div>
				    </div>
				</div>

				<div class="d-inline-block h-100 px-3 dropdown">
					<!-- <img src="images/icons/ico-social.png" alt="social sites links" title="Social links" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;"> -->
               <?=  $this->Html->image('user/icons/ico-social.png', ['alt' => 'social sites links','title'=>"Social links",'class'=>"dropdown-toggle","data-toggle"=>"dropdown","style"=>"cursor: pointer;"]); ?>

					<div class="dropdown-menu b-social-dropdown" style="min-width: 50px; width: 50px" >
				        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Facebook link</span><span class="fab fa-facebook-f"></span> </a>
				        <a href="javascript:void(0);" class="dropdown-item"> <span style="display:none;">Twitter link</span><span class="fab fa-twitter"></span> </a>
				        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Youtube link</span><span class="fab fa-youtube"></span> </a>
				    </div>
				</div>


				<div class="d-inline-block h-100 px-3">
					<a href="#b-homedb" class="align-self-center b-skiptomain" title="Skip to main content">
						<!-- <img src="images/icons/ico-skip.png" alt="skip to main content icon"> -->

                        <?=  $this->Html->image('user/icons/ico-skip.png', ['alt' => 'skip to main content icon']); ?>

					</a>
				</div>

				<div class="d-inline-block h-100 px-3">
					<!-- <img src="images/icons/ico-accessibility.png" alt="accessibility icon" title="Accessibility Dropdown" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;"> -->
               <?=  $this->Html->image('user/icons/ico-accessibility.png', ['alt' => 'accessibility icon','title'=>"Accessibility Dropdown",'class'=>"dropdown-toggle","data-toggle"=>"dropdown","style"=>"cursor: pointer;"]); ?>

					<div class="dropdown-menu b-accessibility-dropdown" style="min-width: 50px; width: 50px" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
				        <a href="javascript:void(0);" class="dropdown-item" title="Increase font size"> <span class="fw-bold"> A<sup>+</sup> </span> </a>
				        <a href="javascript:void(0)" class="dropdown-item" title="Reset font size"> <span class="fw-bold"> A </span> </a>
				        <a href="javascript:void(0);" class="dropdown-item" title="Decrease font size"> <span class="fw-bold"> A<sup>-</sup> </span> </a>
				        <a href="javascript:void(0)" class="dropdown-item bg-dark" title="High contrast"> <span class="fw-bold text-white"> A </span> </a>
				    </div>
				</div>

				<div class="d-inline-block h-100 px-3">
					<a href="#" title="Sitemap">
						<!-- <img src="images/icons/ico-sitemap.png" alt="sitemap icon"> -->
                        <?=  $this->Html->image('user/icons/ico-sitemap.png', ['alt' => 'sitemap icon']); ?>

					</a>
				</div>


			</div>

		</div>

	</div>


	<!-- Header -->
	<div class="container clearfix" id="b-header">
		<div class="float-start d-flex h-100">
			<!-- <img src="images/emblem-dark.png" class="align-self-center b-emblem-image" title="National Emblem of India" alt="emblem of india logo"> -->
            <?=  $this->Html->image('user/emblem-dark.png', ["class"=>"align-self-center b-emblem-image","title"=>"National Emblem of India",'alt' => 'emblem of india logo']); ?>

        </div>

		<div class="float-start d-flex h-100">
			<strong class="align-self-center pl-3"><span>राष्ट्रीय व्यापक दस्तावेज़ पंजीकरण प्रणाली </span> <br><span>National Generic Document Registration System</span></strong>
		</div>
	</div>

	<style type="text/css">
		.bar1, .bar2, .bar3 {
		    width: 25px;
		    height: 3px;
		    background-color: #fff;
		    margin: 5px 0;
		    transition: 0.4s;
		}

		.change .bar1 {
		  -webkit-transform: rotate(-45deg) translate(-5px, 5px);
		  transform: rotate(-45deg) translate(-5px, 5px);
		}

		.change .bar2 {opacity: 0;}

		.change .bar3 {
		  -webkit-transform: rotate(45deg) translate(-5px, -7px);
		  transform: rotate(45deg) translate(-5px, -7px);
		}
	</style>


	<!-- Global Navigation -->
	<div class="globalnav-bg">
		<div class="container">
			<nav class="navbar navbar-expand-sm navbar-dark px-0">
				<div class="d-flex w-100 b-nav-mobile">
					<button class="navbar-toggler align-self-center b-btn-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" onclick="myFunction(this)">
						<span style="display:none;">Menu</span>
						<div>
						  <div class="bar1"></div>
						  <div class="bar2"></div>
						  <div class="bar3"></div>
						</div>
					</button>
					<button class="btn btn-outline-light align-self-center ml-auto b-btn-login" type="button" data-toggle="modal" data-target="#login-modal">
						Log In
					</button>
				</div>

				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav main-menu d-flex">
						<li class="nav-item d-block">
                            <?= $this->html->link('Home',['controller'=>'users','action'=>'index'],['class' => "nav-link active"]);?>
                        </li>
						<li class="nav-item d-block">
                            <?= $this->html->link('About Us',['controller'=>'users','action'=>'index'],['class' => 'nav-link']);?>
                        </li>
						<li class="nav-item d-block">
                            <?= $this->html->link('Contact Us',['controller'=>'users','action'=>'index'],['class' => 'nav-link']);?>
                        </li>
						<div class="dropdown">
							<li class="nav-item d-block" data-toggle="dropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <?= $this->html->link('Road Safety +','#',['class' => 'nav-link']);?>
                            </li>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							  <a class="dropdown-item" href="index.php">Sub-nav link1</a>
							  <a class="dropdown-item" href="index.php">Sub-nav link2</a>
							  <a class="dropdown-item" href="index.php">Sub-nav link3 goes here</a>
							</div>
						  </div>
						<div class="dropdown">
							<li class="nav-item d-block" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false" data-toggle="dropdown">
                                <?= $this->html->link('Log In +','#',['class' => 'nav-link']);?>
                            </li>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?= $this->html->link('Citizen',['controller'=>'Users','action'=>'citizenLogin'],['class' => 'dropdown-item']);?>
                                <?= $this->html->link('Organization',['controller'=>'Users','action'=>'organizationLogin'],['class' => 'dropdown-item']);?>
							</div>
                        </div>
					</ul>
				</div>

			</nav>
		</div>
	</div>

	<script>
function myFunction(x) {
  x.classList.toggle("change");
}
</script>

