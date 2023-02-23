const urlBase = 'http://cop4331groupten.xyz/LAMPAPI';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";

function doRegister()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
    let fName = document.getElementById("firstName").value;
    let lName = document.getElementById("lastName").value;
	let login = document.getElementById("floatingUsername").value;
	let password = document.getElementById("floatingPassword").value;


	let tmp = {firstName:fName,lastName:lName,user:login,pass:password};

	let jsonPayload = JSON.stringify( tmp );
	
	let url = urlBase + '/Register.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
	try
	{
		
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				let jsonObject = JSON.parse( xhr.responseText );
                userId = jsonObject.id;

                if( userId < 1 )
				{		
					//document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;
	
				window.location.href = "index.html";
			}
		};

		xhr.send(jsonPayload);

	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}

}