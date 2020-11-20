
<!DOCTYPE html>
<html>
<head>
    <title>Categorize your Cards</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
    textarea{
        height: 500px;
    }
    input{
        width:4em;
    }
    th{
        font-size: 20px;
    }

    .uppercase{
        text-transform:uppercase;
    }
    .nummern{
        border-collapse: separate;
        border-spacing: 10px 10px;
        width: auto;
    }
    .nummer{
        width: 2em;
        border: 2px black solid;
        padding: 17px;
    }
    .card{
        width: 2em;
        border: 2px black solid;
    }
    .button{
        width: auto;
        border: 2px black solid;
    }
    .liste{
        border: 2px black solid;
        width: auto;
    }
    .left{
        width: 70%;
        float: left;
    }
    .right{
        width: 30%;
        float: right;
    }
    #error{
        font-size: 30px;
        color: red;
    }
</style>
<body>
<center>
    <h1>Kartenliste editor</h1>
    <span id="error"></span><br>
    <span>Anzahl der Karten im Set:
        <input type="number" id="set_amount" oninput="draw_nummern()" value="100">
    </span><br><br>
    <span>Prefix(meistens 0 manchmal buchstaben) der Nummer: <input type="text" id="prefix" maxlength="1" value="0" oninput="draw_nummern()"></span><br><br>
    <span>Um den prefix und die Anzahl der ausgewählten sets zu überprüfen <a target="_blank" id="cardluster_link" href="https://cardcluster.com/search/mago">klick hier</a></span><br><br>
    <table>
        <tr>
            <th>Setname</th>
            <th></th>
            <th>Sprache</th>
            <th>Nummer</th>
        </tr>
        <tr>
            <td>
                <input class="uppercase" type="text" id="set_name" list="setnames" maxlength="4" value="MAGO" oninput="setlink(this)" onfocus="this.value=''" >
                <datalist id="setnames"></datalist>
            </td>
            <td>
                -
            </td>
            <td>
                <input class="uppercase" type="text" id="set_lang" maxlength="2" value="DE">
            </td>
            <td>
                <input  type="number" id="set_nummer" maxlength="3">
            </td>
            <td>
                <button id="add_button" onclick="add_card()">ADD</button>
            </td>
        </tr>
    </table>

    <div class = "left">
        <h2>Nummern</h2>
        <h2>Anklicken um hinzuzufÃ¼gen</h2>
        <table class="nummern" id="nummerliste"></table>
    </div>
    <div class = "right">
        <h2 class = "button" onclick="download()">Download liste</h2>
        <h2>Liste</h2>
        <table class="liste"  id="kartenliste"></table>
    </div>
</center>
</body>

<script>
    let cards = [];
    var setnames = [];

    function add_nummer(elemt){
        if(document.getElementById("set_name").value.toString().length >= 3 && document.getElementById("set_lang").value.toString().length == 2){
            document.getElementById("set_nummer").value = elemt.innerText;
            document.getElementById("add_button").click();
        }else{
            document.getElementById("error").innerText = "Bitte gebe einen Setnamen und eine Sprache ein (DE,EN)";
        }
    }
    function add_card(){
        let name = document.getElementById("set_name").value.toUpperCase();
        let lang = document.getElementById("set_lang").value.toUpperCase();
        let nummer = document.getElementById("set_nummer").value;
        let id = name+"-"+lang+nummer;
        if(cards.length == 0){
            cards.push(id);
        }else{
            for (var i = 0; i < cards.length; i++) {
                if(cards[i] == id){
                    break;
                }
                if(i == cards.length-1 && cards[i] != id){
                    cards.push(id);
                }
            }
        }
        update_cardlist();
    }
    function remove_card(elemt){
        let id = elemt.id;
        console.log(id);
        for (var i = 0; i < cards.length; i++) {
            if(cards[i] == id){
                cards.splice(i,1);
            }
        }
        update_cardlist();
    }
    function update_cardlist(){
        let kartenliste = document.getElementById("kartenliste");
        kartenliste.innerHTML = "";

        for (var i = 0; i < cards.length; i++) {
            let trn = document.createElement("tr");

            kartenliste.appendChild(trn);
            //td mit card id
            let tdn = document.createElement("td");
            tdn.classList.add("card");
            tdn.innerText = cards[i];
            trn.appendChild(tdn);
            //button
            tdn = document.createElement("td");
            tdn.classList.add("button");
            tdn.setAttribute("onclick", "remove_card(this)");
            tdn.id = cards[i];
            tdn.innerText = "Remove";
            trn.appendChild(tdn);
        }
    }
    function draw_nummern() {
        let elemt = document.getElementById("set_amount");
        document.getElementById('nummerliste').innerHTML = "";
        if(elemt.value > 300){
            elemt.value = 300;
        }
        let amount = elemt.value;


        for (var i = 0; i < Math.floor(amount/10); i++) {
            let trn = document.createElement("tr");
            document.getElementById('nummerliste').appendChild(trn);
            //nummmern
            for(var j = 0; j < 10; j++){
                let tdn = document.createElement("td");
                tdn.classList.add("nummer");
                tdn.setAttribute("onclick", "add_nummer(this)");
                tdn.innerText = refactor_nummer(j+1+i*10);
                trn.appendChild(tdn);
            }

            trn = document.createElement("tr");
            document.getElementById('nummerliste').appendChild(trn);
            //trennlonie
            for(var j = 0; j < 10; j++){
                let tdn = document.createElement("td");

                trn.appendChild(tdn);
            }
        }


        let trn = document.createElement("tr");
        document.getElementById('nummerliste').appendChild(trn);
        for(var j = 0; j < amount % 10; j++){
            let tdn = document.createElement("td");
            tdn.classList.add("nummer");
            tdn.setAttribute("onclick", "add_nummer(this)");
            tdn.innerText = refactor_nummer(j+1+(Math.floor(amount/10)*10));
            trn.appendChild(tdn);
        }

    }

    function refactor_nummer(nummer){
        let input = nummer.toString();
        let output = input;
        let prefix = document.getElementById("prefix").value;
        if(input.length == 1){
            output = prefix+"0"+input;
        }
        if(input.length == 2){
            output = prefix+input;
        }
        return output;
    }

    function getTime() {
        let d = new Date();
        let n = d.getHours();
        let m = d.getMinutes();
        let s = d.getSeconds();
        let output = n + ":"+m +":"+s;
        return output;
    }

    function download(){
        let name = document.getElementById("set_name").value.toUpperCase();
        var a = document.createElement('a');
        var file = new Blob([ cards.join('|') ], { type: 'text/plain' });

        a.href = URL.createObjectURL(file);
        a.download = name+"_"+getTime()+".txt";
        a.click();
    }

    function getSetnames(setnamestext){
        setnames = setnamestext.split("|");
        console.log(setnames);
        let datalist = document.getElementById("setnames");
        for (var i = 0; i < setnames.length; i++) {
            let option = document.createElement("option");
            option.value = setnames[i];
            option.setAttribute("onclick", "test(this)");
            datalist.appendChild(option);
        }
    }

    function setlink(elemt){
        document.getElementById("cardluster_link").href = "https://cardcluster.com/search/"+elemt.value;
    }

    function test(elemt){
        console.log(elemt.value);
    }

    document.getElementById("set_amount").value = 100;
    //website beginn
    draw_nummern();
</script>

<?php
$text = file_get_contents("yugioh_setnames.txt");
echo "<script>getSetnames(".json_encode($text).");</script>";
?>

</html>