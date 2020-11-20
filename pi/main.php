<!DOCTYPE html>
<html lang="en">
<head>
    <link rel = "stylesheet" href = "style.css" type = "text/css">
    <meta charset="UTF-8">
    <title>Pi</title>
</head>
<body>
<p>Diese Website scannt die ersten 1.000.000 Nachkommastellen von Pi.</p>
<form action="main.php" method="POST">
    <table><tr>
            <td>
               Anzahl der Bereiche
            </td>
            <td>
               Größe der Bereiche
            </td>
            <td>
              Darstellungsbreite
            </td>
            <td>
                Textoutput
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <input type="number" name="loops" placeholder="anzahl" value="10">
            </td>
            <td>
                <input type="number" name="jumps" placeholder="groeße" value="1000">
            </td>
            <td>
                <input type="number" name="dicke" placeholder="column size" value="10">
            </td>
            <td>
                <center>
                <input type="checkbox" name="textoutput">
                </center>
            </td>
            <td>
                <input type="submit" value="Scan">
            </td>
        </tr>
    </table>
</form>
<?php
    main($_POST['loops'],$_POST['jumps']);
$pall = array();
function main($loops,$jumps){
    for($ii = 1;$ii < $loops+1; $ii++) {


        $alldigit = file_get_contents("pi.txt", FALSE, NULL, 0, $ii*$jumps);
        if($_POST['textoutput'] == true) {
            echo "digits:" . strlen($alldigit) . "<br><br>";
        }


        $filter = array("1504","3008","2706","0810","2207");
        //filter($filter,$alldigit);

        $einer = array();
        $peiner = array();


        for ($i = 0; $i < 10; $i++) {
            $test = substr_count($alldigit, $i);
            $einer [$i] = $test;
        }


        foreach ($einer as $key => $zahl) {
            $prozente = round($zahl * 100 / array_sum($einer), 5);
            //$peiner [] = explode(".",$prozente)[1];
            $peiner [] = $prozente * 100;

            if($_POST['textoutput'] == true) {
                echo $key . " => " . $zahl . " => " . $prozente . "%<br>";
            }
        }
        if($_POST['textoutput'] == true) { echo "<br>";}
        $pall [] = $peiner;
        //zehner($einer,$alldigit);
    }
    //var_dump($pall);
    echo "<script>var pall = ".json_encode($pall).";console.log(pall);</script>";


}

function filter($filter,$alldigit){
    foreach ($filter as $zahl){
        $test = substr_count($alldigit, $zahl);
        echo $zahl." => ".$test . "<br>";
    }
    echo "<br>";
}

function zehner($einer,$alldigit){
    $zahlen = array();
    $zehner = array();

    for($j = 1; $j < 10; $j++){
        $zahlen = [];
        for($i = 0;$i < 10 ; $i++){
            $test = substr_count($alldigit,$j.$i);
            $zahlen [$j.$i] = $test;
        }
        $zehner [$j] = $zahlen;
    }

    foreach ($zehner as $key => $zahlen) {
        echo $key . "x => " . array_sum($zahlen) . " Prozente von einer => " . round(array_sum($zahlen) / $einer[$key], 5) . "%<br>";
        foreach ($zahlen as $key => $zahl) {
            $prozente = round($zahl * 100 / array_sum($zahlen), 5);
            echo $key . " => " . $zahl . " => " . $prozente . "%<br>";
        }
        echo "<br>";
    }
}
?>
<p>Die rote Linie ist 1/10 also der Prozentuale anteil welcher theoretisch von jeder Ziffer vorhanden sein sollte.</p>
<p><?php echo $_POST['loops'];?> bereiche a <?php echo $_POST['jumps'];?> Ziffern durchsucht.</p>
<canvas id="myCanvas" width="1000" height="200" style="border:1px solid #d3d3d3;">
    Your browser does not support the HTML5 canvas tag.</canvas>
<p>Alles über lila ist >11%</p>
<p>Alles unter gelb ist <9% </p>
<script>
    var c = document.getElementById("myCanvas");
    let dicke = <?php echo $_POST['dicke'];?>;
    c.width = pall.length * (pall[0].length * dicke + dicke);
    var ctx = c.getContext("2d");
    ctx.fillStyle = "#FF0000";
    ctx.fillRect(0, c.height/2-1, c.width, 2);

    for(var i = 0; i< pall.length;i++){
        for (var j = 0; j < pall[i].length;j++){
            ctx.fillStyle = "#000000";
            ctx.font = "10px Arial";
            ctx.fillText(j,j*dicke+(i*dicke*10+i*dicke),c.height/2-50);
            ctx.fillRect(j*dicke+(i*dicke*10+i*dicke), c.height, dicke, -1*Math.round(pall[i][j])+900);
        }
    }
    ctx.fillStyle = "#ffc800";
    ctx.fillRect(0, c.height-2, c.width, 2);
    ctx.fillStyle = "#da00ff";
    ctx.fillRect(0, 0, c.width, 2);
</script>
</body>
</html>