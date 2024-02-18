<meta name="viewport" content="width=device-width, initial-scale=0.8">
<link href="styles.css" rel="stylesheet">

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php
        require_once("db_login.inc.php");
        require_once("functions.php");
        $mysqli = db_login("todo_db");
        if (isset($_POST['radio_value'])) {
            update_toggle($mysqli, $_POST['radio_value']); // ALTER TABLE for toggle_only_open_todos
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['id'])) {
            update($mysqli, $_POST['id'], $_POST['value']); // ALTER TABLE for status checkbox
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['speichern'])) {
            speichern($mysqli, "todo", $_POST); // INSERT INTO for new To Do's
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else if (isset($_POST['anlegen'])) {
            eintragen(); // call form to insert new to do
            exit;
        }
        auflisten($mysqli); // List todos
        ?>
    </form>
</div>
