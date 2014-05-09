var kfm = {util: {}};

String.prototype.trim = function() {
   return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
   return this.replace(/^\s+/g,"");
}
String.prototype.rtrim = function() {
   return this.replace(/\s+$/g,"");
}

function isEmpty(str){
	if (str == null) return true;
	str = str + "";
	if (str.trim() == "") return true;
	return false;
}

kfm.util.gotoURL = function (url){
	window.location.href = url;
}

kfm.byId = function(id) {
	return document.getElementById(id);	
}

txtSeach_onclick = function(objSearch){
	if (objSearch.value == lbl_Search){
		objSearch.value = '';
		objSearch.className = 'focusTxt';
	}
}

txtSearch_onblur = function(objSearch){
	if (objSearch.value == ''){
		objSearch.value = lbl_Search;
		objSearch.className = 'hintTxt';
	}
}

txtSearch_submit = function(){
	var objSearch = kfm.byId("txtSearch");
	if (objSearch.value != '' && objSearch.value != lbl_Search){
		kfm.byId("cse-search-box").submit();
	}else{
		txtSeach_onclick(objSearch);
		objSearch.focus();
	}
}

//Dropdown code
var timeout	= 500;
var closetimer	= 0;
var ddmenuitem	= 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 