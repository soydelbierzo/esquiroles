/*
 *------------------------------------------------------------------
 * Copyright Volkan Özçelik - 2005 (C)
 * Mail to volkan.ozcelik@gmail.com for questions & suggestions.
 * -----------------------------------------------------------------
 */

/**
 * DOMManager
 * Includes several DOM utility functions.
 */
var _this=DOMManager.prototype;
function DOMManager() {}
_this.hideCombos = function() {
	var arCombo = document.getElementsByTagName("select");
	for(var i=0;i<arCombo.length;i++) {
		arCombo[i].style.visibility="hidden";
	}
}
_this.showCombos = function() {
	var arCombo = document.getElementsByTagName("select");
	for(var i=0;i<arCombo.length;i++) {
		arCombo[i].style.visibility="inherit";
	}
}