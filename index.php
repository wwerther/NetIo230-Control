<html xmlns="http://www.w3.org/1999/xhtml" charset="utf-8">
<head>
	<title>Light-Control</title>
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	<meta name="viewport" content="width=846px" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link href="jqtouch/jqtouch.css" style type="text/css" rel="stylesheet" media="screen" />
	<link href="themes/apple/theme.css" style type="text/css" rel="stylesheet" media="screen" />
	<script type="text/javascript" src="jqtouch/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="jqtouch/jqtouch.js" charset="utf-8"></script>
	<script type="text/javascript" src="netio.js" charset="utf-8"></script>
	<script type="application/x-javascript" >

		var jQT=$.jQTouch({
			icon: 'jqtouch.png',
			statusBar: 'black',
		});

		$(document).ready(function () {

			reload_lightstatus(1);
			reload_lightstatus(2);
			reload_lightstatus(3);
			reload_lightstatus(4);

			setTimeout("periodic_reload(3000)",3000);

			$('#light1').bind('click',function() {
					toggle_light(1);
			});

			$('#light2').bind('click',function() {
					toggle_light(2);
			});

			$('#light3').bind('click',function() {
					toggle_light(3);
			});

			$('#light4').bind('click',function() {
					toggle_light(4);
			});

			$('#allon').bind('click',function() {
					all_on();
			});
			$('#alloff').bind('click',function() {
					all_off();
			});
		});
	</script>
	<style type="text/css">
		.content {
			margin: 20px, 10px;
		}
		.content p {
			line-height: 150%;
		}
	</style>
</head>
<body>
<div id="jqt">
<div id="home">
	<div class="toolbar">
		<a class="button leftButton" href="#settings" >Settings</a>
		<h1>Light-Control</h1>
		<a class="button" href="#about" >About</a>
	</div>
	<div class="content">
		<p>
			<a id="light1" class="greenButton" href="#" >Light 1</a>
			<a id="light2" class="greenButton" href="#" >Light 2</a>
			<a id="light3" class="greenButton"  href="#" >Light 3</a>
			<a id="light4" class="greenButton" href="#" >Light 4</a>
		</p>
	</div>
	<h2>Navigation</h2>
	<ul class="individual">
		<li class="arrow"><a id="allon" class="bluebutton" href="#">All on</a></li>
		<li class="arrow"><a id="alloff" class="bluebutton" href="#">All off</a></li>
	</ul>
	<div class="info">
		Das ist mein Text
	</div>
</div>

<div id="about">
	<div class="toolbar">
		<a class="button back" href='#' >Zur&uuml;ck</a>
		<h1>Light-Control</h1>
	</div>
	<div class="content">
		<p>Das ist mein About Dialog</p>
	</div>
</div>
<div id="settings">
	<div class="toolbar">
		<a class="button back" href="#">Zur&uuml;ck</a>
		<h1>Settings</h1>
	</div>
	<div class="content">
		<p>Bitte hier die Einstellungen vornehmen</p>
		<ul class="edgetoedge">
			<li class="arrow"><a href="#about">&Uuml;ber...</a></li>
		</ul>
	</div>
</div>
</div>
</body>
</html>
