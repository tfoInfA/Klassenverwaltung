/* Onload */
if(window.addEventListener){
	window.addEventListener("load", onLoad, false);
}
else if(window.attachEvent){
	window.attachEvent("onload", onLoad);
}

function onLoad(){
	loadEventHandlers();
	if(typeof onLoadSite === 'function'){
		onLoadSite();
	}
	console.info('Website by Matthias Thalmann. matthias.thalmann.bz.it');
}

function toggleMenu(){
	var nav = document.getElementById('pagenav');
	var btn = document.getElementById('header_menubutton');

	if(nav.style.maxHeight == '300px'){
		btn.className = btn.className.replace(" fa-rotate-180", "");
		nav.style.maxHeight = '3px';
	}
	else {
		btn.className += " fa-rotate-180";
		nav.style.maxHeight = '300px';
	}
}

/* Funktionen */

/* Eventhandler */
function eventHandler(id, action, fct){
	if(window.addEventListener){
		document.getElementById(id).addEventListener(action, fct, false);
	}
	else if(window.attachEvent){
		document.getElementById(id).attachEvent("on" + action, fct);
	}
}

function eventHandlerObject(object, action, fct){
	if(window.addEventListener){
		object.addEventListener(action, fct, false);
	}
	else if(window.attachEvent){
		object.attachEvent("on" + action, fct);
	}
}

//
function loadEventHandlers(){
}
