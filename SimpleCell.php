<?php

/*
 * Zelle kann Zustand new, expand, free haben.
 * Wenn Zustand auf Expand gesetzt, breitet sich die Zelle (auf alle freien Nachbarn) aus und setzt sich selbst auf free
 * 
 * 
 * http://www.sitepoint.com/understanding-the-observer-pattern/
 */

/**
 * Description of Cell
 *
 * @author schaefflers
 */

class SimpleCell extends Cell {
    
       
//    protected static $num_of_childs = 2;
//    
//
//    static function getNum_of_childs() {
//        return self::$num_of_childs;
//    }
//
//    static function setNum_of_childs($num_of_childs) {
//        self::$num_of_childs = $num_of_childs;
//    }
    
    public $last_state;

    public function update(\SplSubject $calling_cell) {
       echo '<br />ZElle '.$calling_cell->getId().' benachrichtigt Zelle: '.$this->getId().'<br />';
        //Nur Update wenn Zelle sich nicht selbst benachrichtigt hat
        if ($calling_cell instanceof Cell){
            //Wenn man Überprüfung bei Notify machen will: if ($calling_cell->getId() !== $this->getId()){
            //Wenn die anrufende Zelle nicht gleich der eigenen und auf expand
            if ($calling_cell->getId() !== $this->getId() && $calling_cell->getState() == SimpleCell::getStates()['expand']){
                $this->last_state = $this->getState();
                //Wenn die anrufende Zelle auf expand und diese frei; dann diese auf new 
                if ($this->getState() ==  SimpleCell::getStates()['free']){
                     $this->setState(SimpleCell::getStates()['new']);
                }
                //Wenn die anrufende Zelle auf expand und diese new; dann diese auf expand (Bedeutet Angriff) 
                elseif ($this->getState() == SimpleCell::getStates()['new']){
                    $this->setState(SimpleCell::getStates()['expand']);
                }
                //Wenn die anrufende Zelle auf expand und diese auf expand, dann auf free (Bedeutet Tod)
                elseif ($this->getState() == SimpleCell::getStates()['expand'] ){
                    $this->setState(SimpleCell::getStates()['free']);
                }
               
            }
            
        }             
    }
    
    //Kann so überschrieben werden um nicht alle zu benachrichtigen, sondern nur wenn es was gibt, also bei expand
//    public function notify() {
//            if (!empty($this->arr_neighbours) && $this->getState() == SimpleCell::getStates()['expand']) {
//                foreach ($this->arr_neighbours as $n){
//                    $n->update($this);
//                }
//            }
//    }


    
    public static function getStates() {
        return array('new' => 'new', 'expand' => 'expand', 'free' =>'free');
    }

        
    public function getRow() {
         return  explode(",", $this->getId())[0];
    }
    
    public function getCol() {
         return  explode(",", $this->getId())[1];
    }


}
