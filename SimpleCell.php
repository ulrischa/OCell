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
    
       
    protected static $num_of_childs = 2;
    

    static function getNum_of_childs() {
        return self::$num_of_childs;
    }

    static function setNum_of_childs($num_of_childs) {
        self::$num_of_childs = $num_of_childs;
    }

    public function update(\SplSubject $calling_cell) {
        //Nur Update wenn Zelle sich nicht selbst benachrichtigt hat
        if ($calling_cell instanceof Cell){
            if ($calling_cell->getId() !== $this->getId()){
                if ($this->getState() ==  SimpleCell::getStates()['free']){
                    $this->setState(SimpleCell::getStates()['new']);
                }
                elseif ($this->getState() == SimpleCell::getStates()['expand']){
                    $this->setState(SimpleCell::getStates()['free']);
                }

            } 
        }
       
                    
    }

    public function notify() {
            if (!empty($this->arr_neighbours)) {
                $rand_new = array_rand($this->arr_neighbours, SimpleCell::$num_of_childs);
                foreach ($rand_new as $rand_idx) {
                    //Nachbarzelle aktualisieren mit Info aus dieser Zelle
                    $this->getArr_neighbours()[$rand_idx]->update($this);
                }
            }
    }

    
    public static function getStates() {
        return array('new' => 'new', 'expand' => 'expand', 'free' =>'free');
    }

        
    public function getRow() {
         return  substr($this->getId(), 0, 1);
    }


}
