<?php
session_start();
if (isset($_POST['sub'])) {
    session_destroy();
    header("Location: login.php");
}
?>
<html>
    <head></head>
    <body>
        <form method="post">
            <input type="submit" name="sub" value="Logout">
        </form>
    </body>
</html>