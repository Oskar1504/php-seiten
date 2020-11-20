<?php
    require "jsclasses/Button.php";
    require "jsclasses/Table.php";
    require "adapter/csv.php";
    require "adapter/oskar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>

<style>
    .swag{
        background-color: red;
    }
    .button{
        color: greenyellow;
    }
    table,td{
        margin:5px;
        border:3px solid black;
        border-collapse:separate;
        border-spacing:4px;
        text-align:center;
        word-wrap: break-word;
    }
    td{
        width: auto;
        height: 20px;
    }

</style>
<body>
<button class="swag , button">Von vorne rein</button>
<div>
    <?php

    $table = new Table();
    $table->createTable("test",["table","ehre"],5,7,false);
    $table->createTableFromFile("csv_table",CSV::readFile("test.csv"),true);
    $table->createTableFromFile("oskar_table",CSV::readFile("ygo_preise.csv"),false);

    ?>
</div>
<script>
    function test(i){
        console.log("Button pressed.\n"+i);
    }

    function export_table(id){
        let column  = [], row = [],data = [];
        let elemt = document.getElementById(id).childNodes[0];
        for(var i = 0; i < elemt.childNodes.length;i++){
            for (var j = 0; j < elemt.childNodes[i].children.length;j++){
                column.push(elemt.childNodes[i].children[j].children[0].value);
            }
            row.push(column);
            column = [];
        }
        data.push(row);
        console.log(data);
        //create_csv(data);

    }
</script>
</body>
</html>
