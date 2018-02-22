

//bool vars to check for email and pass validity
var email =false,password = false;
// on key press, cut ,paste  functions that returns result of validation into appropriate var
// email
document.getElementById("signupEmail").onkeyup = function() {
    email = myFunction("signupEmail","email");
};
document.getElementById("signupEmail").onpaste = function() {
    email = myFunction("signupEmail","email");
};
document.getElementById("signupEmail").oncut = function() {
    email = myFunction("signupEmail","email");
};

//password
document.getElementById("signupPassword").onkeyup = function() {
    password = myFunction("signupPassword","password")
};
document.getElementById("signupPassword").onpaste = function() {
    email = myFunction("signupPassword","password");
};
document.getElementById("signupPassword").oncut = function() {
    email = myFunction("signupPassword","password");
};


//form submit prevention to check for validity
document.getElementById("regForm").onsubmit = function(ev) {
    ev.preventDefault(); 
    if (email && password){
        this.submit();
    }
    else if (!email && !password){
        toastr.error("Please recheck your Email and password");
    }
    else if(!email){
        toastr.error("Invalid Email address");
    }
    else if(!password){
        toastr.error("Invalid Password");
    }
    else{
        toastr.error("Something gone wrong please try resubmitting");
    }
};

//function : regex check for valid email
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

//function : regex check for valid pass
function validPass(pass) {
    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
    return (regex.test(pass) && pass.length < 26) ;
}



//function : general function to check for validity and change style based on that
function myFunction(id,type){
    var text = document.getElementById(id).value;
    document.getElementById(id).style.color = "red";
    document.getElementById(id).style.boxShadow = "0 0 0 0.2rem rgba(255,2,2,0.5)";
    switch(type) {
        case "email":
            if (isEmail(text)){
                document.getElementById(id).style.color = "green";
                document.getElementById(id).style.boxShadow = "0 0 0 0.2rem rgba(44,62,80,0.25)";
                return true;
            }
            return false;
            break;
        case "password":
            if (validPass(text)){
                document.getElementById(id).style.color = "green";
                document.getElementById(id).style.boxShadow = "0 0 0 0.2rem rgba(44,62,80,0.25)";
                return true;
            }
            else return false;
            break;
    }    
};