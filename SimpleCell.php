<?php

/*
 * Zelle kann Zustand new, expand, free haben.
 * Wenn Zustand auf Expand gesetzt, breitet sich die Zelle (auf alle freien Nachbarn) aus und setzt sich selbst auf free
 * 
 * 
 */

/**
 * Description of Cell
 *
 * @author schaefflers
 */

class SimpleCell extends Cell {
    
       
    public function update(\SplSubject $calling_cell) {
       echo '<br />Zelle '.$calling_cell->getId().' benachrichtigt Zelle: '.$this->getId().'<br />';
        //Nur Update wenn Zelle sich nicht selbst benachrichtigt hat
        if ($calling_cell instanceof Cell){
             $this->detach($calling_cell);
            //Wenn man Überprüfung bei Notify machen will: if ($calling_cell->getId() !== $this->getId()){
            //Wenn die anrufende Zelle nicht gleich der eigenen und auf expand
            if ($calling_cell->getId() !== $this->getId() && $calling_cell->getState() == SimpleCell::getStates()['expand']){
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
    
    public static function getStates() {
        return array('new' => 'new', 'expand' => 'expand', 'free' =>'free');
    }

        
    public function getRow() {
         return  explode(",", $this->getId())[0];
    }
    
    public function getCol() {
         return  explode(",", $this->getId())[1];
    }

    //Hier wird gleich die Benachrichtigung der Nachbarn bei Statusänderung ausgewführt
    public function setState($state) {
       if (in_array($state, static::getStates())) {
             $this->state = $state;
             echo '#####STATUS: '.$this->getId().' auf '.$this->getState().'<br />';
             $this->world->display_now($this->world->getNow());
             $this->world->increment_now($this->world->getNow());
             $this->notify();
        }
    }

}
