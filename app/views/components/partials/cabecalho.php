<?php

use app\facade\App;
use app\services\PermissionService;

$session = App::authSession()->get();


?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?= @$config->nome ?><?= $title ? " - " . $title:''  ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="" type="image/x-icon">
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="<?= asset("/css/bootstrap.css") ?>" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="<?= asset("/css/style.css") ?>" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="<?= asset("/css/font-awesome.css") ?>" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='<?= asset("/css/SidebarNav.min.css") ?>' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<!-- js-->
	<script src="<?= asset("/js/jquery-1.11.1.min.js") ?>"></script>
	<script src="<?= asset("/js/modernizr.custom.js") ?>"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="<?= asset("/js/Chart.js") ?>"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="<?= asset("/js/metisMenu.min.js") ?>"></script>
	<script src="<?= asset("/js/custom.js") ?>"></script>
	<link href="<?= asset("/css/custom.css") ?>" rel="stylesheet">
	<!--//Metis Menu -->
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="<?= asset("/js/pie-chart.js") ?>" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#8e43e7',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#ffc168',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->
	<link rel="stylesheet" href="<?= asset("/css/DataTables.css") ?>">
	<script defer src="<?= asset("/js/DataTables.min.js") ?>" type="text/javascript"></script>
	<script defer type="text/javascript" src="<?= asset("/js/errorMessages.js") ?>"></script>
	<script defer type="text/javascript" src="<?= asset("/js/ajax.js") ?>"></script>
	
	
</head> 

<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">
				<?php component('MenuLateral.Menu') ?>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">
						<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">4</span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>You have 3 new messages</h3>
									</div>
								</li>
								<li><a href="#">
									<div class="user_img"><img src="images/1.jpg" alt=""></div>
									<div class="notification_desc">
										<p>Lorem ipsum dolor amet</p>
										<p><span>1 hour ago</span></p>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<li class="odd"><a href="#">
									<div class="user_img"><img src="images/4.jpg" alt=""></div>
									<div class="notification_desc">
										<p>Lorem ipsum dolor amet </p>
										<p><span>1 hour ago</span></p>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<li><a href="#">
									<div class="user_img"><img src="images/3.jpg" alt=""></div>
									<div class="notification_desc">
										<p>Lorem ipsum dolor amet </p>
										<p><span>1 hour ago</span></p>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<li><a href="#">
									<div class="user_img"><img src="images/2.jpg" alt=""></div>
									<div class="notification_desc">
										<p>Lorem ipsum dolor amet </p>
										<p><span>1 hour ago</span></p>
									</div>
									<div class="clearfix"></div>	
								</a></li>
								<li>
									<div class="notification_bottom">
										<a href="#">See all messages</a>
									</div> 
								</li>
							</ul>
						</li>
						


					</ul>
					<div class="clearfix"> </div>
				</div>
				
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="<?= @$session->foto ? uploaded(@$session->foto):asset("/images/sem-foto.jpg") ?>" alt="" width="50px" height="50px"> </span> 
									<div class="user-name esc">
										<p><?= @$session->nome ?></p>
										<span><?= @$session->nivel ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<?php if(PermissionService::has("config")): ?>
									<li> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
								<?php endif ?>
								<?php if(PermissionService::has('perfil')): ?>
									<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								
								<?php endif; ?>
								<li> <a href="<?= route("/logout") ?>"><i class="fa fa-sign-out"></i> Sair</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->