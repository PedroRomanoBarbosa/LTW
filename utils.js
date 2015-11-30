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

/**
* Edits Profile
*/

var editProfile = function(){
  $("#edit-section").replaceWith('<div id="edit-section"> <input id="cancelButton" type="button" value="Cancel"> <input id="saveButton" type="button" value="Save"> </div>');
  $("#cancelButton").click(cancelEdit);
  $("#saveButton").click(saveEdit);

  var name = $("#profileName").text();
  $("#profileName").replaceWith('<div> <textarea id="nameArea" rows="1" maxlength="60">'+name+'</textarea> </div>');

  var description = $("#profileDescription").text();
  $("#profileDescription").replaceWith('<div> <textarea rows="1" maxlength="300">' + description + '</textarea> </div>');
}

var cancelEdit = function(){
  location.reload();
}

var saveEdit = function(){
  var profileName = $("#nameArea").val();
  profileName = $.trim(profileName);
  $.post( "changeProfile.php", { name: profileName, userId: uid } );
  location.reload();
}

var editEvent = function(){
  $("#editButton").replaceWith('<input id="cancelButton" type="button" value="Cancel"> <input id="saveButton" type="button" value="Save"> ');
  $("#cancelButton").click(cancelEdit);
  $("#saveButton").click(saveEditEvent);

  var eventName = $("#eventName").text();
  $("#eventName").replaceWith('<div id="eventName"> <input maxlength="60" value="' + $.trim(eventName) + '"> </div>');
  var eventDate = $("#eventDate").text();
  $("#eventDate").replaceWith('<div id="eventDate"> <input maxlength="60" value="' + $.trim(eventDate.substr(7)) + '"> </div>');
  var eventDescription = $("#eventDescription").text();
  $("#eventDescription").replaceWith('<textarea id="eventDescription" maxlength="400">' + $.trim(eventDescription) + ' </textarea>');
  $("#event-main-area > header > h3").css("display","none");
  $("#radio").css("display","block");
  $("#radio > input").each(function(){
    if($(this).val() == $("#radio").data("id")){
      $(this).attr("checked","checked");
    }
  });
}

var saveEditEvent = function(){
  var newName = $.trim($("#eventName > input").val());
  var newDate = $.trim($("#eventDate > input").val());
  var newType = $("input[name='type']:checked").val();
  var newDescription = $.trim($("#eventDescription").val());
  var id = $("#event-main-area").data("id");

  $.post( "changeEvent.php", { name: newName, date: newDate, type: newType, description: newDescription, eid: id } );
  location.reload();
}
