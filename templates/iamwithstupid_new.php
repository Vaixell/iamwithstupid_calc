<strong>Voll noi!</strong><br /><br />

<?php

$date = date("l, d. M Y", strtotime("+1 day"));

?>

<form action="?new_process" method="post">
    <table>
        <tr>
            <td>Spielleiter:</td>
            <td><input type="text" size="26" placeholder="Spielleiter" name="spielleiter" /></td>
        </tr>
        <tr>
            <td>Startdatum (morgen):</td>
            <td><input type="text" size="26" placeholder="Startdatum" name="startdatum" value=<?php echo('"'.$date.'"'); ?> readonly /></td>
        </tr>
            <td><span title="Kann nicht wiederhergestellt werden! Nur der Spielleiter kann seine Runde bearbeiten. Und.. naja, Nexi, wenn er anner Datenbank rumfummeln würde. Aber das machter nich. :< Das wär böse. :<" style="border-bottom: 1px dotted gray">? Bearbeitungspasswort:</span></td>
            <td><input type="password" size="26" placeholder="Bearbeitungspasswort" name="bearbeitungspasswort" /></td>
        </tr>
    </table>
    <br /><a href="./iamwithstupid.php">Zurück</a> .. <input type="submit" value="Baumarkt" />
</form>
