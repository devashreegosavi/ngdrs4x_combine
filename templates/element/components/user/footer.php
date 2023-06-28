
	<!----------- Footer ------------>
	<div class="footer-bs">
	    <footer class="container">
	        <div class="row">
	        	<div class="row col-md-7 col-sm-12 footer-nav">
	            	<p class="col-md-12">Quick Links —</p>
	            	<div class="col-sm-6">
	                    <ul class="list">
	                        <li><a href="inner.html">About Us</a></li>
	                        <li><a href="contactus.html">Contact Us</a></li>
	                        <li><a href="inner.html">Help</a></li>
	                    </ul>
	                </div>
	                <div class="col-sm-6">
	                    <ul class="list">
	                    	<li data-toggle="modal" data-target="#feedback-modal"><a href="javascript:void(0)">Feedback</a></li>
	                        <li><a href="inner.html">Terms & Condition</a></li>
	                        <li><a href="javascript:void(0);">Privacy Policy</a></li>
	                    </ul>
	                </div>
	            </div>
	        	<div class="col-md-3 col-sm-8 footer-social d-flex">
        			<div class="d-inline-block align-self-center">
	        			<p class="bg-light">
                            <!-- <img src="images/NIC.png" alt="NIC logo"> -->
                            <?=  $this->Html->image('user/NIC.png', ["title"=>"NIC logo",'alt' => 'NIC logo']); ?>

                        </p>
	        			<p class="bg-light mb-0">
                            <!-- <img src="images/digital-india.png" alt="digital india logo"> -->
                            <?=  $this->Html->image('user/digital-india.png', ["title"=>"digital india logo",'alt' => 'digital india logo']); ?>

                        </p>
	        		</div>
	            </div>
	        	<div class="col-md-2 col-sm-4 footer-ns d-flex">
	        			<a class="backtotop align-self-center d-flex text-center text-decoration-none text-white" title="Back to top" href="#b-accessibility">
	        				<span style="display:none;">Back to top</span>
		            		<span style="font-size: 24px;" class="fas fa-angle-up align-self-center mx-auto"></span>
		            	</a>
	            </div>
	        </div>
	        <div class="text-center mt-5">
	        	Website Content Managed by <a class="text-light fw-bold" href="https://www.nic.in/">National Informatics Centre</a>, <a class="text-light fw-bold" href="https://meity.gov.in/">Ministry of Electronics and IT</a>, <a class="text-light fw-bold" href="https://www.india.gov.in/">Govt. of India.</a>
	        </div>
	    </footer>
	</div>



  <!-- Bootstrap core JavaScript -->
  <!-- <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/jquery.slicknav.min.js"></script> -->

<?= $this->Html->script(['user/popper.min','../vendor/jquery/jquery.min','../vendor/bootstrap/js/bootstrap.bundle.js','user/jquery.slicknav.min.js']); ?>
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>


  <script>
	  	$(document).ready(function() {
	  		$(".b-navdropdown-click").click(function() {
	  			if($(".b-navdropdown").hasClass("hide")) {
	  				$(".b-navdropdown").addClass("show");
	  				$(".b-navdropdown").removeClass("hide");
	  				// $(".b-icon-up").show();
	  				// $(".b-icon-down").hide();
	  			}
	  			else if($(".b-navdropdown").hasClass("show")) {
	  				$(".b-navdropdown").addClass("hide");
	  				$(".b-navdropdown").removeClass("show");
	  				// $(".b-icon-down").show();
	  				// $(".b-icon-up").hide();
	  			}
			});
	  	});


    </script>

