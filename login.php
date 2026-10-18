<?php
require_once "pdo.php";
session_start();

if (isset($_POST['name']) && isset($_POST['pass'])) {
    if (empty(trim($_POST['name'])) || empty(trim($_POST['pass']))){
        $_SESSION['error'] = "All fields are required";
        header("Location:login.php");
        return;
        }
    else {
        $sql = "SELECT * FROM Users WHERE name=:name AND password=:password";
        $pstmt = $pdo->prepare($sql);
        $pstmt->execute(
            array(
                ':name' => $_POST['name'],
                ':password' => $_POST['pass']
            ));
        $row = $pstmt->fetch(PDO::FETCH_ASSOC);
        //print_r($row);
        if ($row == false) {
            $_SESSION['error'] = "Password or username is incorrect";
            header("Location: login.php");
            return;
            }
        else {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            header("Location: index.php");
            return;
             }
         }
    }
?>
<html>
    <head></head>
    <body>
        <h1>Please login here</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        ?>

        <form method="post">
            <p>
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </p>
            <p>
                <label for="pass">Password</label>
                <input type="password" name="pass" id="pass">
            </p>
            <p>
                <input type="submit" name="submitted" value="Log In" id="submitted">
            </p>
        </form>
    </body>
</html>