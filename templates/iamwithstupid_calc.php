<?php
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno){
    if(error_reporting() == 0){
        return;}
    if(error_reporting() & $severity){
        throw new ErrorException($message, 0, $severity, $filename, $lineno);}}

if(isset($_GET['dashboard'])) $sid = $_GET['dashboard']; if(isset($_GET['edit'])) $sid = $_GET['edit'];

$sql = new PDO("sqlite:./sqlite/iamwithstupid");
$stmt = $sql->prepare('SELECT * FROM stupis WHERE sid = :sid;');
$stmt->bindValue(":sid", $sid);
$stmt->execute();

while($row = $stmt->fetch()){
    $json = $row['days'];}
$stmt = null;
$sql = null;
$array = json_decode($json, true);

?>
<table><tr><td>
<?php echo("<a href='?edit_fragengs_zwei_verschiedenen_urls_fuer_so_fragens_bearbeiten_woah=$sid'>Fragen bearbeiten</a>"); ?>
<form action="?update_datta" method="post">

<datalist id="leute">
    <?php
        $sql = new PDO("sqlite:./sqlite/iamwithstupid");
        $stmt = $sql->prepare('SELECT * FROM leute');
        $stmt->execute();
        while($row = $stmt->fetch()){
            $d00d = $row['name'];
            echo("<option value='$d00d' />");}
        echo("</datalist>");
        $stmt->closeCursor();
        $stmt->execute();
        echo("<script>");
        echo("var leutz = [];");
        while($row = $stmt->fetch()){
            $d00d = $row['name'];
            echo("leutz.push('$d00d');");}
        echo("</script>");

    // AUS ALT...
    /*for($i = 1; $i < 6; $i++){
        echo("<div id='iamwithstupid_day' name='$i'>");
        echo("  <h2>Tag $i</h2>");
        for($j = 1; $j < 6; $j++){
            echo("<strong>Frage $j: ".$array['days'][$i]['questions'][$j]['question']."</strong>");
            echo("<div id='iamwithstupid_frage' name='$j'>");
            echo("  <div id='iamwithstupid_antworten' name='1'>");
            echo("      <input type='text' size='26' placeholder='Antwort' name='antwort_day{$i}_q{$j}[]' /> <div class='plus' onclick='addAntwort(this, $i, $j)'>+</div>");
            echo("      <div id='iamwithstupid_respondas'>");
            echo("          <input type='text' size='26' placeholder='Spieler / Antwortgeber' name='spieler_day{$i}_q{$j}_res1[]' list='leute' autocomplete='off' oninput='tscheckInput(this)' /> <div class='plus' onclick='addSpieler(this, $i, $j)'>+</div>");
            echo("  </div></div></div>");}
        echo("</div>");}*/

    // ..MACH NEU!
    foreach($array['days'] as $key => $val){
        $ehrray['days'][$key]['leutz'] = array();
        echo("<div id='iamwithstupid_day' name='$key'>");
        echo("  <h2>Tag $key</h2>");
        foreach($array['days'][$key]['questions'] as $key2 => $val2){
            echo("<strong>Frage $key2: ".$array['days'][$key]['questions'][$key2]['question']."</strong>");
            echo("<div id='iamwithstupid_frage' name='$key2'>");
            foreach($array['days'][$key]['questions'][$key2]['answers'] as $key3 => $val3){
                $numbah = count($array['days'][$key]['questions'][$key2]['answers']);
                echo("<div id='iamwithstupid_antworten' name='$key3'>");
                echo("  <input type='text' size='26' placeholder='Antwort' name='antwort_day{$key}_q{$key2}[]' value='{$val3["answer"]}' />");
                if($key3 == $numbah){
                    echo(" <div class='plus' onclick='addAntwort(this, $key, $key2)'>+</div>");}
                if($key3 == $numbah and $numbah != 1){
                    echo("<div class='minus' onclick='removeDasAntowrt(this)'>-</div>");}
                foreach($val3['responders'] as $key4 => $val4){
                    $numbahh = count($val3['responders']);
                    $ehrray['days'][$key]['answer'][$key2]['responses'] = $numbahh;
                    $ehrray['days'][$key]['leutz']["$val4"] = $ehrray['days'][$key]['leutz']["$val4"] ?? null;
                    $ehrray['days'][$key]['leutz']["$val4"] += $numbahh;
                    echo("<div id='iamwithstupid_respondas'>");
                    echo("  <input type='text' size='26' placeholder='Spieler / Antwortgeber' name='spieler_day{$key}_q{$key2}_res{$key3}[]' list='leute' autocomplete='off' oninput='tscheckInput(this)' value='$val4' />");
                    if($key4 == $numbahh or $key4 == 0){
                        echo(" <div class='plus' onclick='addSpieler(this, $key, $key2)'>+</div>");}
                    if($key4 == $numbahh and $numbahh != 1){
                        echo("<div class='minus' onclick='removeDasMensch(this)'>-</div>");}
                    echo("</div>");}
                echo("</div>");}
            echo("</div><br />");}
        echo("</div>");}

?>
<input type="hidden" value=<?php echo('"'.$sid.'"'); ?> name="sid" />
<br /><input type="submit" value="Sändän!" id="sendn_butt" />
<span id="nix_senden_ne" style="color: red; display: none;"><img src="https://gammel.moe/smileys/icon_cross.png" style="vertical-align: middle;" /> Einer oder mehrere Namen von antwortgebenen Personen is nix gefunden. Buh.</span>
</form>
<td><td style="vertical-align: top; width: 48%;">
<?php

    foreach($ehrray['days'] as $key => &$val){
        ksort($val['leutz'], SORT_NATURAL | SORT_FLAG_CASE);
        arsort($val['leutz']);
        $punktz[] = $val['leutz'];}

    function finalize($final, $arr2, $arr2_key){
        foreach($arr2_key as $val){
            if(!isset($final["$val"])){
                $final["$val"] = $arr2["$val"];}
            else{
                $final["$val"] += $arr2["$val"];}}
        return $final;}

    $final = $punktz[0];
    for($i = 1; $i < 5; $i++){
        $final_ = finalize($final, $punktz[$i], array_keys($punktz[$i]));}
    ksort($final_, SORT_NATURAL | SORT_FLAG_CASE);
    arsort($final_);
    
    $irgendwas = false;
    $irgendwas2 = false;
    $calculated = $final;
    $leckmir = 1;
    $leckmir2 = 1;
    foreach($array['days'] as $key => $val){
        echo("<h2>Tag $key</h2>");
        foreach($val['questions'] as $key2 => $val2){
            echo("<strong>".$val2['question']."</strong>");
            echo("<div id='arsch' style='margin-left: 26px;'>");
            foreach($val2['answers'] as $key3 => $val3){
                $times_answered = count($val3['responders']);
                echo("<strong>".$times_answered."x</strong> ");
                echo($val3['answer']."<br />");}
            echo("</div>");}
        echo("<br />");
        $givemezeloopsbrother = 0;
        $fuckey = null;
        foreach($punktz[$key - 1] as $dude => $heh){
            if(!$irgendwas){
                $highscore = $heh;
                $irgendwas = true;}
            if($heh == $highscore){
                echo("<strong>");}
            $fuckey[] = $heh;
            if(isset($fuckey[1])){
                if($fuckey[$givemezeloopsbrother - 1] != $fuckey[$givemezeloopsbrother]){
                    $leckmir++;}}
            $dah[$key][$dude] = $leckmir;
            echo($leckmir.". ");
            echo("@".$dude." :: ".$heh." Punkte<br />");
            if($heh == $highscore){
                echo("</strong>");}
            $givemezeloopsbrother++;}
        $irgendwas = false;
        $leckmir = 1;
        if($key > 1){
            $calculated = finalize($calculated, $punktz[$key - 1], array_keys($punktz[$key - 1]));
            ksort($calculated, SORT_NATURAL | SORT_FLAG_CASE);
            arsort($calculated);
            echo("<br />");
            $givemezeloopsbrother2 = 0;
            $fuckey2 = null;
            foreach($calculated as $dude2 => $heh2){
                if(!$irgendwas2){
                    $highscore2 = $heh2;
                    $irgendwas2 = true;}
                if($heh2 == $highscore2){
                    echo("<strong>");}
                $fuckey2[] = $heh2;
                if(isset($fuckey2[1])){
                    if($fuckey2[$givemezeloopsbrother2 - 1] != $fuckey2[$givemezeloopsbrother2]){
                        $leckmir2++;}}
                $dah[$key][$dude2] = $leckmir2;
                foreach($dah as $ki => &$wi){
                    ksort($wi);
                    asort($wi, SORT_NATURAL | SORT_FLAG_CASE);}
                echo($leckmir2.". ");
                echo("(");
                try{
                    $newding = $dah[$key - 1][$dude2] - $dah[$key][$dude2];}
                catch(Exception $e){
                    $newding = 0;}
                if($newding > 0){
                    echo("+");}
                echo($newding);
                echo(") ");
                echo("@".$dude2." :: ".$heh2." Punkte<br />");
                if($heh2 == $highscore2){
                    echo("</strong>");}
                $givemezeloopsbrother2++;}
            $leckmir2 = 1;
            $irgendwas2 = false;}}

?>
</td></tr></table>

<script>
	function addAntwort(antwort, day, question){
		papaElement = antwort.parentElement;
		numbah = parseInt(papaElement.getAttribute("name"));
		if(numbah != 1){
		    antwort.nextElementSibling.remove();}
		antwort.remove();
		papaElement.insertAdjacentHTML("afterend", `<div id='iamwithstupid_antworten' name='${numbah + 1}'><input type='text' size='26' placeholder='Antwort' name='antwort_day${day}_q${question}[]' /> <div class='plus' onclick='addAntwort(this, ${day}, ${question})'>+</div> <div class='minus' onclick='removeDasAntowrt(this)'>-</div><div id='iamwithstupid_respondas'><input type='text' size='26' placeholder='Spieler / Antwortgeber' name='spieler_day${day}_q${question}_res${numbah + 1}[]' list='leute' autocomplete='off' oninput='tscheckInput(this)' /> <div class='plus' onclick='addSpieler(this, ${day}, ${question})'>+</div></div></div>`);}
	function addSpieler(spieler, day, question){
		papaElement = spieler.parentElement;
		numbah = parseInt(papaElement.parentElement.getAttribute("name"));
		try{
		    spieler.nextElementSibling.remove();}
		catch(e){}
		spieler.remove();
		papaElement.insertAdjacentHTML("afterend", `<div id='iamwithstupid_respondas'><input type='text' size='26' placeholder='Spieler / Antwortgeber' name='spieler_day${day}_q${question}_res${numbah}[]' list='leute' autocomplete='off' oninput='tscheckInput(this)' /> <div class='plus' onclick='addSpieler(this, ${day}, ${question})'>+</div> <div class='minus' onclick='removeDasMensch(this)'>-</div></div>`);}
	function removeDasAntowrt(anton){
		papaElement = anton.parentElement;
		day = parseInt(papaElement.parentElement.parentElement.getAttribute("name"));
		q = parseInt(papaElement.parentElement.getAttribute("name"));
	    anton.parentElement.previousElementSibling.firstElementChild.insertAdjacentHTML("afterend", ` <div class='plus' onclick='addAntwort(this, ${day}, ${q})'>+</div>`);
		erstesDing = papaElement.firstElementChild;
	    if(anton.parentElement.previousElementSibling.firstElementChild != erstesDing){
	        anton.parentElement.previousElementSibling.firstElementChild.nextElementSibling.insertAdjacentHTML("afterend", " <div class='minus' onclick='removeDasAntowrt(this)'>-</div>");}
		papaElement.remove();
		clearShit(anton.nextElementSibling.firstElementChild);}
	function removeDasMensch(enfleisch){
		papaElement = enfleisch.parentElement;
		day = parseInt(papaElement.parentElement.parentElement.parentElement.getAttribute("name"));
		q = parseInt(papaElement.parentElement.parentElement.getAttribute("name"));
		enfleisch.parentElement.previousElementSibling.firstElementChild.insertAdjacentHTML("afterend", ` <div class='plus' onclick='addSpieler(this, ${day}, ${q})'>+</div>`);
		erstesDing = papaElement.firstElementChild;
		if(enfleisch.parentElement.previousElementSibling.firstElementChild != erstesDing){
		    enfleisch.parentElement.previousElementSibling.lastElementChild.insertAdjacentHTML("afterend", " <div class='minus' onclick='removeDasMensch(this)'>-</div>");}
		papaElement.remove();
		clearShit(enfleisch.previousElementSibling.previousElementSibling);}
	var uncool = [];
	function tscheckInput(drin){
	    val = drin.value;
	    if(!leutz.includes(val)){
	        if(!uncool.includes(drin)){
	            uncool.push(drin);}
	        drin.style.color = "red";}
	    else{
	        uncool = uncool.filter(e => e !== drin);
	        drin.style.color = "gray";}
	    if(typeof uncool != "undefined" && uncool != null && uncool.length != null && uncool.length > 0){
	        document.getElementById("sendn_butt").style.display = "none";
	        document.getElementById("nix_senden_ne").style.display = "inline";}
	    else{
	        document.getElementById("nix_senden_ne").style.display = "none";
	        document.getElementById("sendn_butt").style.display = "initial";}}
	function clearShit(eh){
	    if(uncool.includes(eh)){
	        uncool = uncool.filter(e => e !== eh);
	        document.getElementById("nix_senden_ne").style.display = "none";
	        document.getElementById("sendn_butt").style.display = "initial";}}
</script>
