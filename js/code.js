const urlBase = 'http://cop4331groupten.xyz/LAMPAPI';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";

function doLogin() {
	userId = 0;
	firstName = "";
	lastName = "";

	let login = document.getElementById("floatingUsername").value;
	let password = document.getElementById("floatingPassword").value;
	//	var hash = md5( password );

	//document.getElementById("loginResult").innerHTML = "";

	let tmp = { user: login, pass: password };
	//	var tmp = {login:login,password:hash};
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/Login.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	console.log("Before try");
	try {
		console.log("After try");
		xhr.onreadystatechange = function () {
			console.log("Got into readystatechange");
			console.log("Ready state: " + this.readyState);
			console.log("Status: " + this.status);
			if (this.readyState == 4 && this.status == 200) {
				let jsonObject = JSON.parse(xhr.responseText);
				userId = jsonObject.id;

				console.log(jsonObject);
				console.log(userId);

				if (userId < 1) {
					//document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}

				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				console.log(firstName);
				console.log(lastName);

				//saveCookie();

				window.location.href = "indexHome.html";
			}
		};
		console.log(jsonPayload);
		xhr.send(jsonPayload);
	}
	catch (err) {
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function doRegister() {
	userId = 0;
	firstName = "";
	lastName = "";

	let fName = document.getElementById("firstName").value;
	let lName = document.getElementById("lastName").value;
	let login = document.getElementById("inputUsername").value;
	let password = document.getElementById("inputPassword").value;


	let tmp = { firstName: fName, lastName: lName, user: login, pass: password };

	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/Register.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	console.log("Before try");
	try {
		console.log("After try");
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				let jsonObject = JSON.parse(xhr.responseText);
				console.log(jsonObject);
				//if( userId < 1 )
				//{		
				//document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
				//	return;
				//}

				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				window.location.href = "index.html";
			}
		};

		xhr.send(jsonPayload);

	}
	catch (err) {
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function saveCookie() {
	let minutes = 20;
	let date = new Date();
	date.setTime(date.getTime() + (minutes * 60 * 1000));
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie() {
	userId = -1;
	let data = document.cookie;
	let splits = data.split(",");
	for (var i = 0; i < splits.length; i++) {
		let thisOne = splits[i].trim();
		let tokens = thisOne.split("=");
		if (tokens[0] == "firstName") {
			firstName = tokens[1];
		}
		else if (tokens[0] == "lastName") {
			lastName = tokens[1];
		}
		else if (tokens[0] == "userId") {
			userId = parseInt(tokens[1].trim());
		}
	}

	if (userId < 0) {
		window.location.href = "index.html";
	}
	else {
		document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	}
}

function doLogout() {
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
}

function addContact() {
	let fn = document.getElementById("firstName").value;
	let ln = document.getElementById("lastName").value;
	let pn = document.getElementById("phone").value;
	let e = document.getElementById("email").value;

	let tmp = { firstName: fn, lastName: ln, phone: pn, email: e };
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/AddContact.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try {
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				if (userId < 1) // THIS IS WHERE WE SEE IF CONTACT IS IN DB ALREADY
				{
					//document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return false;
				}
			}
		};
		xhr.send(jsonPayload);
		return true;
	}
	catch (err) {
		return false;
	}

}

function getContacts() {
	let url = urlBase + '/GetContacts.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try {
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				console.log(JSON.parse(xhr.responseText));
				displayData(JSON.parse(xhr.responseText));
			}
		};
		xhr.send();
	}
	catch (err) {
		document.getElementById("colorAddResult").innerHTML = err.message;
	}

}

function listContacts() {
	// define variables
	let url = urlBase + '/Login.' + extension;

	// establish XMLHttpRequest
	let xhr = new XMLHttpRequest();

	// new GET operation
	xhr.open("GET", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	// checks to see if the document is loaded and ready to begin
	$(document).ready(function () {
		// grabs instance of JSON from the URL, and causes a function based on the xhr request
		$.getJSON(url,
			function (xhr) {
				var tr;
				console.log("In function with var xhr");
				console.log("xhr.length: " + xhr.length);
				// for the length of xhr (basically all values in the dataset), iterate through them and add them to a table
				for (var i = 0; i < xhr.length; i++) {
					tr = $('<tr/>');
					tr.append("<td>" + xhr[i].firstName + "</td>");
					tr.append("<td>" + xhr[i].lastName + "</td>");
					tr.append("<td>" + xhr[i].phone + "</td>");
					tr.append("<td>" + xhr[i].email + "</td>");
					tr.append("<td>" + xhr[i].ID + "</td>");
					console.log(tr);
					$('table').append(tr);
				}
			});
	});
}

function searchColor() {
	let srch = document.getElementById("searchText").value;
	document.getElementById("colorSearchResult").innerHTML = "";

	let colorList = "";

	let tmp = { search: srch, userId: userId };
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/SearchColors.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try {
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("colorSearchResult").innerHTML = "Color(s) has been retrieved";
				let jsonObject = JSON.parse(xhr.responseText);

				for (let i = 0; i < jsonObject.results.length; i++) {
					colorList += jsonObject.results[i];
					if (i < jsonObject.results.length - 1) {
						colorList += "<br />\r\n";
					}
				}

				document.getElementsByTagName("p")[0].innerHTML = colorList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch (err) {
		document.getElementById("colorSearchResult").innerHTML = err.message;
	}

}
