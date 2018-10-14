		<!-- Footer -->
		<footer class="bg3 p-t-35 p-b-20">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-3 p-b-20">
						<h4 class="stext-301 cl0 p-b-15">
							Menu
						</h4>
						<ul>  
							<li class="p-b-5">
								<a href="./" class="stext-107 cl7 hov-cl1 trans-04">
								Inicio
								</a>
							</li>
							<li class="p-b-5">
								<a href="productos/1" class="stext-107 cl7 hov-cl1 trans-04">
								Productos
								</a>
							</li>
							<li class="p-b-5">
								<a href="novedades/1" class="stext-107 cl7 hov-cl1 trans-04">
								Nuevo Ingreso
								</a>
							</li>
							<li class="p-b-5">
								<a href="ofertas/1" class="stext-107 cl7 hov-cl1 trans-04">
								Proximamente
								</a>
							</li>
							<li class="p-b-5">
								<a href="lista-pedidos" class="stext-107 cl7 hov-cl1 trans-04">
								Lista de Pedidos
								</a>
							</li>
							<li class="p-b-5">
								<a href="contactenos" class="stext-107 cl7 hov-cl1 trans-04">
								Contactenos
								</a>
							</li>
							<li class="p-b-5">
								<a href="inventario" class="stext-107 cl7 hov-cl1 trans-04">
								Ingresar al Inventario
								</a>
							</li>
						</ul>
					</div>
					<div class="col-sm-6 col-lg-3 p-b-20">
						<h4 class="stext-301 cl0 p-b-15">
							TU CUENTA
						</h4>
						<ul>
							<li class="p-b-5">
								<a href="ingresar" class="stext-107 cl7 hov-cl1 trans-04">
								Ingresa
								</a>
							</li>
							<li class="p-b-5">
								<a href="registrese" class="stext-107 cl7 hov-cl1 trans-04">
								Regístrese 
								</a>
							</li>
						</ul>
					</div>
					<div class="col-sm-6 col-lg-3 p-b-20">
						<h4 class="stext-301 cl0 p-b-15">
							LEGAL
						</h4>
						<ul>
							<li class="p-b-5">
								<a href="condiciones-uso" class="stext-107 cl7 hov-cl1 trans-04">
								Condiciones de Uso
								</a>
							</li>
							<li class="p-b-5">
								<a href="politicas-privacidad" class="stext-107 cl7 hov-cl1 trans-04">
								Pol&iacute;ticas de Privacidad 
								</a>
							</li>
						</ul>
					</div>
					<div class="col-sm-6 col-lg-3 p-b-20 stext-107">
						<h4 class="stext-301 cl0 p-b-15">
							DIRECCION
						</h4>
						<p class="stext-107 cl7 size-201">
							<?php echo $direccion;?>
						</p>
						<div class="p-t-27">
							<?php 
							$twitter=getConfig("enlace_twitter");
							$facebook=getConfig("enlace_facebook");    
							?>
							<a href="http://www.facebook.com/<?= $facebook ?>" target=_blank"" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
							</a>
							<!-- <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
							</a>
							<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
							</a> -->
						</div>
					</div>
				</div>
				<div class="p-t-20">
					<p class="stext-107 cl6 txt-center">
						<?php echo getConfig("pie_pagina")?> | Desarrollado por: <a href="http://www.ajaxperu.com" target="_blank"> AJAXPERU</a>
					</p>
				</div>
			</div>
		</footer>
		<!-- Back to top -->
		<div class="btn-back-to-top" id="myBtn">
			<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
			</span>
		</div>
		<!-- Modal1 -->
	

		<div class="modal hide fade bd-example-modal-lg" id="myModal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 id="tituloModal" class="mtext-103 modal-title"></h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						
					</div>
					<div class="modal-body" id="cuerpoModal">
					</div>
					<div class="modal-footer" id="botoneraModal">
						
					</div>
				</div>
			</div>
		</div>
		
		<script src="assets/frontend/cki/js/jquery-ui.js"></script>
		<script>
            $(function() {
                $( "#fecha_pago" ).datepicker();
                $( "#fecha_pago" ).datepicker( "option", "dateFormat", 'dd-mm-yy');
            });
        </script>
        <script type="text/javascript" src="assets/frontend/cki/js/jquery.nyroModal-1.6.1.js"> </script>
		<!--===============================================================================================-->
		<script src="assets/frontend/cki/vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="assets/frontend/cki/vendor/bootstrap/js/popper.js"></script>
		<script src="assets/frontend/cki/vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<!-- <script src="assets/frontend/cki/vendor/select2/select2.min.js"></script>
		<script>
			$(".js-select2").each(function(){
				$(this).select2({
					minimumResultsForSearch: 20,
					dropdownParent: $(this).next('.dropDownSelect2')
				});
			})
		</script> -->
		<!--===============================================================================================-->
		<!-- <script src="assets/frontend/cki/vendor/daterangepicker/moment.min.js"></script> -->
		<!-- <script src="assets/frontend/cki/vendor/daterangepicker/daterangepicker.js"></script> -->
		<!--===============================================================================================-->
		<!-- <script src="assets/admin/charisma/js/bootstrap-modal.js"></script> -->
		<script src="assets/frontend/cki/vendor/slick/slick.min.js"></script>
		<script src="assets/frontend/cki/js/slick-custom.js"></script>
		<script src="assets/frontend/cki/js/funciones_ajax.js"></script>
		<script src="assets/frontend/cki/js/functions.js"></script>
		<!--===============================================================================================-->
		<script src="assets/frontend/cki/vendor/parallax100/parallax100.js"></script>
		<script>
			$('.parallax100').parallax100();
		</script>
		<!--===============================================================================================-->
		<script src="assets/frontend/cki/js/jquery.fancybox.min.js"></script>
		<script>
			function galeriaLB() {
				$('[data-fancybox="gallerylb"]').fancybox({
					thumbs : {
						autoStart : true
					}
				});
			}
			galeriaLB();
		</script>
		<!--===============================================================================================-->
		<!-- <script src="assets/frontend/cki/vendor/isotope/isotope.pkgd.min.js"></script> -->
		<!--===============================================================================================-->
		<!-- <script src="assets/frontend/cki/vendor/sweetalert/sweetalert.min.js"></script>
		<script>
			$('.js-addwish-b2').on('click', function(e){
				e.preventDefault();
			});
			
			$('.js-addwish-b2').each(function(){
				var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
				$(this).on('click', function(){
					swal(nameProduct, "is added to wishlist !", "success");
			
					$(this).addClass('js-addedwish-b2');
					$(this).off('click');
				});
			});
			
			$('.js-addwish-detail').each(function(){
				var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();
			
				$(this).on('click', function(){
					swal(nameProduct, "is added to wishlist !", "success");
			
					$(this).addClass('js-addedwish-detail');
					$(this).off('click');
				});
			});
			
			/*---------------------------------------------*/
			
			$('.js-addcart-detail').each(function(){
				var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
				$(this).on('click', function(){
					swal(nameProduct, "is added to cart !", "success");
				});
			});
			
		</script> -->
		<!--===============================================================================================-->
		<script src="assets/frontend/cki/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script>
			$('.js-pscroll').each(function(){
				$(this).css('position','relative');
				$(this).css('overflow','hidden');
				var ps = new PerfectScrollbar(this, {
					wheelSpeed: 1,
					scrollingThreshold: 1000,
					wheelPropagation: false,
				});
			
				$(window).on('resize', function(){
					ps.update();
				})
			});
		</script>

		<!--===============================================================================================-->
		<script src="assets/frontend/cki/js/main.js"></script>

		

	</body>
</html>