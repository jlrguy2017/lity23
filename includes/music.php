<?php

function music()
{
    include('includes/db.php');

    $query = "SELECT * FROM `music`";
    $result = pg_query($conn, $query);

    if ($result) {

        while ($row = pg_fetch_assoc($result)) {

            ?>
            <tr>
                <td class="musicth"><?php echo htmlspecialchars($row['title']); ?></td>
                <td class="musicth"><?php echo htmlspecialchars($row['category']); ?></td>
                <td class="musicth"><?php echo htmlspecialchars($row['language']); ?></td>
                <td class="musicth">
                    <audio controls>
                        <source src="music/<?php echo htmlspecialchars($row['src']); ?>" type="audio/mpeg">
                    </audio>
                </td>
                <td class="musicth">
                    <a href="music/<?php echo htmlspecialchars($row['src']); ?>" class="downloadbtn">Download</a>
                </td>
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

    $email = $_SESSION['email'] ?? '';
    if (!$email) {
        return;
    }

    $query = "SELECT name FROM `auth` WHERE `email` = $1";
    $result = pg_query_params($conn, $query, [$email]);
    if (!$result) {
        return;
    }

    $row = pg_fetch_assoc($result);
    if (!$row) {
        return;
    }

    $name = $row['name'];
    echo '<h1 class="musich1">Hello, ' . htmlentities($name) . '</h1>';
}
// music language & category filter PHP code

function search()
{

    if (isset($_POST['search'])) {

        include('includes/db.php');

        $lang = $_POST['language'];

        $query = "SELECT * FROM `music` WHERE `language` = '$lang'";
        $result = pg_query($conn, $query);

        if ($result) {

            while ($row = pg_fetch_assoc($result)) {

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

if (isset($_POST['addmusic'])) {
    session_start();

    $user = $_SESSION['email'];

    include('../includes/db.php');

    $file = $_FILES['music']['name'];
    $file_tmp = $_FILES['music']['tmp_name'];
    $file_size = $_FILES['music']['size'];
    $file_error = $_FILES['music']['error'];
    $file_type = $_FILES['music']['type'];

    $file_ext = explode('.', $file);
    $file_ext = strtolower(end($file_ext));

    $allowed = array('mp3', 'wav', 'ogg');

    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            if ($file_size <= 5000000) {
                $file_new_name = uniqid('', true) . '.' . $file_ext;
                $file_destination = '../music/' . $file_new_name;
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $title = $_POST['title'];
                    $desc = $_POST['description'];
                    $cat = $_POST['category'];
                    $lang = $_POST['language'];

                    $query = "INSERT INTO `music`(`title`, `description`, `src`, `category`, `language`, `user`) VALUES ('$title','$desc','$file_new_name','$cat','$lang','$user')";
                    $run = pg_query($conn, $query);

                    if ($run) {
                        echo "<script type='text/javascript'>";
                        echo "alert('Music Uploaded Successfully');";
                        echo "window.location.href = '../music.php';";
                        echo "</script>";
                    }
                }
            }
        }
    }
}
// Delete Music page PHP code

function deletemusic()
{
    session_start();

    $user = $_SESSION['email'];

    include('includes/db.php');

    $query = "SELECT * FROM `music` WHERE `user` = '$user'";
    $run = pg_query($conn, $query);

    if ($run) {

        while ($row = pg_fetch_assoc($run)) {

            ?>
            <tr>
                <td class="deleteth"><?php echo $row['title']; ?></td>
                <td class="deleteth"><?php echo $row['category']; ?></td>
                <td class="deleteth"><?php echo $row['language']; ?></td>
                <td class="deleteth"><audio controls>
                        <source src="music/<?php echo $row['src']; ?>" type="audio/mpeg">
                    </audio></td>
                <td class="deleteth">
                    <form action="includes/music.php" method="post">
                        <input type="text" name="id" hidden value="<?php echo $row['id']; ?>">
                        <input type="submit" class="downloadbtn" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
            <?php
        }
    }
}
if (isset($_POST['delete'])) {
    include('../includes/db.php');

$id = $_POST['id'];

$query = "DELETE FROM `music` WHERE `id` = $id";
$run = pg_query($conn, $query);

if ($run) {

    echo "<script type='text/javascript'>";
    echo "alert('Music Deleted Successfully');";
    echo "window.location.href = '../music.php';";
    echo "</script>";

} else {
    echo "<script type='text/javascript'>";
    echo "alert('Error: Music not deleted');";
    echo "window.location.href = '../music.php';";
    echo "</script>";
}
