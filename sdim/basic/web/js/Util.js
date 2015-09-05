/**
 * Util class which handles reusable javascript code segments
 */
function Util() {
	
}

Util.prototype.updateCountDown = function (maxLength, inputId, labelId, e) {
	var remaining = maxLength - $(inputId).val().length;
	$(labelId).text(remaining);
	
	if (e != undefined) {
		if (e.which < 0x20) {
			return;
		}
		if ($(inputId).val().length == maxLength) {
			e.preventDefault();
		} else if ($(inputId).val().length > maxLength) {
			var value = $(inputId).val().substring(0, maxLength);
			$(inputId).val(value);
		}
	}
}

Util.prototype.popupwindow = function(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	//toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, 
	return window.open(url, title, 'scrollbars=yes, resizable=yes, width='+w+', height='+h+', top='+top+', left='+left);
}


Util.prototype.setJsFlash = function(type, message) {
	type = 'alert alert-' + type;
	var msgStr  = '<div id=\"flash-inner\" class=\"' + type +'\">';
		msgStr += '<button class=\"close\" data-dismiss=\"alert\" type=\"button\">×</button>';
		msgStr += message;
		msgStr += '</div>';
		
	$('#statusMsg').html(msgStr);
	jQuery('html, body').animate({scrollTop:0}, 'slow');
}

Util.prototype.blockUi = function() {
	$.blockUI({ css: { 
		border: 'none', 
		padding: '15px', 
		backgroundColor: '#000', 
		'-webkit-border-radius': '10px', 
		'-moz-border-radius': '10px', 
		opacity: .5, 
		color: '#fff' 
	} });
}

Util.prototype.unBlockUi = function() {
	$.unblockUI();
}

var util = new Util();