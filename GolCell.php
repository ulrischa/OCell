<?php

/*
 * Umsetzung GOL.
 * 
 * http://www.mathematische-basteleien.de/gameoflife.htm
 * 
 * 
 */

/**
 * Description of Cell
 *
 * @author schaefflers
 */

class GolCell extends Cell {
    
       
 
    public $last_state;

    public function update(\SplSubject $calling_cell) {
       echo '<br />ZElle '.$calling_cell->getId().' benachrichtigt Zelle: '.$this->getId().'<br />';
        //Nur Update wenn Zelle sich nicht selbst benachrichtigt hat
        if ($calling_cell instanceof Cell){
            $neighbours = $this->getArr_neighbours;
            $alive_neighbours = 0;
            $dead_neighbours = 0;
            foreach ($neighbours as $n){
                if ($n->getState == GolCell::getStates()['alive']){
                    $alive_neighbours++;
                }
                elseif ($n->getState == GolCell::getStates()['dead']) {
                     $dead_neighbours++;
                }
            }
            if ($this->getState() == GolCell::getStates()['alive']){
                if ($alive_neighbours != 2 && $alive_neighbours != 3){
                    $this->setState (GolCell::getStates ()['dead']); 
                }
                   
            }
            elseif ($this->getState() == GolCell::getStates()['free']) {
                if ($alive_neighbours == 3){
                     $this->setState (GolCell::getStates ()['alive']); 
                }
            }
            else {
                 $this->setState (GolCell::getStates ()['free']); 
            }
            
        }             
    }
    
    public static function getStates() {
        return array('alive' => 'alive', 'dead' => 'dead', 'free' => 'free');
    }

        
    public function getRow() {
         return  explode(",", $this->getId())[0];
    }
    
    public function getCol() {
         return  explode(",", $this->getId())[1];
    }


}
