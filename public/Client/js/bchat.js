function loadUsers() {
    $.ajax({
        type: "GET",
        url: "http://localhost/BunqChat/public/api/v1/messages/"+userid,
        dataType: "json",
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader("Authorization", "Bearer "+tokenId);
        },
        success: function(data){
            console.log(data);
            drawUsers(data);
            drawMessages("");
        },
        error: function(data) {
            $("#personDataTable").empty();
            $("#personDataTable").append("<tr><span id='fail' class='fail'>Fail! Server problem!</span></tr>");
        }
    });
};

function drawUsers(data) {
    if(data == ''){
        $("#personDataTable").append("No users have sent you messages! :(");
    }
    $.each(data, function(id, obj) {
        var row = $("<tr id='nameRow' class='nr' />")
        row.append($("<td><input type='hidden' id='to_id' value='"+obj[0]+"'></td>"));
        row.append($("<td><input type='hidden' id='name' value='"+obj[1]+"'></td>"));
        row.append($("<td><img src='"+obj[2] + "' width='64'' height='64'></td>"));
        row.append($("<td>" + obj[1] + "</td></tr>"));
        $("#personDataTable").append(row);
    });
};

// This is the call to get all messages from id to nid
$(document).on("click", "#nameRow", function(e) {
    e.preventDefault();
    var username = $(this).find('#name').val();
    $.ajax({
        type: "GET",
        url: "http://localhost/BunqChat/public/api/v1/messages/"+$(this).find('#to_id').val()+"/to/"+userid,
        dataType: "json",
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader("Authorization", "Bearer "+tokenId);
        },
        success: function(data){
            drawMessages(data, username);
        },
        error: function(data) {
            $("#messagesDataTable").empty();
            $("#messagesDataTable").append("<tr><span id='fail' class='fail'>Fail! Server problem!</span></tr>");
        }
    });
});



function drawMessages(data, name) {
    if(data == ''){
        $("#messagesDataTable").empty();
        $("#messagesDataTable").append("<caption>Messages</caption>");
        $("#messagesDataTable").append("Welcome to the RESTFul Private Messaging...");
    }else {
        $("#messagesDataTable").empty();
        $("#messagesDataTable").append("<caption>Messages from " + name + "</caption>");
    }
    $.each(data, function(id, obj) {
        var row = $("<tr id='messageRow'/>")
        $("#messagesDataTable").append(row);
        row.append($("<input type='hidden' id='to_id' value='"+obj['id']+"'>"));
        //row.append($("<td>" + obj[0] + "</td>"));
        row.append($("<td>" + obj['title'] + "</td>"));
        row.append($("<td>" + obj['created_at'] + "</td>"));
        row.append($("<td>" + obj['message'] + "</td>"));
    });
};



/*   THIS IS THE JAVASCRIPT CODE TO DEAL WITH  MESSAGES SENDING  */

// Register listeners
$(document).on("click", "#btnNewMessage", function(e) {
    messageForm();
    return false;
});


function messageForm() {
    $("#messagesDataTable").empty();

    var form = $("<div id='bchat_general'><form id='message' action='' method='post' accept-charset='UTF-8'>" +
    "<div class='container'><label for='username' >Username: </label><br/>" +
    "<input type='text' name='username' id='username' value='' maxlength='20' /><br/><span id='login_username_errorloc' class='error'></span></div><div class='container'" +
    "><label for='password' >Title:</label><br/><input type='text' name='title' id='title' maxlength='50' />" +
    "<br/></div><div class='container'><label for='message' >Message:</label><br/><textarea type='text' name='message' id='usermessage' maxlength='500'> </textarea>" +
    "<br/></div><div class='container'><input id='send' type='submit' name='Submit' value='Send' /></div></form></div>");
    $("#messagesDataTable").append("<caption>New message</caption>").append(form);

}


// This is the call to send a message
$(document).on("submit", "#message", function(e) {
    e.preventDefault();

    if ($('input#username').val().length == 0) {
        $('#login_username_errorloc').text("Username can't be null!");
        return false;
    }
    var form = $(this);
        var sendInfo = {
        "username": $('#username').val(),
        "title": $('#title').val(),
        "message": $('#usermessage').val(),
        "from_id": userid
        }
    $.ajax({
        type: "POST",
        url: "http://localhost/BunqChat/public/api/v1/messages/",
        dataType: "json",
        data: JSON.stringify(sendInfo),
        beforeSend: function(xhr) {
            $("#messagesDataTable").empty();
            $("#messagesDataTable").append("<caption>Sending Message...</caption>");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("Authorization", "Bearer "+tokenId);
        },
        success: function(data){
            if(data == 'Success.') {
                $("#messagesDataTable").append("<span id='success' class='success'>Message sent!</span>");
            }else{
                $("#messagesDataTable").append("<span id='success' class='success'>Fail! User does not exist!</span>");
            }
        },
        error: function(data) {
            $("#messagesDataTable").append("<span id='fail' class='fail'>Fail! Server problem!</span>");
        }
    });

});


/*   THIS IS THE JAVASCRIPT CODE TO DEAL WITH  USERS REGISTRATION    */


// Register listeners
$(document).on("click", "#btnNewUser", function(e) {
    usersForm();
    return false;
});

function usersForm() {
    $("#messagesDataTable").empty();

    var form = $("<div id='bchat_general'><form id='users' action='' method='post' accept-charset='UTF-8'><div class='container'>" +
    "<label for='fullname' >Name:</label><br/><input type='text' name='name' id='fullname' maxlength='50' /><br/>" +
    "<span id='login_name_errorloc' class='error'></span></div><div class='container'><label for='email' >Email:</label>" +
    "<br/><input type='text' name='email' id='email' maxlength='50' /><br/></div><div class='container'><label for='username' >Username:</label>" +
    "<br/><input type='text' name='username' id='username' value='' maxlength='50'' /><br/><span id='login_username_errorloc' class='error'>" +
    "</span></div><div class='container'><label for='password' >Password:</label><br/>" +
    "<input type='password' name='password' id='password' maxlength='50' /><br/><span id='login_password_errorloc' class='error'>" +
    "</span></div><div class='container'><input type='submit' name='Submit' value='Register' /></div></form></div>");
    $("#messagesDataTable").append("<caption>New user</caption>").append(form);

}

// This is the call to send a message
$(document).on("submit", "#users", function(e) {
    e.preventDefault();
    var form = $(this);

    if ($('input#username').val().length == 0) {
        $("#login_username_errorloc").text("Username field can't be empty!");
        return false;
    }

    if ($('input#fullname').val().length == 0) {
        $("#login_name_errorloc").text("Name field can't be empty!");
        return false;
    }

    if ($('input#password').val().length == 0) {
        $("#login_password_errorloc").text("Password field can't be empty!");
        return false;
    }

    var sendInfo = {
        "username": $('#username').val(),
        "name": $('#fullname').val(),
        "email": $('#email').val(),
        "password": $('#password').val(),
        "photo": 'img/sample.png'
    }
    $.ajax({
        type: "POST",
        url: "http://localhost/BunqChat/public/api/v1/users/",
        dataType: "json",
        data: JSON.stringify(sendInfo),
        beforeSend: function(xhr) {
            $("#messagesDataTable").empty();
            $("#messagesDataTable").append("<caption>Creating User...</caption>");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("Authorization", "Bearer "+tokenId);
        },
        success: function(data){
            if(data == 'Success') {
                $("#messagesDataTable").append("<span id='success' class='success'>User created!</span>");
            }else{
                //console.log(data);
                $("#messagesDataTable").append("<span id='success' class='success'>Fail! User couldn't be created! (Perhaps the username already exists?)</span>");
            }
        },
        error: function(data) {
            $("#messagesDataTable").append("<span id='fail' class='fail'>Fail! Server problem!</span>");
        }
    });

});


$(document).on("click", "#btnLogout", function() {
    $.ajax({
        success: function(data){
            $.redirect('privateChat.php', {'argument': 'logOut'});
        }
    });
});