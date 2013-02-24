/*
 *------------------------------------------------------------------
 * Copyright Volkan Özçelik - 2005 (C)
 * Mail to volkan.ozcelik@gmail.com for questions & suggestions.
 * -----------------------------------------------------------------
 */

/**
 * XHRequest
 * Wraps and XMLHTTPRequest object in a cross-browser manner.
 */
_this = XHRequest.prototype;
function XHRequest(){}
_this.getObject = function() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	else {
		alert("XML HTTP Request support cannot be found!");
		return null;
	}
}