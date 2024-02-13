<?php

function auflisten($mysqli)
{
    echo "<h1>To Do's</h1>";
    $sql_config = "SELECT value FROM config WHERE setting = 'toggle_only_open_todos';";
    $result_config = $mysqli->query($sql_config);
    if ($result_config) {
        $row = $result_config->fetch_row();
        if ($row) {
            $toggle_only_open_todos = $row[0];
        }
    }
    if ($toggle_only_open_todos == 0) {
        echo "<input type='radio' name='radio-group' value='option1' data-id='new-radio-1' data-value='0' checked>Alle To Do's ";
        echo "<input type='radio' name='radio-group' value='option1' data-id='new-radio-2' data-value='1'>Offene To Do's <br><br>";
    } else {
        echo "<input type='radio' name='radio-group' value='option1' data-id='new-radio-1' data-value='0'>Alle To Do's        ";
        echo "<input type='radio' name='radio-group' value='option1' data-id='new-radio-2' data-value='1' checked>Offene To Do's <br><br>";
    }
?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const radio_id = this.getAttribute('data-id');
                    const radio_value = this.getAttribute('data-value');
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'main.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            location.reload();
                        }
                    };
                    console.log(radio_id);
                    console.log(radio_value);
                    xhr.send('radio_id=' + encodeURIComponent(radio_id) + '&radio_value=' + encodeURIComponent(radio_value));
                });
            });
        });
    </script>
    <?php

    echo "<table border='1'>";
    if ($toggle_only_open_todos == 0) {
        $sql = "SELECT id, bezeichnung AS Bezeichnung, faelligkeit AS Fälligkeit, status AS Status FROM todo ORDER BY faelligkeit";
    } else {
        $sql = "SELECT id, bezeichnung AS Bezeichnung, faelligkeit AS Fälligkeit, status AS Status FROM todo where status = 0 ORDER BY faelligkeit";
    }

    $result = $mysqli->query($sql);
    $todos_all = 0;
    echo "<tr>\n";
    while ($attribut = $result->fetch_field()) {
        echo "<th style='font-size: 18px;'>$attribut->name</th>\n";
    }
    echo "<th style='font-size: 18px;'>Checkbox</th>";
    echo "</tr>\n";
    while ($todo = $result->fetch_assoc()) {
        echo "<tr>\n";
        foreach ($todo as $key => $value) {
            echo "<td>$value</td> \n";
            $todos_all++;
        }
        $isChecked = $value == 1 ? 'checked' : '';
        echo "<td><input type='checkbox' data-id='{$todo['id']}' $isChecked></td>";
        echo "</tr>\n";
    }
    ?>
    </table>
    <br>

    <?php
    $todos_all = $todos_all / 4;
    echo "To Do's gesamt: $todos_all";
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const value = this.checked ? 1 : 0;
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'main.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            location.reload();
                        }
                    };
                    xhr.send('id=' + encodeURIComponent(id) + '&value=' + encodeURIComponent(value));
                });
            });
        });
    </script>

    <p style="text-align:left">
        <input type="submit" name="anlegen" value="Erfassen eines neuen To-Dos" />
    </p>
<?php
}


function eintragen()
{
?>
    <div class="container_eintragen">
        <br><br><br><br>
        <table border="0">
            <tr>
                <td>Bezeichnung: </td>
                <td><input type="text" name="bezeichnung" required /></td>
            </tr>
            <tr>
                <td>Fälligkeitsdatum: </td>
                <td><input type="date" name="faelligkeit" required/></td>
            </tr>
        </table>
        <p><input type="submit" name="speichern" value="Speichern" /></p>
    </div>
<?php
}


function update_toggle($mysqli, $value)
{
    $sql = "update config set value = $value where setting = 'toggle_only_open_todos';";
    $mysqli->query($sql);
}


function update($mysqli, $id, $value)
{
    $sql = "update todo set status = $value where id = $id;";
    $mysqli->query($sql);
}



function speichern($mysqli, $tabelle, $daten)
{
    $spalten = array();
    $werte = array();
    foreach ($daten as $key => $value) {
        if ($key != "speichern") {
            $spalten[] = $key;
            $value = $mysqli->escape_string($value);
            $werte[] = "'$value'";
        }
    }
    $sql = "INSERT INTO $tabelle ";
    $sql .= "(" . implode(",", $spalten) . ")";
    $sql .= " VALUES ";
    $sql .= "(" . implode(",", $werte) . ")";
    $mysqli->query($sql);
}

?>