<?php

class Table {
    public $_id;
    public $_head;
    public $_classes;
    public $_rows;
    public $_columns;

    public function __construct( )
    {
    }

    public function createTable($id,$classes, $rows, $columns, $head )
    {
        $this->_id = $id;
        $this->_classes = $classes;
        $this->_rows = $rows;
        $this->_columns = $columns;
        $this->_head = $head;


        $this->renderTable();
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getClasses()
    {
        $classes= 'class="'.implode(" , ",$this->_classes).'"';
        return $classes;
    }
    public function getBody()
    {
        $output = "";
        if($this->_head === true){
            $output.="<tr>";
                for ($i = 0; $i < $this->_columns; $i++) {
                    $output .= "<th></th>";
                }
            $output.="</tr>";
        }
        for($j = 0; $j < $this->_rows;$j++) {
            $output .= "<tr>";
            for ($i = 0; $i < $this->_columns; $i++) {
                $output .= "<td><input type='text'></td>";
            }
            $output.="</tr>";
        }
        return $output;
    }

    public function renderTable(){
        echo "<table id=".$this->getId()." ".$this->getClasses().">".$this->getBody()."</table>";
        $button = new Button("butten-export",[],"onclick","export_table('".$this->getId()."')","Export Table");
        echo $button->getButton();
    }

    public function createTableFromFile($id,$data,$head)
    {
        $this->_id = $id;
        $tbody = "";
        foreach ($data as $key => $row){
            $tbody .= "<tr>";
            if($head === true && $key == reset($row)){
                foreach ($row as $column){
                    $tbody .= "<th>".$column."</th>";
                }
            }else{
                foreach ($row as $column){
                    $tbody .= "<td>".$column."</td>";
                }
            }
            $tbody .= "</tr>";


        }
        echo "<table>".$tbody."</table>";
    }
}


?>