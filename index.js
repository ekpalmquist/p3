window.onload = initialize;

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

// Initialize on window load
function initialize() {
   
    // Get our search button and setup an event handler
	searching= document.getElementById("searchButton");
	searching.onclick= userLookup;
	
	
	// When the user presses enter, the form isn't submitted, but userLookup is stil called as if the 					    // user had clicked the search button
	var form = document.getElementsByTagName("form");
	form[0].onsubmit = function(event){
		userLookup();
		return false;
	}
	
    // Setup our request object
	request = null;
	createRequest();	
}



