window.onload = initialize;
window.onload = searching;
window.onload = photo;
// Global request variable
var request;

function createRequest() {

	// From "Head Rush Ajax" by Brett McLaughlin

	try {
		request = new XMLHttpRequest();
	} catch (trymicrosoft) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (othermicrosoft) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = null;
			}
		}
	}
	
	if (request == null) {
		alert("Error creating request object!");
	}

}


function photoLookup(){
	var image=document.getElementByTagName('img');
	var caption= image.getAttribute("title");
	image.height=auto;
	image.width=auto;
}


function searching(){
	caption= document.getElementById("search");
	caption.onclick= captionLookup();
	
	
	// When the user presses enter, the form isn't submitted, but userLookup is stil called as if the 					    // user had clicked the search button
	var form = document.getElementsByTagName("form");
	form[0].onsubmit = function(event){
		captionLookup();
		return false;
	}
	
    // Setup our request object
	request = null;
	createRequest();	
}

function captionLookup(){
	captionsearch=document.getElementById('caption').value;
	
	request.onreadystatechange=function()
  {
  if (request.readyState==4 && request.status==200)
    {
    document.getElementById("captionmsg").innerHTML=request.responseText;
    }
  }
request.open("POST","search.php?captionsearch="+captionsearch,true);
request.send();
}

// Initialize on window load
function initialize() {
   
    // Get our search button and setup an event handler
	album= document.getElementById("album");
	album.onclick= albumLookup();
	
	
	// When the user presses enter, the form isn't submitted, but userLookup is stil called as if the 					    // user had clicked the search button
	var form = document.getElementsByTagName("form");
	form[0].onsubmit = function(event){
		albumLookup();
		return false;
	}
	
    // Setup our request object
	request = null;
createRequest();	
}

function albumLookup(){
	albumtitle=document.getElementById('albumtitle').value;
	if (albumtitle=="")
  {
  document.getElementById("text").innerHTML="There are no photos in this album";
  return;
  } 
	request.onreadystatechange=function()
  {
  if (request.readyState==4 && request.status==200)
    {
    document.getElementById("text").innerHTML=request.responseText;
    }
  }
request.open("POST","album.php?albumtitle="+albumtitle,true);
request.send();
}




//Checking user input
function trim(str){
	return str.replace(/^\s+|\s+$/g, '');
}
function msg(id,message) {
	var node = document.getElementById(id);
		if (trim(message) == "") {
			message = String.fromCharCode(160);
		}	
	node.firstChild.nodeValue = message;
}

/*When the user clicks submit, the validAlbum function is called to make sure that all categories are filled.*/
function validAlbum(){
	var title=validTitle(document.forms.updates.newtitle.value);
	
	if(!(title)){
			msg("submitmsg","Please correct the errors before submitting");
			return false;			
	} else return true;
}

/*When the user clicks submit, the validPhoto function is called to make sure that at least one category is filled.*/
function validPhoto(){
	var url=validUrl(document.forms.updatephotos.newurl.value);
	var caption=validCaption(document.forms.updatephotos.newcaption.value);
	var year=validYear(document.forms.updatephotos.newyear.value);
	var month=validMonth(document.forms.updatephotos.newmonth.value);
	var day=validDay(document.forms.updatephotos.newday.value);
	
	if(!(url || caption || (year && month &&day))){
			msg("submit2msg","Please correct the errors before submitting");
			return false;			
	} else return true;
}

/*When the user clicks submit, the validAll function is called to make sure that all categories are filled.*/
function validAll(){
	var url=validUrl(document.forms.addphoto.url.value);
	var caption=validCaption(document.forms.addphoto.caption.value);
	var year=validYear(document.forms.addphoto.year.value);
	var month=validMonth(document.forms.addphoto.month.value);
	var day=validDay(document.forms.addphoto.day.value);
	var image=validPic(document.forms.addphoto.image.value);
	
	if(!(url && caption && year && month && day && image)){
			msg("submitmsg","Please correct the errors before submitting");
			return false;			
	} else return true;
}
function validReuse(){
	var url=validUrl(document.forms.reusephoto.url.value);
	var caption=validCaption(document.forms.reusephoto.caption.value);
	
	if(!(url && caption)){
			msg("submitmsg","Please correct the errors before submitting");
			return false;			
	} else return true;
}
/*When the user clicks submit, the validAll function is called to make sure that all categories are filled.*/
function validAddalbum(){
	var title=validTitle(document.forms.addalbum.title.value);
	
	if(!title){
			msg("submit2msg","Please correct the errors before submitting");
			return false;			
	} else return true;
}
function validTitle(title) {
	var check = /^[A-Za-z0-9 ]+$/;
	if (trim(title) == ""){
			msg("titlemsg", "*");
			return false;
	}
	else if (check.test(title)) {
		msg("titlemsg","");
		return true;
	} else {
		msg("titlemsg","Please enter a valid title");
		return false;
	}
}
function validUrl(url) {
	var check = /^[a-z\d_\/\.-]+$/;
	if (trim(url) == ""){
			msg("urlmsg", "*");
			return false;
	}
	else if (check.test(url)) {
		msg("urlmsg","");
		return true;
	} else {
		msg("urlmsg","Please enter a valid url");
		return false;
	}
}
function validCaption(caption) {
	var check = /^[\s\S\w\W]+$/;
	if (trim(caption) == ""){
			msg("captionmsg", "*");
			return false;
	}
	else if (check.test(caption)) {
		msg("captionmsg","");
		return true;
	} else {
		msg("captionmsg","Please enter a valid caption");
		return false;
	}
}
function validYear(year) {
	var check = /^(1[8-9][0-9]{2}|20(0[0-9]|1[0-2]))$/;
	if (trim(year) == ""){
			msg("yearmsg", "*");
			return false;
	}
	else if (check.test(year)) {
		msg("yearmsg","");
		return true;
	} else {
		msg("yearmsg","Please enter a valid year");
		return false;
	}
}
function validMonth(month) {
	var check = /^(0[1-9]|1[0-2])$/;
	if (trim(month) == ""){
			msg("monthmsg", "*");
			return false;
	}
	else if (check.test(month)) {
		msg("monthmsg","");
		return true;
	} else {
		msg("monthmsg","Please enter a valid month");
		return false;
	}
}
function validDay(day) {
	var check = /^(0[1-9]|(1|2)[0-9]|3[0-1])$/;
	if (trim(day) == ""){
			msg("daymsg", "*");
			return false;
	}
	else if (check.test(day)) {
		msg("daymsg","");
		return true;
	} else {
		msg("daymsg","Please enter a valid day");
		return false;
	}
}
function validPic(image) {
	if (image != ""){
			return true;
	}
	else {
		return false;
	}
}