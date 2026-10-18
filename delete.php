<?php
require_once "pdo.php";
session_start();
if (isset($_POST['userid']) && isset($_POST['carid'])) {
    if ($_GET['userid']!= $_SESSION['user_id']) {
        $_SESSION['error'] = "You can not delete a record you do not own";
        header("Location: index.php");
        return;
    }
    else {
        $sql = "DELETE FROM Cars WHERE user_id = :id AND car_id = :cid";
        $pstmt = $pdo->prepare($sql);
        $pstmt->execute(array(
            ':id' => $_POST['userid'],
            ':cid' => $_POST['carid']
            ));
        $_SESSION['success'] = "Record successfully deleted";
        header("Location: index.php");
        return;
    }
}


?>
<html>
    <head></head>
    <body>
        
        <form action="delete.php" method="post">
            <input type="hidden" name="userid" value="<?= $_GET['userid'] ?>">
            <input type="hidden" name="carid" value="<?= $_GET['carid'] ?>">
            <input type="submit" name="del" value="Delete">
        </form>
        <a href="index.php">Cancel</a>
        
    </body>
</html>