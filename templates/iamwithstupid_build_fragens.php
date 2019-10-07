<?php

$sql = new PDO("sqlite:./sqlite/iamwithstupid");
$stmt = $sql->prepare('SELECT date, days FROM stupis WHERE sid = :sid;');
if(isset($_GET['edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah'])) $sid = $_GET['edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah']; if(isset($_GET['edit'])) $sid = $_GET['edit'];
$stmt->bindValue(":sid", $sid);
$stmt->execute();
while($row = $stmt->fetch()){
    $date1 = date("l, d. M Y", $row['date']);
    $date2 = date("l, d. M Y", strtotime("$date1 +1 day"));
    $date3 = date("l, d. M Y", strtotime("$date1 +2 days"));
    $date4 = date("l, d. M Y", strtotime("$date1 +3 days"));
    $date5 = date("l, d. M Y", strtotime("$date1 +4 days"));
    
    $json = $row['days'];
    $array = json_decode($json, true);}

?>

Bearbeitung der Frägens. Müssen hier seperat gebaut werden. Falls das hier die erste Runde jemals für dir is: Nur der erste Tag muss jetzt ausgefüllt werden, der Rest lässt sich auch danach nachholen.<br />
<span style="font-size: .8em">Tatsächlich gibt's hier keinerlei Überprüfung, was wie ausgefüllt is. Trotzdem machen, sonst kaputt, ok? :<</span><br /><br />

<form action="?update_questions" method="post">
    <div id="iamwithstupid_day">
        <strong>Tag 1: <?php echo($date1); ?></strong><br />
        <input type="text" size="69" placeholder="Nenne..." name="day1_q1" value=<?php echo('"'.$array['days'][1]['questions'][1]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day1_q2" value=<?php echo('"'.$array['days'][1]['questions'][2]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day1_q3" value=<?php echo('"'.$array['days'][1]['questions'][3]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day1_q4" value=<?php echo('"'.$array['days'][1]['questions'][4]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day1_q5" value=<?php echo('"'.$array['days'][1]['questions'][5]['question'].'"'); ?> /><br />
    </div><br />
    <div id="iamwithstupid_day">
        <strong>Tag 2: <?php echo($date2); ?></strong><br />
        <input type="text" size="69" placeholder="Nenne..." name="day2_q1" value=<?php echo('"'.$array['days'][2]['questions'][1]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day2_q2" value=<?php echo('"'.$array['days'][2]['questions'][2]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day2_q3" value=<?php echo('"'.$array['days'][2]['questions'][3]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day2_q4" value=<?php echo('"'.$array['days'][2]['questions'][4]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day2_q5" value=<?php echo('"'.$array['days'][2]['questions'][5]['question'].'"'); ?> /><br />
    </div><br />
    <div id="iamwithstupid_day">
        <strong>Tag 3: <?php echo($date3); ?></strong><br />
        <input type="text" size="69" placeholder="Nenne..." name="day3_q1" value=<?php echo('"'.$array['days'][3]['questions'][1]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day3_q2" value=<?php echo('"'.$array['days'][3]['questions'][2]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day3_q3" value=<?php echo('"'.$array['days'][3]['questions'][3]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day3_q4" value=<?php echo('"'.$array['days'][3]['questions'][4]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day3_q5" value=<?php echo('"'.$array['days'][3]['questions'][5]['question'].'"'); ?> /><br />
    </div><br />
    <div id="iamwithstupid_day">
        <strong>Tag 4: <?php echo($date4); ?></strong><br />
        <input type="text" size="69" placeholder="Nenne..." name="day4_q1" value=<?php echo('"'.$array['days'][4]['questions'][1]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day4_q2" value=<?php echo('"'.$array['days'][4]['questions'][2]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day4_q3" value=<?php echo('"'.$array['days'][4]['questions'][3]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day4_q4" value=<?php echo('"'.$array['days'][4]['questions'][4]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day4_q5" value=<?php echo('"'.$array['days'][4]['questions'][5]['question'].'"'); ?> /><br />
    </div><br />
    <div id="iamwithstupid_day">
        <strong>Tag 5: <?php echo($date5); ?></strong><br />
        <input type="text" size="69" placeholder="Nenne..." name="day5_q1" value=<?php echo('"'.$array['days'][5]['questions'][1]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day5_q2" value=<?php echo('"'.$array['days'][5]['questions'][2]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day5_q3" value=<?php echo('"'.$array['days'][5]['questions'][3]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day5_q4" value=<?php echo('"'.$array['days'][5]['questions'][4]['question'].'"'); ?> /><br />
        <input type="text" size="69" placeholder="Nenne..." name="day5_q5" value=<?php echo('"'.$array['days'][5]['questions'][5]['question'].'"'); ?> /><br />
    </div><br />
    <input type="hidden" value=<?php echo('"'.$sid.'"'); ?> name="sid" />
    <input type="hidden" value="true" name="lochedin" />
    <input type="submit" value="Viel zu viele Frägens, weitdah!" />
</form>
