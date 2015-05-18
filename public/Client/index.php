<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Login</title>
    <link rel="STYLESHEET" type="text/css" href="Style/brlogin.css" />
    <script type='text/javascript' src="js/jquery-2.1.4.min.js"></script>
    <script type='text/javascript' src="js/jquery.redirect.js"></script>
</head>
<body>
<div id='bchat_general'>
    <form id='login' action='' method='post' accept-charset='UTF-8'>
        <fieldset >
            <legend>Login</legend>

            <input type='hidden' name='submitted' id='submitted' value='1'/>

            <div class='short_explanation'>Please enter you login and password to enter.</div>

            <div><span class='error'></span></div>
            <div class='container'>
                <label for='username' >Username:</label><br/>
                <input type='text' name='username' id='username' value='' maxlength="50" /><br/>
                <span id='login_username_errorloc' class='error'></span>
            </div>
            <div class='container'>
                <label for='password' >Password:</label><br/>
                <input type='password' name='password' id='password' maxlength="50" /><br/>
                <span id='login_password_errorloc' class='error'></span>
            </div>

            <div class='container'>
                <input type='submit' name='Submit' value='Submit' />
            </div>
        </fieldset>
    </form>

    <script type='text/javascript'>

        $('#login').submit(function(e){

            if ($('input:text').val().length == 0 || $('input:password').val().length == 0) {
                $("#login_password_errorloc").text("Login or password can't be null!");
                return false;
            }

            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "http://localhost/BunqChat/public/oauth/token",
                dataType: "json",
                data: {
                    "grant_type": "password",
                    "client_id": "testclient",
                    "client_secret": "secret",
                    "username": $('#username').val(),
                    "password": $('#password').val()
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                },
                success: function(data){
                    $.redirect('privateChat.php', {'username': $('#username').val(), 'token': data['access_token']});
                },
                error: function(data) {
                    $("#login_password_errorloc").text("Invalid login or password!");
                }
            });
        });
    </script>

</div>

</body>
</html>
