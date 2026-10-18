<?php
require_once "pdo.php";
session_start();

if (isset($_POST['user']) && isset($_POST['key'])) {
    $sql = "INSERT INTO Users (name, password) 
            VALUES (:name, :key)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
        ':name' => $_POST['user'],
        ':key' => $_POST['key'])
        );
        header('Location:index.php');
        return;
    }



?>
<form method="post">

    <p>
    <label for="user">Name:</label>
    <input type="text" name="user">
    </p>
    <p>
    <label for="key">Password:</label>
    <input type="password" name="key">
    </p>
    <p>
        <input type="submit" name="submit" value="Sign Up">
    </p>
</form>

