/*
 * Define the NetIO-Class
 *
 */
function netIOClass(provider,device) {
    this.maxport = 4;
	this.provider = provider;
	this.device = device;

}

netIOClass.prototype.toggle_light=function (port, callback) {
	$.ajax({
		url: this.provider+'?device='+this.device+'&action=toggle&port='+port,
		async: false,
		success: function(data) { callback(data) }
	});
}

netIOClass.prototype.set_light=function (port,value,callback) {
	$.ajax({
		url: this.provider+'?device='+this.device+'&action=set&port='+port+'&value='+value,
		async: false,
		success: function(data) { callback(data) }
	});
}

netIOClass.prototype.getPortName=function (port,callback) {
	$.ajax({
		url: this.provider+'?device='+this.device+'&action=name&port='+port,
		async: false,
		success: function(data) { callback(data) }
	});
}

netIOClass.prototype.getPortOnOff=function (port,callback) {
	$.ajax({
		url: this.provider+'?device='+this.device+'&action=get&port='+port,
		async: false,
		success: function(data) { callback(data) }
	});
}

netIOClass.prototype.allOn = function() {
	for (var port=1;port<=this.maxport;port++) {
			this.set_light(port,1,function(data) {});
    }
}

netIOClass.prototype.allOff =function() {
	for (var port=1;port<=this.maxport;port++) {
			this.set_light(port,0,function(data) {});
    }
}

netIOClass.prototype.queryportname=function(port,item) {
    this.getPortName(port,function(data) { $('#'+item).text(data); });
}

netIO=new netIOClass('netio.php','netio01');

