   function addContact() {
	   errString=""
	  /* check if First Name is blank */
	  if (document.forms["inputForm"]["firstName"].value == "")
         errString +="Error: First Name is blank!, "; 
	 if (document.forms["inputForm"]["lastName"].value == "")
         errString +="Error: Last Name is blank!, "; 
	 if (!validateEmail(document.forms["inputForm"]["email"].value))
         errString +="Error: Invalid Email!, ";
	 if (!validateCell(document.forms["inputForm"]["cell"].value))
         errString +="Error: Invalid Cell No.!, "; 
	 if (!validateHomepage(document.forms["inputForm"]["homepage"].value))
         errString +="Error: Invalid Homepage!, ";
	 if (!validateBirthdate(document.forms["inputForm"]["birthdate"].value)){
         errString +="Error: Invalid Birthdate!, ";
         if (errString){
         window.alert(errString);
         return false;
         }
         return true;
     }

	
//input validated, now add to database
   window.alert("Contact Added");

   //now read the database and use php to add html for Contacts table
}

  
   function validateEmail(email){
	    // returns true if a properly formatted email
		return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
   }
   

   function validateCell(cell){
	// returns true if a properly formatted cell number
	return /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/.test(cell);
   }
   function validateHomepage(homepage){
    // returns true if a properly formatted homepage
    return /^(https?:\/\/)?[\w\-~]+(\.[\w\-~]+)+(\/[\w\-~]*)*(#[\w\-]*)?(\?.*)?$/.test(homepage);
}
function validateBirthdate(birthdate){
	// returns true if a properly formatted birthdate
	return /^\d{4}-\d{2}-\d{2}$/.test(birthdate);
}
   
   function copyBilling(){
	   document.forms["inputForm"]["billingFirstName"].value =
	   document.forms["inputForm"]["firstName"].value;
	   document.forms["inputForm"]["billingLastName"].value =
	   document.forms["inputForm"]["lastName"].value;
	   document.forms["inputForm"]["billingAddress"].value =
	   document.forms["inputForm"]["address"].value;
	   document.forms["inputForm"]["billingCity"].value =
	   document.forms["inputForm"]["city"].value;
	   document.forms["inputForm"]["billingState"].value =
	   document.forms["inputForm"]["state"].value;
	   document.forms["inputForm"]["billingZip"].value =
	   document.forms["inputForm"]["zip"].value;
	   document.forms["inputForm"]["billingPhone"].value =
	   document.forms["inputForm"]["phone"].value;
	   window.alert("Copy Billing Info");
   }
   function getCookie(cname) {
	var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(){
		var firstName = getCookie("cfirstName");
		if (firstName != ""){
			document.forms["inputForm"]["firstName"].value = firstName;
		}
		
		var lastName = getCookie("clastName");
		if (lastName != ""){
			document.forms["inputForm"]["lastName"].value = lastName;
		}
		var address = getCookie("caddress");
		if (address != ""){
			document.forms["inputForm"]["address"].value = address;
		}
		
		var city = getCookie("ccity");
		if (city != ""){
			document.forms["inputForm"]["city"].value = city;
		}
		var state = getCookie("cstate");
		if (state != ""){
			document.forms["inputForm"]["state"].value = state;
		}
		
		var zip = getCookie("czip");
		if (zip != ""){
			document.forms["inputForm"]["zip"].value = zip;
		}
		var phone = getCookie("cphone");
		if (phone != ""){
			document.forms["inputForm"]["phone"].value = phone;
		}
		var billingFirstName = getCookie("cbillingFirstName");
		if (billingFirstName != ""){
			document.forms["inputForm"]["billingFirstName"].value = billingFirstName;
		}
		
		var billingLastName = getCookie("cbillingLastName");
		if (billingLastName != ""){
			document.forms["inputForm"]["billingLastName"].value = billingLastName;
		}
		var billingAddress = getCookie("cbillingAddress");
		if (billingAddress != ""){
			document.forms["inputForm"]["billingAddress"].value = billingAddress;
		}
		
		var billingCity = getCookie("cbillingCity");
		if (billingCity != ""){
			document.forms["inputForm"]["billingCity"].value = billingCity;
		}
		var billingState = getCookie("cbillingState");
		if (billingState != ""){
			document.forms["inputForm"]["billingState"].value = billingState;
		}
		
		var billingZip = getCookie("cbillingZip");
		if (billingZip != ""){
			document.forms["inputForm"]["billingZip"].value = billingZip;
		}
		var billingPhone = getCookie("cbillingPhone");
		if (billingPhone != ""){
			document.forms["inputForm"]["billingPhone"].value = billingPhone;
		}

}
