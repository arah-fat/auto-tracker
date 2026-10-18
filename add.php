<?php
require_once "pdo.php";
session_start();

if (! isset($_SESSION['user_id']) && ! isset($_SESSION['name'])) {
    die('ACCESS DENIED');
    //$_SESSION['error'] = "ACCESS TO add.php DENIED. PLEASE LOGIN TO USE THE APP!" ;
    //header("Location: login.php");
    //return;
}

elseif (isset($_POST['make']) && isset($_POST['model']) 
    && isset($_POST['year']) && isset($_POST['mileage'])) {

    //Data validation
    if (empty(trim($_POST['make'])) || empty(trim($_POST['model']))
        || empty(trim($_POST['year'])) || empty(trim($_POST['mileage']))){
        $_SESSION['error'] = "All fields are required";
        header("Location:add.php");
        return;

       }
    //data validation
    elseif (! is_numeric($_POST['year']) || ! is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Year and Mileage must be numeric!";
        header("Location: add.php");
        return;
    }
    //crud operation
    else {
          $sql = "INSERT INTO Cars (make, model, year, mileage, user_id) 
                  VALUES (:make, :model, :year, :mil, :id)";
                  $pstmt = $pdo->prepare($sql);
                  $pstmt->execute(
                  array(
                  ':make' => $_POST['make'],
                  ':model' => $_POST['model'],
                  ':year' => $_POST['year'],
                  ':mil' => $_POST['mileage'],
                  ':id' => $_SESSION['user_id']
                  ));
                  $_SESSION['success'] = 'successfully added';
                  header('Location:index.php');
                  return;
         }
    }
        
?>
<html>
    <head>
        <title>Auto Tracker</title>
    </head>
    <body>
        <h1>Add New Vehicle</h1>
        <?php
        if (isset($_SESSION['error'])){
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
        }
        ?>
        <pre>
        <form method="post">
            <label for="make">Make:</label>
            <input type="text" name="make" id="make">
            <label for="model">Model:</label>
            <input type="text" name="model" id="model">
            <label for="year">Year:</label>
            <input type="text" name="year" id="year">
            <label for="mileage">Mileage:</label>
            <input type="text" name="mileage" id="mileage">
            <input type="submit" name="submitted" value="Add">
        </form>
        </pre>
        <p>click <a href="logout.php">here</a> to logout</p>
    </body>
</html>