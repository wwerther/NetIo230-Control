		function toggle_light(port) {
			$.ajax({
				url: 'netio.php?action=toggle&port='+port,
				async: false,
				success: function(data) {
					reload_lightstatus(port);
				}
			});
		};

		function set_light(port,value) {
			$.ajax({
				url: 'netio.php?action=set&port='+port+'&value='+value,
				async: false,
				success: function(data) {
					reload_lightstatus(port);
				}
			});
		};

		function queryportname(port) {
			$.ajax({
				url: 'netio.php?action=name&port='+port,
				async: false,
				success: function(data) {
    					$('#light'+port).text(data);
  				}
			});
		}

		function queryportstatus(port) {
			$.ajax({
				url: 'netio.php?action=get&port='+port,
				async: false,
				success: function(data) {
    					$('#light'+port).removeClass('redButton');
					$('#light'+port).removeClass('greenButton');
					if (data==1) {
						$('#light'+port).addClass('greenButton');
					} else {
						$('#light'+port).addClass('redButton');
					}
  				}
			});
		}

		function reload_lightstatus(port) {
			queryportname(port);
			queryportstatus(port);
		}

		function all_on() {
			set_light(1,1);
			set_light(2,1);
			set_light(3,1);
			set_light(4,1);
			reload_lightstatus(1);
			reload_lightstatus(2);
			reload_lightstatus(3);
			reload_lightstatus(4);
		}

		function all_off() {
			set_light(1,0);
			set_light(2,0);
			set_light(3,0);
			set_light(4,0);
			reload_lightstatus(1);
			reload_lightstatus(2);
			reload_lightstatus(3);
			reload_lightstatus(4);
		}

		function periodic_reload(time) {
			reload_lightstatus(1);
			reload_lightstatus(2);
			reload_lightstatus(3);
			reload_lightstatus(4);
			setTimeout("periodic_reload()",time);
		}

