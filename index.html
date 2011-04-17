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


        function toggle_light(port) {
            netIO.toggle_light(port,function(data) {queryportstatus(port);});
        }

        function statusupdate() {
            console.log("Starting Statusupdate");
            for (var port=1;port<=netIO.maxport;port++) {
                queryportstatus(port);
            }
            /* We better use setTimeout instead of setInterval, to avoid two calls at the same time, the next trigger will be maid if the function has finished */
            console.log("Statusupdate finished");
            setTimeout("statusupdate()",10000);
        }

        function nameupdate() {
            console.log("Starting Nameupdate");
			for (var port=1;port<=netIO.maxport;port++) {
				netIO.queryportname(port,'light'+port)
			}
            /* We better use setTimeout instead of setInterval, to avoid two calls at the same time, the next trigger will be maid if the function has finished */
            console.log("Nameupdate finished");
            setTimeout("nameupdate()",60000);
        }

        function queryportstatus(port) {
            netIO.getPortOnOff(port,function(data) {
                $('#light'+port).removeClass('redButton');
	    		$('#light'+port).removeClass('greenButton');
    			if (data==1) {
    			    $('#light'+port).addClass('greenButton');
    			} else {
    			    $('#light'+port).addClass('redButton');
			    }
  			});
        }

    
        $(document).ready(function () {
            nameupdate();
            statusupdate();
			/*
			reload_lightstatus(1);
			reload_lightstatus(2);
			reload_lightstatus(3);
			reload_lightstatus(4);
			 */

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
                netIO.allOn();
                statusupdate();
            });

			$('#alloff').bind('click',function() {
				netIO.allOff();
                statusupdate();
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
    	<h2>Switches</h2>
		<p>
			<a id="light1" class="greenButton" href="#" >Light 1</a>
			<a id="light2" class="greenButton" href="#" >Light 2</a>
			<a id="light3" class="greenButton"  href="#" >Light 3</a>
			<a id="light4" class="greenButton" href="#" >Light 4</a>
		</p>
    	<h2>Groupcommands</h2>
    	<ul class="individual">
    		<li class="arrow"><a id="allon" class="bluebutton" href="#">All on</a></li>
    		<li class="arrow"><a id="alloff" class="bluebutton" href="#">All off</a></li>
        </ul>
	</div>
<!--	<div class="info">
		Das ist mein Text
	</div>-->
</div>

<div id="about">
	<div class="toolbar">
		<a class="button back" href='#' >Back</a>
		<h1>About</h1>
	</div>
	<div class="content">
        <h2>Light-Control</h2>
        <p>
        Lightcontrol is intended to be used as a small Application to control <a href="http://www.koukaam.se/showproduct.php?article_id=1502" target='_blank'>NetIO230-B</a> devices via your Smartphone.<br/>
        This software is only for testing purpose. No warranty is given.
        </p>
        <h2>About</h2>
        <p>
        Author: Walter Werther<br/>
        Version: v0.5<br/>
        Source: <a target='_blank' href="https://github.com/wwerther/NetIo230-Control">GitHub WWerther/NetIo230-Control</a><br/>
        </p>
        <p>
            <br/>(c) 2011 Walter Werther
        </p>
	</div>
<!--	<div class="info">
		Das ist mein Text
	</div>-->
</div>
<div id="settings">
	<div class="toolbar">
		<a class="button back" href="#">Back</a>
		<h1>Settings</h1>
	</div>
	<div class="content">
		<p>Currently this page does not allow to define any settings. This might change in a future version</p>
		<ul class="edgetoedge">
			<li class="arrow"><a href="#">Device</a></li>
			<li class="arrow"><a href="#">Names</a></li>
		</ul>
	</div>
</div>
</div>
</body>
</html>
