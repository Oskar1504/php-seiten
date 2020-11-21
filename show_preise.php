
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
    <h1>Preise anzeigen</h1>

    <input type='file' accept='text/plain' id="fileinput" onchange="openFile(event)"><br>
    <div id="content"></div>
</center>
</body>

<script>
    var cards = [];
    var openFile = function(event) {
        console.log(event);
        var input = event.target;
        cards = [];
        var reader = new FileReader();
        reader.onload = function(){
            let text = reader.result;
            let nice_text =text;
            let cards1 = nice_text.split('\n');

            for(var i = 0; i < cards1.length; i++){
                cards.push(cards1[i].split(','));
            }
            console.log(cards);
            renderCards();
        };

        reader.readAsText(input.files[0]);
    };

    function  renderCards(){
        let elemt = document.getElementById("content");
        let innerhtmlstring = "<table>";
        let val = 0;
        if(cards.length-5 >= 0){
            val = cards.length-5;
        }else{
            val = 0;
        }
        for(var i = val; i < cards.length;i++){
            innerhtmlstring += "<tr>";
            for(var j = 0; j < cards[i].length;j++){
                innerhtmlstring += "<td onclick='deleteItem("+i+","+j+")'>";
                innerhtmlstring += cards[i][j];
                innerhtmlstring += "</td>";
            }
            innerhtmlstring += "</tr>";
        }
        innerhtmlstring += "</table>";
        elemt.innerHTML = innerhtmlstring;
    }

</script>

</html>