<?php

function music()
{

    include('includes/db.php');

    $query = "SELECT * FROM `music`";
    $run = pg_query($conn, $query);

    if ($run) {

        while ($row = $run->fetch_assoc()) {

            ?>
            <tr>
                <td class="musicth"><?php echo $row['title']; ?></td>
                <td class="musicth"><?php echo $row['category']; ?></td>
                <td class="musicth"><?php echo $row['language']; ?></td>
                <td class="musicth"><audio controls>
                        <source src="music/<?php echo $row['src']; ?>" type="audio/mpeg">
                    </audio></td>
                <td class="musicth"><button class="downloadbtn" onclick="window.location.href= 'music/<?php echo $row['src']; ?>'">Download</button></td>
            </tr>
            <?php

        }
    }
}

// user profile PHP code starts here

function user()
{

    session_start();

    include('includes/db.php');
    $email = $_SESSION['email'];

    $query = "SELECT * FROM `auth` WHERE `email` = '$email'";
    $run = pg_query($conn, $query);

    if ($run) {

        while ($row = $run->fetch_assoc()) {

        ?>
            <h1 class="musich1">Hello, <?php echo $row['name']; ?></h1>
            <?php

        }
    }
}


// music language & category filter PHP code

function search()
{

    if (isset($_POST['search'])) {

        include('includes/db.php');

        $lang = $_POST['language'];

        $query = "SELECT * FROM `music` WHERE `language` = '$lang'";
        $run = pg_query($conn, $query);

        if ($run) {

            while ($row = $run->fetch_assoc()) {

                ?>
                <tr>
                    <td class="musicth"><?php echo $row['title']; ?></td>
                    <td class="musicth"><?php echo $row['category']; ?></td>
                    <td class="musicth"><?php echo $row['language']; ?></td>
                    <td class="musicth"><audio controls>
                            <source src="music/<?php echo $row['src']; ?>" type="audio/mpeg">
                        </audio></td>
                    <td class="musicth"><button class="downloadbtn" onclick="window.location.href= 'music/<?php echo $row['src']; ?>'">Download</button></td>
                </tr>
                <?php

            }
        }
    }
}


// Add Music PHP code

if(isset($_POST['addmusic'])){

    session_start();

    $user = $_SESSION['email'];

    include('../includes/db.php');

    $file = $_FILES['music']['name'];
    move_uploaded_file($_FILES['music']['tmp_name'], "../music/".$file);

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $cat = $_POST['category'];
    $lang = $_POST['language'];

    $query = "INSERT INTO `music`(`title`, `description`, `src`, `category`, `language`, `user`) VALUES ('$title','$desc','$file','$cat','$lang','$user')";
    $run = mysqli_query($conn, $query);

    if($run){

        echo "<script type='text/javascript'>";
        echo "alert('Music Uploaded Successfully');";
        echo "window.location.href = '../music.php';";
        echo "</script>";

    }

}


// Delete Music page PHP code

function deletemusic(){

$user = $_SESSION['email'];

include('includes/db.php');

$query = "SELECT * FROM `music` WHERE `user` = '$user'";
$run = pg_query($conn, $query);

if($run){

    while($row = $run->fetch_assoc()){

        ?>
        <tr>
            <td class="deleteth"><?php echo $row['title']; ?></td>
            <td class="deleteth"><?php echo $row['category']; ?></td>
            <td class="deleteth"><?php echo $row['language']; ?></td>
            <td class="deleteth"><audio controls>
                    <source src="music/<?php echo $row['src']; ?>" type="audio/mpeg">
                </audio></td>
            <td class="deleteth"><form action="includes/music.php" method="post">
                <input type="text" name="id" hidden value="<?php echo $row['id']; ?>">
                <input type="submit" class="downloadbtn" name="delete" value="Delete">
            </form></td>
            </tr>
        <?php

    }
}

}



// Delete Music Function PHP code

if(isset($_POST['delete'])){

    include('../includes/db.php');

    $id = $_POST['id'];

    $query = "DELETE FROM `music` WHERE `id` = $id";
    $run = pg_query($conn, $query);

    if($run){

        echo "<script type='text/javascript'>";
        echo "alert('Music Deleted Successfully');";
        echo "window.location.href = '../music.php';";
        echo "</script>";

    }

}
