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
