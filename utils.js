/**
* GLOBAL
*/
var flag = false;

/**
* Checks if the field of the username or the password have met the requirements
*/
var validate = function(){
    $(".error").remove();
    flag = true;
    var regex = /^[a-zA-Z0-9-_]+$/;
    var username = $("#username").val();
    var password = $("#password").val();
    if(username.length < 4){
        $("#username").after('<span class="error"> username must have at least 6 characters! </span>');
        flag = false;
    }
    if(username.search(regex) == -1){
        $("#username").after('<span class="error"> username must have only alpha-numeric characters! </span>');
        flag = false;
    }
    if(password.length < 6){
        $("#password").after('<span class="error"> password must have at least 6 characters! </span>');
        flag = false;
    }
}

/**
* Submits the information and then creates an account or displays error if invalid
*/
var submit = function(){
  var error;
  if(flag == true){
    var username = $("#username").val();
    var password = $("#password").val();
    $.post("createAccount.php", { username: username,
                                  password: password},
                                  function(data) {
                                    if(data == "valid"){
                                      location.href = "index.php";
                                    }else {
                                      $("#errorBlock").text(data);
                                      $("#errorBlock").css("visibility","visible");
                                    }
                                  });
  }
}

/**
* Sends the information and then logins or displays error if invalid
*/
var login = function(){
  var username = $("#username").val();
  var password = $("#password").val();
  $.post("checkAccount.php", { username: username,
                                password: password},
                                function(data) {
                                  if(data == "validated"){
                                    location.href = "index.php";
                                  }else if (data == "login") {
                                    location.href = "index.php";
                                  }else {
                                    $("#errorBlock").text(data);
                                    $("#errorBlock").css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 500);
                                  }
                                });
}

/**
* Hides error message
*/
var hideError = function(){
  $("#errorBlock").animate({opacity: 0}, 'fast');
}

/**
* Logs out from the current session
*/
var logout = function(){
  $.post("logout.php", function(data) {
                          if(data == "logout"){
                            location.href = "index.php";
                          }
                        });
}
