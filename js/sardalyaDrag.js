/*
 * -----------------------------------------------------------------
 *
 * Author      : Volkan Özçelik (volkan.ozcelik@gmail.com)
 *
 * Copyright   : 2003-2005(C)-sarmal.com-http://www.sarmal.com
 *
 * -----------------------------------------------------------------
 *
 * Description :
 *
 * Supplementary code for drag & drop support.
 * The code below is a part of sardalya DHTML library.
 * You can find the entire API at http://www.sarmal.com/sardalya
 *
 * -----------------------------------------------------------------
 *
 * License     :
 *
 * This file is distributed under
 * "Attribution-NonCommercial-ShareAlike 2.0 
 *	(http://creativecommons.org/licenses/by-nc-sa/2.0/)"
 * license.
 *
 * See http://www.sarmal.com/sardalya/kullanim_sartlari.html 
 * for terms of use (the page is bilingual).
 *
 * You are free to spread the word around.
 * If you find this script useful, why not help others?
 *
 * -----------------------------------------------------------------
 *
 * Feedback    :
 *
 * For any suggestions and comments:
 * mailto: volkan.ozcelik@gmail.com
 *
 * ----------------------------------------------------------------
 */

/** 
 * Constant 
 * Includes constant definitions used throughout the API.	
 */
var Constant={
	Mouse:{
		DRAG:0,
		RESIZE:1,
		DOWN:3
	},
	Key:{
		DOWN:2
	},
	NodeType:{TEXT:3},
	NOT_INITED:-1
};

/** 
 * Dimension 
 * Creates a two-dimensional entity.
 */
_this = Dimension.prototype;
function Dimension(x,y){
	this._x=x;
	this._y=y;
}
_this.getX=function(){
	return this._x;
};
_this.setX=function(x){
	this._x=x;
};
_this.getY=function(){
	return this._y;
};
_this.setY=function(y){
	this._y=y;
};
_this.equals=function(anotherDimension){
	return this.getX()==anotherDimension.getX()&&this.getY()==anotherDimension.getY();
};
_this.toString=function(){
	return "("+this.getX()+","+this.getY()+")";
};

/** 
 * Constraint 
 * Hold two "Dimension" objects to be used as upper bounds
 * and lower bounds.
 */
_this=Constraint.prototype;
function Constraint(intMinLower,intMinUpper,intMaxLower,intMaxUpper){
	this._lowerBound=new Dimension(intMinLower,intMinUpper);
	this._upperBound=new Dimension(intMaxLower,intMaxUpper);
}
_this.getUpperBound=function(){
	return this._upperBound;
};
_this.getLowerBound=function(){
	return this._lowerBound;
};

/** 
 * Array 
 * Additional prototype methods for Array object.
 * Some of them are unnecessary since Array object
 * already supports them.
 * It will be removed in further versions of the API.
 */
_this=Array.prototype;
if(!_this.push){
	_this.push=function(){
		for(var i=0;i<arguments.length;i++)
			this[this.length]=arguments[i];
		return this.length;
	};
}
if(!_this.pop){
	_this.pop=function(){
		var lastElement=this[this.length-1];
		this.length=Math.max(this.length-1,0);
		return lastElement;
	};
}
if(!_this.copy){
	_this.copy=function(){
		var arcopy=new Array();
		for (var i=0;i<this.length;i++)
			arcopy[i]=this[i];
		return arcopy;
	};
}
if(!_this.indexOf){
	_this.indexOf=function(elm){
		for(var i=0;i<this.length;i++)
			if(elm==this[i])
				return i;
		return -1;
	};
}
if(!_this.contains){
	_this.contains=function(elm){
		return this.indexOf(elm)!=-1;
	};
}

/** 
 * Validator 
 * Basically used for html form validations.
 */
_this=Validator.prototype;
function Validator(){}
_this.isDefined=function(x){
	return typeof(x)!="undefined";
};	
_this.isEmpty=function(x){
	if(!this.isDefined(x))
		return false;
	if(this.isNumeric(x))
		return false;
	if(x=="")
		return true;
	return false;
};
_this.isEmail=function(x){
	if(!this.isDefined(x))
		return false;
	return /^[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*\.([A-Za-z]){2,4}$/ig.test(x);
};
_this.isWhiteSpace=function(x){
	if(!this.isDefined(x)) 
		return false;
	return /^\s*$/.test(x);
};
_this.isInteger=function(x){
	if(!this.isDefined(x))
		return false;
	x=(""+x).replace(/\.0*$/g,"");
	var intNumber=parseInt(x);
	if(!isNaN(intNumber)){
		x=x.remove(/^0*/);
		if(x=="")x=0;
	}
	intNumber=parseInt(x);
	if((!isNaN(intNumber))&&((""+intNumber)==x))
		return true;
	return false;
};
_this.isFloat=function(x){
	if(!this.isDefined(x))
		return false;
	x=(""+x).replace(/,/g,".");
	return x!=""&&!isNaN(x);
};
_this.isNumeric=function(x){
	return this.isFloat(x);
};
_this.isString=function(x){
	if(!this.isDefined(x))
		return false;
	return typeof(x)=="string";
};
_this.isDate=function(intYear,intMonth,intDay){
	if(!this.isDefined(intYear)||!this.isDefined(intMonth)||!this.isDefined(intDay)||
			this.isEmpty(intYear)||this.isEmpty(intMonth)||this.isEmpty(intDay))
		return false;
	var arMonth=new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	if((parseInt(intYear)%4==0&&parseInt(intYear)%100!=0)||parseInt(intYear%400)==0)
		arMonth[1]=29;
	else 
		arMonth[1]=28;
	var intMaxDay=arMonth[parseInt(intMonth)-1];
	if(parseInt(intDay)>intMaxDay)
		return false;return true;
};
_this.isPositive=function(x){
	if(!this.isNumeric(x))
		return false;
	return parseFloat(x)>=0;
};
_this.isPositiveStrict=function(x){
	if(!this.isNumeric(x))
		return false;
	return parseFloat(x)>0;
};
_this.isNegative=function(x){
	if(!this.isNumeric(x))
		return false;
	return parseFloat(x)<=0;
};
_this.isNegativeStrict=function(x){
	if(!this.isNumeric(x))
		return false;
	return parseFloat(x)<0;
};

/** 
 * String 
 * Additional String prototype methods.
 */
_this=String.prototype;
_this.trim=function(blnIgnoreCarriage,blnIgnoreInnerWhiteSpace){
	var temp=this.replace(/^\s*/,"");
	temp=temp.replace(/\s*$/,"");
	blnIgnoreCarriage=blnIgnoreCarriage?true:false;
	blnIgnoreInnerWhiteSpace=blnIgnoreInnerWhiteSpace?true:false;
	if(blnIgnoreCarriage&&blnIgnoreInnerWhiteSpace)
		;
	else if(blnIgnoreCarriage&&!blnIgnoreInnerWhiteSpace){
		temp=temp.replace(/\t+/g," ");
		temp=temp.replace(/ +/g," ");
	}
	else if(!blnIgnoreCarriage&&blnIgnoreInnerWhiteSpace)
		temp=temp.replace(/(\r\n|\n\r|\n|\r)+/g,"");
	else if(!blnIgnoreCarriage&&!blnIgnoreInnerWhiteSpace)
		temp=temp.replace(/\s+/g," ");
	if(temp==" ")temp="";
	return temp;
};
_this.remove=function(varRegExp,strOption){
	var regEx;
	if(new Validator().isString(varRegExp))
		regEx=new RegExp(varRegExp,strOption?strOption:"g");
	else regEx=varRegExp;	
	return this.replace(regEx,"");
};
_this.removeTags=function(){
	return this.replace(/<[\/]?([a-zA-Z0-9]+)[^>^<]*>/ig,"");
};

/** 
 * CBObject 
 * Wraps document.getElementById and
 * provides an additional object check.
 * It accepts the object itself or its DHTML index
 * as per the paremeter to the constructor.
 */
_this=CBObject.prototype;
function CBObject(elmID){
	this._val=new Validator();
	this._obj=this._getObject(elmID);
}
_this.exists=function(){
	return this.getObject()!=null;
};
_this.getObject=function(){
	return this._obj;
};
_this.getID=function(){
	if(this.exists())
		return this.getObject().id;
	else return null;
};
_this._getObject=function(elmID){
	if(!this._val.isString(elmID))
		return elmID;
	else return document.getElementById(elmID);
};

/** 
 * CoookieManager 
 * Sets/gets cookies.
 */
_this=CookieManager.prototype;
function CookieManager(){}
_this.set=function(strName,strValue,intDays){
	var strExpires="",dtDate=new Date();
	if(!new Validator().isDefined(document.cookie))
		return;
	if(intDays){
		dtDate.setTime(dtDate.getTime()+(intDays*24*60*60*1000));
		strExpires="; expires="+dtDate.toGMTString();
	}
	else 
		strExpires="";
	document.cookie=strName+"="+strValue+strExpires+"; path=/";
};
_this.get=function(strName){
	if(!document.cookie)
		return null;
	var strSeek=strName+"=",strCookie="",aryCookie=document.cookie.split(";");
	for(var i=0;i<aryCookie.length;i++){
		strCookie=aryCookie[i];
		while(strCookie.charAt(0)==" ")
			strCookie=strCookie.substring(1,strCookie.length);
		if(strCookie.indexOf(strSeek)==0)
			return strCookie.substring(strSeek.length, strCookie.length);
	}
	return null;
};

/** 
 * StyleManager 
 * Sets/gets/remembers styles/stylesheets.
 */
_this=StyleManager.prototype;
function StyleManager(){
	this._cm=new CookieManager();
	this._val=new Validator();
}
_this.getStyle=function(elmID,cssProperty,cssPropertyExtended){
	var obj=new CBObject(elmID).getObject();
	if(!this.sanityCheck(obj,cssProperty))
		return null;
	if(obj.currentStyle)
		return obj.currentStyle[cssProperty];
	if(window.getComputedStyle)
		return window.getComputedStyle(obj,"").getPropertyValue(cssPropertyExtended);
	if(this._val.isDefined(obj.style))
		return eval("obj.style."+cssProperty);
};
_this.setStyle=function(elmID,cssProperty,value){
	var obj=new CBObject(elmID).getObject();
	if(!this.sanityCheck(obj,cssProperty))
		return;
	eval("obj.style."+cssProperty+"='"+value+"';");
};
_this.setClass=function(elmID,cssClass){
	new CBObject(elmID).getObject().className=cssClass;
};
_this.getClass=function(elmID){
	return new CBObject(elmID).getObject().className;
};
_this.activateAlternateStyleSheet=function(strTitle){
	var objLink=null;
	for(var i=0;true;i++){
		if(!document.getElementsByTagName("link")[i])
			break;
		objLink=document.getElementsByTagName("link")[i];
		if(objLink.getAttribute("rel").indexOf("style")!=-1&&objLink.getAttribute("title"))
			objLink.disabled=true;
		if(objLink.getAttribute("title")==strTitle)
			objLink.disabled=false;
	}
};
_this.remember=function(strTitle){
	this._cm.set("alternateCSS",strTitle,14);
};
_this.recall=function(){
	var strTitle=this._cm.get("alternateCSS");
	if(strTitle)
		this.activateAlternateStyleSheet(strTitle);
};
_this.sanityCheck=function(obj,cssProperty){
	return new Validator().isDefined(eval("obj.style."+cssProperty));
};

/** 
 * EventRegistry 
 * A registry for the event handler, which enables
 * automatic detachment of events on window unload.
 */
_this=EventRegistry.prototype;
var g_arEvent=new Array();
function EventRegistry(){}
_this.add=function(objEventModel){
	g_arEvent.push(objEventModel);
};
_this.removeAll=function(){
	while(g_arEvent.length>0)
		g_arEvent.pop().unregister();
};
document.eventRegistry=new EventRegistry();

/** 
 * EventModel 
 * A helper object that is used for transportation of
 * events from EvenHandler to EventRegistry.
 */
_this=EventModel.prototype;
function EventModel(elmID,strEventType,fncEventListener,objEventHandler){
	this._elmID=elmID;
	this._strEventType=strEventType;
	this._fncEventListener=fncEventListener;
	this._eh=objEventHandler;
}
_this.unregister=function(){
	this._eh.removeEventListener(this._elmID,this._strEventType,this._fncEventListener);
};

/** 
 * EventHandler 
 * Enables cross-browser attachment of events.
 */
_this=EventHandler.prototype;
document.getProperSourceFromEvent=function(evt,blnDragLayer){
	var e=evt?evt:window.event,src=e.srcElement?e.srcElement:(e.target?e.target:null),
		tag="",
		v=new Validator();
	if(blnDragLayer&&src.tagName){
		tag=src.tagName.toLowerCase();	
		if(tag=="textarea"||tag=="input")
			return null;
		while(true){
			if(src.id){
				for(i=0;i<g_arDragIgnoreID.length;i++)
					if(src.id==g_arDragIgnoreID[i])
						return null;
				if(g_arDraggableLayer[src.id])
					return src;
			}
			if(src.parentNode)
				src=src.parentNode;
			else 
				return null;
			if(!src.tagName)
				return null;
			if(!v.isDefined(src.tagName)||src.tagName=="")
				break;
		}
	}
	return src;
};
function EventHandler(){
	this._val=new Validator();
	this._reg=document.eventRegistry;
	this.addEventListener(window,"unload",this._unregister,true);
}
_this.addEventListener=function(elmID,strEventType,fncEventListener,blnBypassRegistry){
	var v=this._val,
		obj=v.isString(elmID)?new CBObject(elmID).getObject():elmID;
	if(!obj)
		return;
	strEventType=strEventType.toLowerCase();
	if(v.isDefined(obj.addEventListener))
		obj.addEventListener(strEventType,fncEventListener,false);
	else if(v.isDefined(obj.attachEvent))
		obj.attachEvent("on"+strEventType,fncEventListener);
	else 
		alert("ERROR: unknown event-listener!");

	if(!blnBypassRegistry&&typeof(this._reg)!="undefined"&&this._reg)
		this._reg.add(new EventModel(elmID,strEventType,fncEventListener,this));
};
_this.getProperSourceFromEvent=function(evt,blnDragLayer){
	return document.getProperSourceFromEvent(evt,blnDragLayer);
};
_this.removeEventListener=function(elmID,strEventType,fncEventListener){
	var v=this._val,obj=v.isString(elmID)?new CBObject(elmID).getObject():elmID;
	if(!obj)
		return;
	strEventType=strEventType.toLowerCase();
	if(obj.removeEventListener)
		obj.removeEventListener(strEventType,fncEventListener,false);
	else if(obj.detachEvent)
		obj.detachEvent("on"+strEventType,fncEventListener);
	else alert("ERROR: event cannot be detached!");
};
_this._unregister=function(){
	if(document.eventRegistry)document.eventRegistry.removeAll();
};

/** 
 * CursorTracker 
 * Tracks the cursor coordinates.
 * Especially used for getting drag&drop coordinates.
 */
_this=CursorTracker.prototype;
function CursorTracker(){
	this._handler=new EventHandler();this._construct();
}
_this.getCursorPosition=function(){
	return document._cursorCoordinates;
};
_this.destruct=function(){
	this._handler.removeEventListener(document,"mousemove",this._getCursorPosition,false);
};
_this.toString=function(){
	return document._cursorCoordinates;
};
_this._construct=function(){
	this._handler.addEventListener(document,"mousemove",this._getCursorPosition,false);
};
_this._getCursorPosition=function(evt){
	var posx=0,
		posy=0,
		topOffset=0,
		leftOffset=0,
		e=evt?evt:window.event;
	if(e.pageX||e.pageY){
		posx=e.pageX;
		posy=e.pageY;
	}
	else if(e.clientX||e.clientY){
		if(document.documentElement){
			if(new Validator().isDefined(document.body.scrollLeft)){
				leftOffset=Math.max(document.body.scrollLeft,document.documentElement.scrollLeft);
				topOffset=Math.max(document.body.scrollTop,document.documentElement.scrollTop);
			}
			else{
				leftOffset=document.documentElement.scrollLeft;
				topOffset=document.documentElement.scrollTop;
			}
			posx=e.clientX+leftOffset;
			posy=e.clientY+topOffset;
		}
		else{
			posx=e.clientX+document.body.scrollLeft;
			posy=e.clientY+document.body.scrollTop;
		}
	}
	if(!document._cursorCoordinates){
		document._cursorCoordinates=new Dimension(posx, posy);
	}
	else{
		document._cursorCoordinates.setX(posx);
		document._cursorCoordinates.setY(posy);
	}
};

/** 
 * LayerObject
 * Wrapper for a DHTML Layer.
 */
LayerObject.prototype=new CBObject();
_this=LayerObject.prototype;
function LayerObject(elmID){
	this._obj=new CBObject(elmID).getObject();
	this._sm=new StyleManager();
}
_this.setStyle=function(strSelector,strValue){
	var obj=null;
	if(!(obj=this.getObject()))
		return;
	this._sm.setStyle(obj,strSelector,strValue);
};
_this.getStyle=function(strSelector,strSelectorExtended){
	var obj=null;
	if(!(obj=this.getObject()))
		return;
	return this._sm.getStyle(obj,strSelector,strSelectorExtended);
};
_this.isVisible=function(){
	return this.getStyle("visibility","visibility")=="visible"&&this.getStyle("display","display")!="none";
};
_this.show=function(){
	this.setStyle("visibility","visible");
};
_this.hide=function(){
	this.setStyle("visibility","hidden");
};
_this.collapse=function(){
	this.setStyle("display","none");
};
_this.expand=function(){
	this.setStyle("display","block");
};
_this.changeContent=function(strNewHTML){
	var obj=null;
	if(!(obj=this.getObject()))
		return;
	if(obj.innerHTML)
		obj.innerHTML=strNewHTML;
};
_this.addContentBefore=function(strHTML){
	var obj=null;
	if(!(obj=this.getObject()))
		return;
	if(obj.innerHTML)
		this.changeContent(strHTML+obj.innerHTML);
};
_this.addContentAfter=function(strHTML){
	var obj=null;
	if(!(obj=this.getObject()))
		return;
	if(obj.innerHTML)
		this.changeContent(obj.innerHTML+strHTML);
};

/** 
 * DynamicLayer
 * Adds some functionality to LayerObject.
 */
DynamicLayer.prototype=new LayerObject();
_this=DynamicLayer.prototype;
function DynamicLayer(elmID){
	this._obj=new CBObject(elmID).getObject();
	this._val=new Validator();
}
_this.moveTo=function(intLeft,intTop){
	this.setLeft(intLeft);this.setTop(intTop);
};
_this.resizeTo=function(intWidth,intHeight){
	this.setWidth(intWidth);
	this.setHeight(intHeight);
};
_this.getLeft=function(){
	var intLeft=parseInt(this.getStyle("left","left"));
	return this._val.isNumeric(intLeft)?intLeft:0;
};
_this.setLeft=function(intLeft){
	this.setStyle("left",intLeft+"px");
};
_this.getTop=function(){
	var intTop=parseInt(this.getStyle("top","top"));
	return this._val.isNumeric(intTop)?intTop:0;
};
_this.setTop=function(intTop){
	this.setStyle("top",intTop+"px");
};
_this.getHeight=function(){
	var obj=null,
		v=this._val;
	if(!(obj=this.getObject()))
		return 0;
	if(v.isDefined(obj.offsetHeight))
		return obj.offsetHeight;
	return 0;
};
_this.setHeight=function(intHeight){
	var obj=null,
		v=this._val,
		intDifference=0,
		intCssHeight=0;
	if(!(obj=this.getObject()))
		return;
	if(v.isDefined(obj.offsetHeight)){
		this.setStyle("height",intHeight+"px");
		intDifference=(obj.offsetHeight-intHeight);
	}
	if(!v.isNumeric(intDifference))
		intDifference=0;
	intCssHeight=intHeight-intDifference;
	if(!v.isPositive(intCssHeight))
		return;
	this.setStyle("height",intCssHeight+"px");
};
_this.getWidth=function(){
	var obj=null,
		v=this._val;
	if(!(obj=this.getObject()))
		return 0;
	if(v.isDefined(obj.offsetWidth))
		return obj.offsetWidth;
	return 0;
};
_this.setWidth=function(intWidth){
	var obj=null,
		v=this._val,
		intDifference=0,
		intCssWidth=0;
	if(!(obj=this.getObject()))
		return;
	if(v.isDefined(obj.offsetWidth)){
		this.setStyle("width",intWidth+"px");
		intDifference=(obj.offsetWidth-intWidth);
	}
	if(!v.isNumeric(intDifference))
		intDifference=0;
	intCssWidth=intWidth-intDifference;
	if(!v.isPositive(intCssWidth))return;
	this.setStyle("width",intCssWidth+"px");
};

/** 
 * DraggableLayer 
 * Creates a layer that you can drag & resize.
 * The layer should either be relatively or absolutely
 * positioned to be draggable.
 */
var g_currentAction=-1,
	g_blnDragStrict=false,
	g_currentKeyState=-1,
	g_currentMouseState=-1,
	g_dragActiveElement=null,
	g_dragBeginCoord=null,
	g_dragLT=null,
	g_dragWH=null,
	g_dragCursor=null,
	g_blnDragConstructed=false,
	g_arDraggableLayer=new Array(),
	g_arDragIgnoreID=new Array(),
	g_arDragID=new Array(),
	g_arDragConstraint=new Array(),
	g_arDragConstraintResize=new Array(),
	g_arDragAction=new Array();
DraggableLayer.prototype=new DynamicLayer();
_this=DraggableLayer.prototype;
function DraggableLayer(elmID,constraintMove,constraintResize,blnNoResize){
	this._eh=new EventHandler();
	this._obj=new CBObject(elmID).getObject();
	g_arDragAction[this.getID()]=Constant.NOT_INITED;
	if(!g_dragCursor)
		g_dragCursor=new CursorTracker();
	if(constraintMove)
		g_arDragConstraint[this.getID()]=constraintMove;
	if(constraintResize)
		g_arDragConstraintResize[this.getID()]=constraintResize;
	if(blnNoResize)
		g_arDragConstraintResize[this.getID()]=new Constraint(this.getWidth(),this.getHeight(),this.getWidth(),this.getHeight());
	this.ACT_DRAG=Constant.Mouse.DRAG;
	this.ACT_RESIZE=Constant.Mouse.RESIZE;
	this.KEY_DOWN=Constant.Key.DOWN;
	this.MOUSE_DOWN=Constant.Mouse.DOWN;
	this.STATE_NOT_INITED=Constant.NOT_INITED;
	this._construct();
}
_this.ignoreLayer=function(strID){
	g_arDragIgnoreID[g_arDragIgnoreID.length]=strID;
};
_this.fixToDragMode=function(){
	this._changeAction(Constant.Mouse.DRAG);
};
_this.fixToResizeMode=function(){
	this._changeAction(Constant.Mouse.RESIZE);
};
_this.releaseFixes=function(){
	this._changeAction(Constant.NOT_INITED);
};
_this._construct=function(){
	var eh=this._eh,
		objSelf=this.getObject();	
	if(!objSelf){
		alert("ERROR!\nObject reference not found : DraggableLayer:_construct");
		return;
	}
	if(this.exists()&&objSelf.id){
		g_arDraggableLayer[objSelf.id]=this;g_arDragID[g_arDragID.length]=objSelf.id;
		if(!g_blnDragConstructed){
			eh.addEventListener(document,"keydown",this._onKeyDown);
			eh.addEventListener(document,"mousedown",this._onMouseDown);
			eh.addEventListener(document,"mouseup",this._onMouseUp);
			eh.addEventListener(document,"mousemove",this._onMouseMove);
			this.strictMode();
		}
	}
	else{
		g_blnDragConstructed=false;
		return;
	}
	g_blnDragConstructed=true;
};
_this._mousedownMoz=function(evt){
	var obj=document.getProperSourceFromEvent(evt);
	if(obj&&obj.tagName.toLowerCase()=="input")
		return true;	
	return false;
};
_this.strictMode=function(){
	g_blnDragStrict=true;
	document.onmousedown=this._mousedownMoz;
};
_this.quirksMode=function(){
	g_blnDragStrict=false;
	document.onmousedown=null;
};
_this._onKeyDown=function(evt){
	var e=window.event?window.event:evt;
	if(e){
		var v=new Validator();
		var intCode=v.isDefined(e.keyCode)?e.keyCode:e.which;
		/*ctrl, alt, tab*/
		if(intCode==17||intCode==18||intCode==9)
			return;
	}
	if(g_currentKeyState!=Constant.Key.DOWN){
		_lyr=new DynamicLayer(g_dragActiveElement);
		if(_lyr.exists){
			if(g_dragCursor.getCursorPosition()){
				g_dragBeginCoord=new Dimension(g_dragCursor.getCursorPosition().getX(),g_dragCursor.getCursorPosition().getY());
				g_dragLT=new Dimension(_lyr.getLeft(),_lyr.getTop());
				g_dragWH=new Dimension(_lyr.getWidth(),_lyr.getHeight());
			}
		}
	}
	g_currentKeyState=Constant.Key.DOWN;
};
_this._onMouseDown=function(evt){
	var eh=new EventHandler(),
		intMaxIndex=0,
		objLayer=null,
		vld = new Validator(),
		src=eh.getProperSourceFromEvent(evt, true),
		_lyr=new DynamicLayer(src);
	g_currentMouseState=Constant.Mouse.DOWN;
	if(!_lyr.exists())
		return false;
	g_dragActiveElement=src;
	if(!(strID=src.id))
		return false;
	if(_lyr.getStyle("zIndex","z-index")!=null){
		for(var i=0;i<g_arDragID.length;i++){
			objLayer=g_arDraggableLayer[g_arDragID[i]];
			var zIndex=objLayer.getStyle("zIndex","z-index");
			if(!vld.isInteger(zIndex)||parseInt(zIndex)<1)
				objLayer.setStyle("zIndex",1);
			intMaxIndex=Math.max(intMaxIndex,objLayer.getStyle("zIndex","z-index"));
		}
		if(_lyr.getStyle("zIndex","z-index")<=intMaxIndex)
			_lyr.setStyle("zIndex",intMaxIndex+1);
	}
	if(g_dragCursor.getCursorPosition())
		g_dragBeginCoord=new Dimension(g_dragCursor.getCursorPosition().getX(),g_dragCursor.getCursorPosition().getY());
	g_dragLT=new Dimension(_lyr.getLeft(),_lyr.getTop());
	g_dragWH=new Dimension(_lyr.getWidth(),_lyr.getHeight());
	return false;
};
_this._onMouseUp=function(evt){
	g_currentMouseState=Constant.NOT_INITED;
	g_currentAction=Constant.NOT_INITED;
	g_currentKeyState=Constant.NOT_INITED;
	g_dragBeginCoord=null;
	g_dragLT=null;
	g_dragWH=null;
	g_dragActiveElement=null;
};
_this._onMouseMove=function(evt){
	var eh=new EventHandler(),
		_lyr=new DynamicLayer(eh.getProperSourceFromEvent(evt,true)),
		src=g_dragActiveElement,
		_lyr=new DynamicLayer(src),
		_lyrCursor=new DynamicLayer(eh.getProperSourceFromEvent(evt,true)),
		registeredAction=g_arDragAction[_lyr.getID()],
		cons=null,
		intMinTop,
		intMinLeft,
		intMaxTop,
		intMaxLeft,
		intCurrentLeft,
		intCurrentTop,
		blnInHorizontalRange,
		blnInVerticalRange,
		left,
		top,
		intCurrentWidth,
		intCurrentHeight,
		blnWidthInRange,
		blnHeightRange,
		width,
		height;
	if(registeredAction!=Constant.NOT_INITED)
		g_currentAction=registeredAction;
	else 
		g_currentAction=(g_currentKeyState==Constant.Key.DOWN)?Constant.Mouse.RESIZE:Constant.Mouse.DRAG;
	if(g_currentAction==Constant.Mouse.DRAG)
		_lyr.setStyle("cursor","move");
	else if(g_currentAction == Constant.Mouse.RESIZE)
		_lyr.setStyle("cursor","se-resize");
	else 
		_lyrCursor.setStyle("cursor","default");
	if(g_currentMouseState!=Constant.Mouse.DOWN||(!g_dragLT))
		return !g_blnDragStrict;
	if(!g_dragCursor.getCursorPosition())
		return false;
	if(!_lyr.exists())
		return false;
	for(var i=0;i<g_arDragIgnoreID.length;i++)
		if(g_arDragIgnoreID[i]==_lyr.getID())
		return false;
	if(g_currentAction==Constant.Mouse.DRAG ){
		if(!g_dragCursor.getCursorPosition())
			return false;
		left=g_dragLT.getX()+g_dragCursor.getCursorPosition().getX()-g_dragBeginCoord.getX();
		top=g_dragLT.getY()+g_dragCursor.getCursorPosition().getY()-g_dragBeginCoord.getY();
		if(cons=g_arDragConstraint[_lyr.getID()]){
			intMinTop=cons.getLowerBound().getX();
			intMinLeft=cons.getLowerBound().getY();
			intMaxTop=cons.getUpperBound().getX();
			intMaxLeft=cons.getUpperBound().getY();
			intCurrentLeft=_lyr.getLeft();
			intCurrentTop=_lyr.getTop();
			blnInHorizontalRange =(intCurrentLeft>=intMinLeft && intCurrentLeft<=intMaxLeft);
			blnInVerticalRange =(intCurrentTop>=intMinTop&&intCurrentTop<=intMaxTop);		
			if(blnInHorizontalRange&&!blnInVerticalRange){
				if(intCurrentTop<=intMinTop)
					top=intMinTop;
				else if(intCurrentTop>=intMaxTop)
					top=intMaxTop;
			}
			else if(!blnInHorizontalRange&&blnInVerticalRange){
				if(intCurrentLeft<=intMinLeft)
					left=intMinLeft;
				else if(intCurrentLeft>=intMaxLeft)
					left=intMaxLeft;
			}
			else if(!blnInHorizontalRange&&!blnInVerticalRange){
				if(intCurrentTop<=intMinTop)
					top=intMinTop;
				else if(intCurrentTop>=intMaxTop)
					top=intMaxTop;
				if(intCurrentLeft<=intMinLeft)
					left=intMinLeft;
				else if(intCurrentLeft>=intMaxLeft)
					left=intMaxLeft;
			}
			else if(blnInHorizontalRange && blnInVerticalRange){
				if((left>=intMinLeft&&left<=intMaxLeft))
					_lyr.setLeft(left);
				if((top>=intMinTop&&top<=intMaxTop))
					_lyr.setTop(top);
				return false;
			}
		}
		_lyr.setLeft(left);
		_lyr.setTop(top);
	}
	else{
		width=g_dragWH.getX()+g_dragCursor.getCursorPosition().getX()-g_dragBeginCoord.getX();
		height=g_dragWH.getY()+g_dragCursor.getCursorPosition().getY()-g_dragBeginCoord.getY();
		width=(width<=10)?10:width;
		height=(height<=10)?10:height;
		if(cons=g_arDragConstraintResize[_lyr.getID()]){
			intMaxWidth=cons.getUpperBound().getX();
			intMaxHeight=cons.getUpperBound().getY();
			intMinWidth=cons.getLowerBound().getX();
			intMinHeight=cons.getLowerBound().getY();
			intCurrentWidth=_lyr.getWidth();
			intCurrentHeight=_lyr.getHeight();
			blnWidthInRange=(intCurrentWidth>=intMinWidth&&intCurrentWidth<=intMaxWidth);
			blnHeightRange=(intCurrentHeight>=intMinHeight&&intCurrentHeight<=intMaxHeight);
			width=g_dragWH.getX()+g_dragCursor.getCursorPosition().getX()-g_dragBeginCoord.getX();
			height=g_dragWH.getY()+g_dragCursor.getCursorPosition().getY()-g_dragBeginCoord.getY();
			if(blnWidthInRange&&!blnHeightRange){
				if(intCurrentHeight<=intMinHeight)
					height=intMinHeight;
				else if(intCurrentHeight>=intMaxHeight)
					height=intMaxHeight;
			}
			else if(!blnWidthInRange && blnHeightRange){
				if(intCurrentWidth<=intMinWidth)
					width=intMinWidth;
				else if(intCurrentWidth>=intMaxWidth)
					width=intMaxWidth;
			}
			else if(!blnWidthInRange&&!blnHeightRange){
				if(intCurrentHeight<=intMinHeight)
					height=intMinHeight;
				else if(intCurrentHeight>=intMaxHeight)
					height=intMaxHeight;
				if(intCurrentWidth<=intMinWidth)
					width=intMinWidth;
				else if(intCurrentWidth>=intMaxWidth)
					width=intMaxWidth;
			}
			else if(blnWidthInRange&&blnHeightRange){
				if((width>=intMinWidth&&width<=intMaxWidth))
					_lyr.setWidth(width);
				if((height>=intMinHeight&&height<=intMaxHeight))
					_lyr.setHeight(height);	
				return false;
			}
		}
		_lyr.setWidth(width);
		_lyr.setHeight(height);
	}
	return false;
};
_this._changeAction=function(strAction){
	g_arDragAction[this.getID()]=strAction;
};