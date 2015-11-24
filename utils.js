/**
* GLOBAL
*/
var flag = false;
var open = false;

/**
* Checks if the field of the username or the password have met the requirements
*/
var validate = function(){
    $("#usernameReg").next().css({visibility: "hidden"});
    $("#passwordReg").next().css({visibility: "hidden"});
    flag = true;
    var regex = /^[a-zA-Z0-9-_]+$/;
    var username = $("#usernameReg").val();
    var password = $("#passwordReg").val();
    if(username.length < 6){
        $("#usernameReg").next().text('username must have at least 6 characters!');
        $("#usernameReg").next().css({visibility: "visible"});
        flag = false;
    }
    if(username.search(regex) == -1){
        $("#usernameReg").next().text('username must have only alpha-numeric characters!');
        $("#usernameReg").next().css({visibility: "visible"});
        flag = false;
    }
    if(password.length < 6){
        $("#passwordReg").next().text('password must have at least 6 characters!');
        $("#passwordReg").next().css({visibility: "visible"});
        flag = false;
    }
    if(flag == true){
      $('#submit').show("fast");
    }else {
      $('#submit').hide("fast");
    }
}

/**
* Submits the information and then creates an account or displays error if invalid
*/
var submit = function(){
  var error;
  if(flag == true){
    var username = $("#usernameReg").val();
    var password = $("#passwordReg").val();
    var name = $("#nameReg").val();
    $.post("createAccount.php", { usernameReg: username,
                                  passwordReg: password,
                                  nameReg: name},
                                  function(data) {
                                    if(data == "valid"){
                                      location.href = "index.php";
                                    }else {
                                      $("#usernameReg").next().text(data);
                                      $("#usernameReg").next().css("visibility","visible");
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
                                  if (data == "login") {
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

var openRegist = function(){
  $('#registerFormArea').show(400);
  $('body').animate({
    scrollTop: $('#registerArea').offset().top - $('body').offset().top + $('#registerArea').scrollTop()
  });
}

/**
* Opens profile menu
*/
var openMenu = function(){
  if(flag){
    $("#profileTabMenu").hide("fast");
    flag = false;
  }else{
    $("#profileTabMenu").show("fast");
    flag = true;
  }
}

/**
* Eliminates a joined event from the user
*/
var cancelJoinEvent = function(){
  var id = $(this).data('id');
  location.href= 'event.php?eid=' + id;
}
