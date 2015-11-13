var flag = false;

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

var submit = function(){
  var error;
  if(flag == true){
    var username = $("#username").val();
    var password = $("#password").val();
    $.post( "createAccount.php",{username: username, password: password},function(data){error = data;console.log(error);});
  }
}
