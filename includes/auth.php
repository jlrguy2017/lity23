<?php
if (isset($_POST['register'])) {

    include('../includes/db.php');

    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash(htmlspecialchars(trim($_POST['passkey'])), PASSWORD_DEFAULT);

    if ($email == '') {
        echo "<script type='text/javascript'>";
        echo "alert('Kindly fill all the details');";
        echo "window.location.href = '../register.php';";
        echo "</script>";
    } else {

        $query = "SELECT * FROM `auth` WHERE `email` = '$email'";
        $run = pg_query($conn, $query);

        $count = pg_num_rows($run);

        if ($count >= 1) {
            echo "<script type='text/javascript'>";
            echo "alert('User Already Registered');";
            echo "window.location.href = '../register.php';";
            echo "</script>";
        } else {

            $query = "INSERT INTO `auth` (`name`, `email`, `phone`, `password`) VALUES ('$name', '$email', '$phone', '$password')";
            $run = pg_query($conn, $query);

            if ($run) {
                echo "<script type='text/javascript'>";
                echo "alert('User Registered Successfully');";
                echo "window.location.href = '../index.php';";
                echo "</script>";
            }
        }
    }
}

// PHP code for Login

if (isset($_POST['login'])) {
    session_start();
    include('../includes/db.php');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `auth` WHERE `email` = '$email' AND `password` = '$password'";
    $result = pg_query($conn, $query);
    $num_rows = pg_num_rows($result);

    if ($num_rows > 0) {
        $user = pg_fetch_assoc($result);
        $_SESSION['email'] = $email;
        echo "<script type='text/javascript'>";
        echo "alert('Login Success');";
        echo "window.location.href = '../music.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Login Failed');";
        echo "window.location.href = '../register.php';";
        echo "</script>";
    }
}

// Show Profile PHP code

function profile(){
    session_start();
include('includes/db.php');
$user = $_SESSION['email'];

if (!empty($user)) {
    $query = "SELECT * FROM `auth` WHERE `email` = '$user'";
    $run = pg_query($conn, $query);
    if ($run) {
        $row = pg_fetch_assoc($run);
        if (!empty($row)) {
            
            <tr>
            <form class="editform" action="includes/auth.php" method="post">
                <input class="editinp" type="text" name="name" value="<?php echo htmlentities($row['name']);?>"><br>
                <input class="editinp" type="email" name="email" value="<?php echo htmlentities($row['email']);?>"><br>
                <input class="editinp" type="text" name="phone" value="<?php echo htmlentities($row['phone']);?>"><br>
                <input class="editinp" type="password" name="password" value="<?php echo htmlentities($row['password']);?>"><br>
                <input class="editbtn" type="submit" name="update" value="Update">
            </form>
            </tr>
            
        }
    }
}
if(isset($_POST['update'])){
    
    session_start();
    
    include('../includes/db.php');
    
    $user = $_SESSION['email'];
    $name = pg_escape_string($conn, $_POST['name']);
    $email = pg_escape_string($conn, $_POST['email']);
    $phone = pg_escape_string($conn, $_POST['phone']);
    $password = pg_escape_string($conn, $_POST['password']);

    $query = "UPDATE `auth` SET `name`='$name',`email`='$email',`phone`='$phone',`password`='$password' WHERE `email` = '$user'";
    $run = pg_query($conn, $query);
    
    if($run){
        $_SESSION['email'] = $email;
        header("Location: ../music.php");
        exit();
    } else {
        echo "Error updating profile: " . pg_last_error($conn);
    }
}
?>
