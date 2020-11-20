<?php
class Button {
    public $_id;
    public $_classes;
    public $_trigger;
    public $_function;
    public $_innerText;

    public function __construct( $id,$classes, $trigger, $function,$innerText )
    {
        $this->_id = $id;
        $this->_classes = $classes;
        $this->_trigger = $trigger;
        $this->_function = $function;
        $this->_innerText = $innerText;
    }

    public function getId()
    {
        return "id=".$this->_id;
    }
    public function getClasses()
    {
        $classes= 'class="'.implode(" , ",$this->_classes).'"';
        return $classes;
    }
    public function getTrigger()
    {
        return $this->_trigger."=".$this->getFunction();
    }
    public function getFunction()
    {
        return $this->_function;
    }

    public function getinnerText()
    {
        return $this->_innerText;
    }

    public function getButton(){
        echo "<button ".$this->getId()." ".$this->getClasses()." ".$this->getTrigger().">".$this->getinnerText()."</button>";
    }
}


?>