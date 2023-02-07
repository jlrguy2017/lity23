<?php 

if(isset($_POST['register'])){

    include('../includes/db.php');

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['passkey'];


    if($email == ''){
        echo "<script type='text/javascript'>";
        echo "alert('Kindly fill all the details');";
        echo "window.location.href = '../register.php';";
        echo "</script>";
    }
    else{

    $query = "SELECT * FROM `auth` WHERE `email` = '$email'";
    $run = pg_query($conn, $query);

    $count = pg_num_rows($run);

    if($count >= 1){
        echo "<script type='text/javascript'>";
        echo "alert('User Alredy Registered');";
        echo "window.location.href = '../register.php';";
        echo "</script>";
    }
    else{

        $query = "INSERT INTO `auth`(`name`, `email`, `phone`, `password`) VALUES ('$name','$email','$phone','$password')";
        $run = pg_query($conn, $query);

        if($run){
            echo "<script type='text/javascript'>";
            echo "alert('User Registered Successfully');";
            echo "window.location.href = '../index.php';";
            echo "</script>";
        }

    }

}
}


// PHP code for Login

if(isset($_POST['login'])){

    session_start();

    include('../includes/db.php');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `auth` WHERE `email` = '$email' AND `password` = '$password' ";
    $run = pg_query($conn, $query);

    if($run){

        while($row = $run->fetch_assoc()){

            $email2 = $row['email'];
            $password2 = $row['password'];

        }

        if($email == $email2 || $password == $password2){

            $_SESSION['email'] = $email;
            echo "<script type='text/javascript'>";
            echo "alert('Login Success');";
            echo "window.location.href = '../music.php';";
            echo "</script>";

        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('Login Failed');";
            echo "window.location.href = '../register.php';";
            echo "</script>";
        }

    }

}


// Show Profile PHP code

function profile(){


    include('includes/db.php');
    $user = $_SESSION['email'];

    $query = "SELECT * FROM `auth` WHERE `email` = '$user'";
    $run = pg_query($conn, $query);

    if($run){

        while($row = $run->fetch_assoc()){

            ?>
            <tr>
            <form class="editform" action="includes/auth.php" method="post">
                <input class="editinp" type="text" name="name" value="<?php echo $row['name'];?>"><br>
                <input class="editinp" type="email" name="email" value="<?php echo $row['email'];?>"><br>
                <input class="editinp" type="text" name="phone" value="<?php echo $row['phone'];?>"><br>
                <input class="editinp" type="text" name="password" value="<?php echo $row['password'];?>"><br>
                <input class="editbtn" type="submit" name="update" value="Update">
            </form>
            </tr>
            <?php

        }

    }

}


// PHP code for update profile function

if(isset($_POST['update'])){

    session_start();

    $user = $_SESSION['email'];

    include('../includes/db.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $query = "UPDATE `auth` SET `name`='$name',`email`='$email',`phone`='$phone',`password`='$password' WHERE `email` = '$user'";
    $run = pg_query($conn, $query);

    if($run){

        $_SESSION['email'] = $email;
        echo "<script type='text/javascript'>";
        echo "alert('Profile Updated');";
        echo "window.location.href = '../music.php';";
        echo "</script>";
    }

}
