<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login | Music Sharing Platfrom</title>
</head>
<body>
    <center>
        <div class="logindiv">
        <img class="logo" src="logo01.gif">
            <form class="loginform" action="includes/auth.php" method="post">
                <input class="logininp" type="email" name="email" placeholder="Email Id" required><br>
                <input class="logininp" type="password" name="password" placeholder="Password" required><br>
                <input class="loginbtn" type="submit" name="login" value="Login">
            </form>
            <p>Not Registered? <a href="register.php">Register Now</a></p>
        </div>
    </center>
</body>
</html>
