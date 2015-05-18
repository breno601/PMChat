<?php
if(!isset($_POST['username']) || !isset($_POST['token'])){
    header('Location: index.php');
}else if(isset($_POST['argument']) && $_POST['argument'] == 'logOut' && !empty( session_id())) {

    session_destroy();
    $_SESSION = array();
    header("Location: index.php");

}else{

    session_start();
    $_SESSION['username']= $_POST['username'];
    $_SESSION['token']= $_POST['token'];

    // This is just a setup to get the id from the given username
    $ch = curl_init('http://localhost/BunqChat/public/api/v1/users/'.$_SESSION['username']);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'],
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($ch);
    $responseData = json_decode($response, TRUE);
    $_SESSION['id']= $responseData[0]["id"];
    curl_close($ch);
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Login</title>
    <link rel="STYLESHEET" type="text/css" href="Style/brlogin.css" />
    <script type='text/javascript' src="js/jquery-2.1.4.min.js"></script>
    <script type='text/javascript' src="js/jquery.redirect.js"></script>
    <script type='text/javascript' src="js/bchat.js"></script>
</head>
<body>


<div id='bchat_general'>
    <h2>Private Messaging</h2>
    <span>Welcome back <?php echo $_SESSION['username'] ?>!</span>
    <button id="btnNewMessage">Send new message</button>
    <button id="btnNewUser">Register</button>
    <button id="btnLogout">Logout</button>

    <div id='bchat_general'>
        <table id="personDataTable">
            <caption>You have messages from:</caption>
        </table>
        <table id="messagesDataTable">
            <caption>Messages</caption>
         </table>
    </div>

    <script type='text/javascript'>
        var userid = "<?php echo $_SESSION['id'] ?>";
        var tokenId = "<?php echo $_SESSION['token']; ?>";
    </script>

    <?php if(isset($_SESSION['id'])){
        echo '<script>loadUsers();</script>';
          }else{
                header('Location: index.php');
          }?>
</div>

</body>
</html>