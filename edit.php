<?php
require_once "pdo.php";
session_start();
if (isset($_POST['make']) && isset($_POST['model']) && 
    isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['userid'])) {
        if ($_POST['userid'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "You can't edit records that aren't yours!";
            header("Location: edit.php?userid=".$_POST['userid']);
            return;
        }
        if (empty(trim($_POST['make'])) || empty(trim($_POST['model']))
            || empty(trim($_POST['year'])) || empty(trim($_POST['mileage']))) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: edit.php?userid=".$_POST['userid']);
            return;
        }

        elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
            $_SESSION['error'] = "Year and mileage must be numeric!";
             header("Location: edit.php?userid=".$_POST['userid']);
            return;
        }

        else {
            $sql = "UPDATE Cars SET make = :make, model = :model, 
            year = :yr, mileage = :mil WHERE user_id = :id AND car_id = :cid";
            $pstmt = $pdo->prepare($sql);
            $pstmt->execute(array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':yr' => $_POST['year'] ,
                ':mil' => $_POST['mileage'],
                ':id' => $_POST['userid'],
                ':cid' => $_POST['carid']               
            ));
            $_SESSION['success'] = "Record uccessfully edited";
            header("Location: index.php");
            return;
        }
}

if ( ! isset($_GET['userid']) ) {
  $_SESSION['error'] = "Missing user id";
  header('Location: index.php');
  return;
}

$sql = "SELECT * FROM Cars WHERE user_id=:id";
$psql = $pdo->prepare($sql);
$psql->execute(
    array(
        ':id' => $_GET['userid']
    )
);
$row = $psql->fetch(PDO::FETCH_ASSOC); 
if ($row == false) {
    $_SESSION['error'] = "Bad value for user id";
    header("Location: index.php");
    return;
}
else {
    // Pass the record data to the view.
    $carmake = htmlentities($row['make']);
    $carmod = htmlentities($row['model']);
    $yr = htmlentities($row['year']);
    $mil = htmlentities($row['mileage']);
    $id = htmlentities($row['user_id']);
    $cid = htmlentities($row['car_id']);

}
?>
<html>
    <head>
        <title>Auto Tracker</title>
    </head>
    <body>
        <h1>Edit a record</h1>
        <?php
        if (isset($_SESSION['error'])){
            echo '<p style="color:red">'.$_SESSION['error']."<p>\n";
            unset($_SESSION['error']);
        }
        ?>
        <pre>
        <form method="post">
            <label for="make">Make:</label>
            <input type="text" name="make" id="make" value="<?= $carmake ?>"> <!--<p>pass the record data</p> -->
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" value="<?= $carmod ?>">
            <label for="year">Year:</label>
            <input type="text" name="year" id="year" value="<?= $yr ?>">
            <label for="mileage">Mileage:</label>
            <input type="text" name="mileage" id="mileage" value="<?= $mil ?>">
            <input type="hidden" name="userid" value="<?= $id ?>">
            <input type="hidden" name="carid" value="<?= $cid ?>">
            <input type="submit" name="submitted" value="Update">
        </form>
        </pre>
    </body>
</html>