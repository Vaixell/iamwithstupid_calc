<!-- Alles neu! -->
<?php

$hehlol = "";

if(isset($_COOKIE['vade_iamwithstupidlochin']) and base64_decode($_COOKIE['vade_iamwithstupidlochin']) == $hehlol){
    $iamwithstupid = true;}

if($_SERVER['QUERY_STRING'] == "lochout"){
    setcookie("vade_iamwithstupidlochin", 0, 1, "/");
    header("Location: ./iamwithstupid.php");}

/**
* Stolen from php.net User Contributed Notes (https://www.php.net/manual/en/function.array-merge-recursive.php#92195)
* Re-styled to fit project's code style.
* @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
* @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
*/
function array_merge_recursive_distinct(array &$array1, array &$array2){
    $merged = $array1;
    foreach($array2 as $key => &$value){
        if(is_array($value) && isset ($merged[$key]) && is_array($merged[$key])){
            $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);}
        else{
            $merged[$key] = $value;}}
    return $merged;}

/**
* Stolen from StackOverflow (https://stackoverflow.com/questions/1708860/php-recursively-unset-array-keys-if-match/10233013#10233013)
* Re-styled to fit project's code style.
* @author Timo Huovinen
*/
function removeRecursive($haystack, $needle){
    if(is_array($haystack)){
        unset($haystack[$needle]);
        foreach($haystack as $k => $value){
            $haystack[$k] = removeRecursive($value, $needle);}}
    return $haystack;}

?>
    
<head>
    <?php include("./templates/main_htmlhead.php"); ?>
    <title>Das I am with stupid!-Kalkulierer!</title>
</head>

<?php include("./templates/main_headnav.php"); ?>

<span class="pagetitle">I am with stupid!-Kalkulierer</span> <?php if(isset($iamwithstupid)){echo("<a href='./iamwithstupid.php?lochout'>Loch-out</a>");} ?> <br /><br />

<?php

$daspasswortwirdhart = "";

if(!isset($_COOKIE['vade_iamwithstupidlochin']) and !isset($_POST['passwort'])){
    include("./templates/iamwithstupid_lochin.php");}
if(isset($_POST['passwort'])){
    if($_POST['passwort'] == $daspasswortwirdhart){
        setcookie("vade_iamwithstupidlochin", base64_encode($hehlol), strtotime("+5 years"), "/");
        header("Location: ./iamwithstupid.php");}
    else{
        echo("<strong>Falsch das Passwort! Glaub ich..</strong><br /><br />");
        include("./templates/iamwithstupid_lochin.php");}}
if(isset($iamwithstupid) and $_SERVER['QUERY_STRING'] == ""){
    echo("<a href='?new'>Neue Runde</a>");}
    
if($_SERVER['QUERY_STRING'] == "update_datta" and isset($iamwithstupid)){
    $sid = $_POST['sid'];
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT days FROM stupis WHERE sid = :sid;');
    $stmt->bindValue(":sid", $sid);
    $stmt->execute();
    if(count($stmt->fetchAll()) == 0){
        header("Location: ./iamwithstupid.php");
        exit();}
    else{
        $stmt->closeCursor();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $json = $row['days'];}
        $array = json_decode($json, true);
        $post = $_POST;
        array_pop($post);
        
        $tmp = array();
        foreach($array['days'] as $key => $val){
            foreach($array['days'][$key]['questions'] as $key2 => $val2){
                foreach($array['days'][$key]['questions'][$key2] as $key3 => $val3){
                    if(is_string($val3)){
                        $tmp['days'][$key]['questions'][$key2]['question'] = $val3;}
                    foreach($post as $key4 => $val4){
                        if($key4 == "antwort_day{$key}_q{$key2}"){
                            foreach($post["antwort_day{$key}_q{$key2}"] as $key5 => $val5){
                                $tmp['days'][$key]['questions'][$key2]['answers'][$key5 + 1]['answer'] = $val5;
                                $tmp2 = $key5 + 1;
                                foreach($post["spieler_day{$key}_q{$key2}_res{$tmp2}"] as $key6 => $val6){
                                    $tmp['days'][$key]['questions'][$key2]['answers'][$tmp2]['responders'][$key6 + 1] = $val6;}}}}}}}}
        
        $new_arr = removeRecursive(array_merge_recursive_distinct($array, $tmp), "0");
        $new_json = json_encode($new_arr);
        
        $stmt = null;
        $sql = null;
        
        $sql = new PDO("sqlite:./sqlite/iamwithstupid");
        $stmt = $sql->prepare('UPDATE stupis SET days = :days WHERE sid = :sid');
        $stmt->bindValue(":days", $new_json);
        $stmt->bindValue(":sid", $sid);
        if($result = $stmt->execute()){
            header("Location: ./iamwithstupid.php?dashboard=$sid");}
        $stmt = null;
        $sql = null;}

if($_SERVER['QUERY_STRING'] == "new" and isset($iamwithstupid)){
    include("./templates/iamwithstupid_new.php");}

if($_SERVER['QUERY_STRING'] == "new_process" and isset($iamwithstupid)){
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('INSERT INTO "stupis" ("date", "leiter", "pass", "days") VALUES (:date, :leiter, :pass, :days);');
    $stmt->bindValue(":date", strtotime("+1 day"));
    $stmt->bindValue(":leiter", $_POST['spielleiter']);
    $stmt->bindValue(":pass", password_hash($_POST['bearbeitungspasswort'], PASSWORD_DEFAULT));
    $stmt->bindValue(":days", file_get_contents("./lib/iamwithstupid_blank.json"));
    if($result = $stmt->execute()){
        header("Location: ./iamwithstupid.php");}
    $result = null;
    $stmt = null;
    $sql = null;}

if(isset($_GET['edit']) and (int)$_GET['edit'] != 0 and isset($iamwithstupid)){
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT sid, new, leiter, date, pass FROM stupis WHERE sid = :sid;');
    $stmt->bindValue(":sid", $_GET['edit']);
    $stmt->execute();
    if(count($stmt->fetchAll()) == 0){
        header("Location: ./iamwithstupid.php");
        exit();}
    else{
        $stmt->closeCursor();
        $stmt->execute();
        while($row = $stmt->fetch()){
            if(!password_verify($_POST['bepass'], $row['pass'])){
                echo("Wrong.<br /><br /><a href='./iamwithstupid.php'>Zurück.</a>");}
            else{
                $leiter = $row['leiter'];
                $date = date("l, d. M Y", $row['date']);
                $ende = date("l, d. M Y", strtotime("$date +4 days"));
                echo("<strong>Runde von $leiter, $date bis $ende</strong><br /><br />");
                if($row['new'] == 1){
                    include("./templates/iamwithstupid_build_fragens.php");}
                else{
                    include("./templates/iamwithstupid_calc.php");}}}}
    $stmt = null;
    $sql = null;}

if($_SERVER['QUERY_STRING'] == "" and isset($iamwithstupid)){
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT sid, date, leiter, days FROM stupis ORDER BY date DESC');
    $stmt->execute();

    echo("<table class='schreibart_kompakt'>");

    while($row = $stmt->fetch()){
        $sid     = $row['sid'];
        $start   = date("l, d. M Y", $row['date']);
        $ende    = date("l, d. M Y", strtotime("$start +4 days"));
        $leiter  = $row['leiter'];
        
        $diff = new DateTime($start);
        $diff->diff(date_create('now'));
        $diff = $diff->getTimestamp();
        $diff = time() - $diff;
        
        if($diff < 0){
            $diff = "<img src='https://gammel.moe/smileys/icon_cross.png' style='vertical-align: middle;' /> Runde is noch nich beginnt!";}
        elseif($diff > 5 * 86400){
            $diff = "<img src='https://gammel.moe/smileys/icon_tick.png' style='vertical-align: middle;' /> Runde is durch!";}
        else{
            $diff = "<img src='https://gammel.moe/smileys/icon_respect.gif' style='vertical-align: middle;' /> Runde is im Gange!";}
        
        $json = $row['days'];
        $array = json_decode($json, true);
        $q = ($array['days'][1]['questions'][1]['question'] == "") ? "<span style='font-size: .8em;'>Keine Fragen eingedingst.</span>" : "<span style='font-size: .8em;'><strong>".$array['days'][1]['questions'][1]['question']."</strong> und weitere Frägengz..</span>";
        
        echo("<tr class='schreibart_bart'>");
        echo("  <td class='schreibart_zeichen'>Runde von $leiter</td>");
        echo("  <td>$start bis $ende<br />$q</td>");
        echo("  <td>$diff</td>");
        echo("  <td><form action='?edit=$sid' method='post'><input type='password' size='13' placeholder='Passwort' name='bepass' /> <input type='submit' value='Edit' /></form></td>");
        echo("</tr>");
        echo("<tr class='spacer'><td class='spacer_td'></td>");}

    echo("</table>");
    $result = null;
    $stmt = null;
    $sql = null;}
    
if($_SERVER['QUERY_STRING'] == "update_questions" and isset($iamwithstupid)){
    $sid = $_POST['sid'];
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT days FROM stupis WHERE sid = :sid;');
    $stmt->bindValue(":sid", $sid);
    $stmt->execute();
    while($row = $stmt->fetch()){
        $json = $row['days'];}
    $stmt = null;
    $sql = null;
    $array = json_decode($json, true);
    /* IN ERINNERUNG AN MEINE UNFÄHIGKEIT, LASS ICH DAS EINFACH MAL HIER SO STEHEN. JA.
    $post = $_POST;
    array_pop($post);
    foreach($post as $key => $var){
        $tmp = explode("_", $key);
        foreach($tmp as $kee => &$val){
            $val = preg_replace('/[^0-9]/', '', $val);}
        $tmp[2] = $var;
        print_r($tmp);
        $j = $tmp[1];
        for($i = 1; $i > 6; $i++){
            foreach($tmp[2] as $dings => $moardings){
                echo($dings."<br />");
                $array['days'][$i]['questions'][$j]['question'] = $dings;}}}
    print_r($array); */// Und statt 'nem kurzen Ding.. Ein Ungetüm:
    $array['days'][1]['questions'][1]['question'] = $_POST['day1_q1'];
    $array['days'][1]['questions'][2]['question'] = $_POST['day1_q2'];
    $array['days'][1]['questions'][3]['question'] = $_POST['day1_q3'];
    $array['days'][1]['questions'][4]['question'] = $_POST['day1_q4'];
    $array['days'][1]['questions'][5]['question'] = $_POST['day1_q5'];
    
    $array['days'][2]['questions'][1]['question'] = $_POST['day2_q1'];
    $array['days'][2]['questions'][2]['question'] = $_POST['day2_q2'];
    $array['days'][2]['questions'][3]['question'] = $_POST['day2_q3'];
    $array['days'][2]['questions'][4]['question'] = $_POST['day2_q4'];
    $array['days'][2]['questions'][5]['question'] = $_POST['day2_q5'];
    
    $array['days'][3]['questions'][1]['question'] = $_POST['day3_q1'];
    $array['days'][3]['questions'][2]['question'] = $_POST['day3_q2'];
    $array['days'][3]['questions'][3]['question'] = $_POST['day3_q3'];
    $array['days'][3]['questions'][4]['question'] = $_POST['day3_q4'];
    $array['days'][3]['questions'][5]['question'] = $_POST['day3_q5'];
    
    $array['days'][4]['questions'][1]['question'] = $_POST['day4_q1'];
    $array['days'][4]['questions'][2]['question'] = $_POST['day4_q2'];
    $array['days'][4]['questions'][3]['question'] = $_POST['day4_q3'];
    $array['days'][4]['questions'][4]['question'] = $_POST['day4_q4'];
    $array['days'][4]['questions'][5]['question'] = $_POST['day4_q5'];
    
    $array['days'][5]['questions'][1]['question'] = $_POST['day5_q1'];
    $array['days'][5]['questions'][2]['question'] = $_POST['day5_q2'];
    $array['days'][5]['questions'][3]['question'] = $_POST['day5_q3'];
    $array['days'][5]['questions'][4]['question'] = $_POST['day5_q4'];
    $array['days'][5]['questions'][5]['question'] = $_POST['day5_q5'];
    // tbh, es hat was.
    $new_json = json_encode($array, JSON_NUMERIC_CHECK);
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('UPDATE stupis SET days = :days, new = :new WHERE sid = :sid');
    $stmt->bindValue(":days", $new_json);
    $stmt->bindValue(":sid", $sid);
    $stmt->bindValue(":new", 0);
    if($result = $stmt->execute()){
        header("Location: ./iamwithstupid.php?dashboard=$sid");}
    $stmt = null;
    $sql = null;}

if(isset($_GET['dashboard']) and (int)$_GET['dashboard'] != 0 and isset($iamwithstupid)){
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT * FROM stupis WHERE sid = :sid;');
    $stmt->bindValue(":sid", $_GET['dashboard']);
    $stmt->execute();
    if(count($stmt->fetchAll()) == 0){
        header("Location: ./iamwithstupid.php");
        $stmt = null;
        $sql = null;
        exit();}
    else{
        $stmt->closeCursor();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $leiter = $row['leiter'];
            $date = date("l, d. M Y", $row['date']);
            $ende = date("l, d. M Y", strtotime("$date +4 days"));}
        echo("<strong>Runde von $leiter, $date bis $ende</strong><br /><br />");
        include("./templates/iamwithstupid_calc.php");}
    $stmt = null;
    $sql = null;}

if(isset($_GET['edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah']) and (int)$_GET['edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah'] != 0 and isset($iamwithstupid)){
    $sql = new PDO("sqlite:./sqlite/iamwithstupid");
    $stmt = $sql->prepare('SELECT * FROM stupis WHERE sid = :sid;');
    $stmt->bindValue(":sid", $_GET['edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah']);
    $stmt->execute();
    if(count($stmt->fetchAll()) == 0){
        header("Location: ./iamwithstupid.php");
        $stmt = null;
        $sql = null;
        exit();}
    else{
        $stmt->closeCursor();
        $stmt->execute();
        while($row = $stmt->fetch()){
            $leiter = $row['leiter'];
            $date = date("l, d. M Y", $row['date']);
            $ende = date("l, d. M Y", strtotime("$date +4 days"));}
        echo("<strong>Runde von $leiter, $date bis $ende</strong><br /><br />");
        include("./templates/iamwithstupid_build_fragens.php");}
    $stmt = null;
    $sql = null;}

?>

<?php include("./templates/main_fuss.php"); ?>
