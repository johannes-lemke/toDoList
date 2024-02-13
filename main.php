<meta name="viewport" content="width=device-width, initial-scale=0.6">
<link href="styles.css" rel="stylesheet">

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php
        require_once("db_login.inc.php");
        require_once("functions.php");
        $mysqli = db_login("todo_db");
        if (isset($_POST['radio_value'])) {
            update_toggle($mysqli, $_POST['radio_value']);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['id'])) {
            update($mysqli, $_POST['id'], $_POST['value']);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['speichern'])) {
            speichern($mysqli, "todo", $_POST);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['anlegen'])) {
            eintragen();
            exit;
        }
        auflisten($mysqli);
        ?>
    </form>
</div>
