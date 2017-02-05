<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
    <title>BeeJeeTest</title>
    <meta charset="utf-8"/>

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/overlay.css"/>

	<script type="text/javascript" src="/js/bootstrap/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/js/index.js"></script>

</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" style="cursor:default;">BeeJeeTest</a>
			</div>	
			<ul class="nav navbar-nav navbar-right">
				<li><button class="btn navbar-btn">login</button></li>
			</ul>	
		</div>	
	</nav>

	<div class='container'>
		<?php include $currentTemplate; ?>
	</div>

	<div id="previewOverlay" class="overlay">
		<a href="javascript:void(0)" class="closebtn" id="closeOverlay">&times;</a>
	</div>	
</body>

</html>
