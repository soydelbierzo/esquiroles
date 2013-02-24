/*
 * ------------------------------------------------------------------
 * Copyright Volkan Özçelik - 2005 (C)
 * Mail to volkan.ozcelik@gmail.com for questions & suggestions.
 * -----------------------------------------------------------------
 */

/**
 * class PopupLayer extends DynamicLayer 
 */
PopupLayer.prototype = new DynamicLayer();
_this = PopupLayer.prototype;
function PopupLayer(elmID,strTitle) {
	/*create a draggable - non resizable layer. */
	var pop = new DraggableLayer(elmID,null,null,true);
	/* find the top container. */
	var objPop = pop.getObject();
	var children = objPop.childNodes;
	for (var i=0;i<children.length;i++ ) {
		if(children[i].className) {
			/*find console*/
			if(children[i].className=="popupConsole") {
				this._console = children[i];
				pop.ignoreLayer(""+children[i].id);
			}

			/*find drag bar*/
			if(children[i].className=="popupDragBar") {
				var dragBarChildren = children[i].childNodes;
				
				for(var j=0;j<dragBarChildren.length;j++) {
					if(dragBarChildren[j].className) {
						/*find buttons*/
						if(dragBarChildren[j].className=="popupButtonContainer") {
							var buttons = dragBarChildren[j].childNodes;
							for(var k=0;k<buttons.length;k++) {
								if(buttons[k].className) {
									if(buttons[k].className=="popupCloseIcon") {
										buttons[k].popupHandle = this;
										new StyleManager().setStyle(buttons[k],"cursor","pointer");
										new EventHandler().addEventListener(buttons[k],"click",this._closeBtn_Click);
									}
								}
							}
						}

						/*find and set title*/
						if(dragBarChildren[j].className=="popupWindowTitle") {
							if(strTitle) {
								this._title = dragBarChildren[j];
								dragBarChildren[j].innerHTML = strTitle;
							}
						}
					}
				}
			}		
		}
	}
	
	this._dl = pop;
	
	this._obj = pop.getObject();
	
	this._parent_show = this.show;
	this._parent_hide = this.hide;

	/** override show method*/
	this.show=function() {
		/* hide combos */
		new DOMManager().hideCombos();
		/*call parent object's show method. */
		this._parent_show();
	}

	/** override hide method*/
	this.hide=function() {
		/* show combos */
		new DOMManager().showCombos();
		/*call parent object's show method. */
		this._parent_hide();
	}
}
_this._closeBtn_Click=function(evt) {
	var obj = new EventHandler().getProperSourceFromEvent(evt);
	if(!obj||!obj.popupHandle) {
		return;
	}
	obj.popupHandle.hide();
};
/** overridden method */
_this.changeContent = function(strNewHTML) {
	this._console.innerHTML = strNewHTML;
};
/** overridden method */
_this.addContentBefore = function(strHTML) {
	/*just returning now and inform that the object is not complete*/
	alert("method addContentBefore has not been implemented yet! [PopupLayer]");
	return;
};
/** overridden method */
_this.addContentAfter = function(strHTML) {
	/*just returning now and inform that the object is not complete*/
	alert("method addContentAfter has not been implemented yet! [PopupLayer]");
	return;
}
_this.center = function() {
	/*quick and dirty way to get cross-browser width and height - not fully tested */
	var windowHeight = self.innerHeight?self.innerHeight:document.body.clientHeight;
	var windowWidth = self.innerWidth?self.innerWidth:document.body.clientWidth;

	this.moveTo(
		((windowWidth)/2-g_popup.getWidth()/2)-17
		,
		((windowHeight)/2-g_popup.getHeight()/2)-17
	);
};
_this.open = function(url,title) {
	if(title&&this._title) {
		this._title.innerHTML = title;
	}
	/*hide pop-up*/
	this.hide();
	/*open an HTTP request to the url*/
	var request = new XHRequest().getObject();
	request.open("GET",url);
	var eventSource = this;
	request.onreadystatechange = function() {
		if(request.readyState == 4) {
			eventSource.changeContent(request.responseText);
		}
		eventSource.show();
	}
	request.send(null);
};