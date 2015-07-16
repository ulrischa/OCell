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
    
    const STATE_NEW = 'new';
    const STATE_EXPAND = 'expand';
    const STATE_FREE = 'free';
    
    protected $id;
    protected $arr_neighbours;
    protected $state;
    protected static $num_of_childs = 2;
    

    static function getNum_of_childs() {
        return self::$num_of_childs;
    }

    static function setNum_of_childs($num_of_childs) {
        self::$num_of_childs = $num_of_childs;
    }

    public function update(\SplSubject $calling_cell) {
        //Nur Update wenn Zelle sich nicht selbst benachrichtigt hat
        if (($calling_cell->getId() !== $this->getId()) && $this->getState() == SimpleCell::STATE_FREE){
            $this->setState(SimpleCell::STATE_NEW);
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
    

    public function setState($state) {
        if ($state == SimpleCell::STATE_EXPAND || $state == SimpleCell::STATE_FREE || $state == SimpleCell::STATE_NEW){
             $this->state = $state;
            // Wenn Zustandsänderung Nachbarn benachrichtigen
            //Wenn Status Ausbreiten dann Nachbarn updaten
            if ($this->getState() == SimpleCell::STATE_EXPAND){
                $this->notify();
                $this->state = SimpleCell::STATE_FREE;
            }  
            //echo $this->getId()." State changed to: ".$this->getState().'<br />';
      
        }
    }
    
    public function getRow() {
         return  substr($this->getId(), 0, 1);
    }


}
