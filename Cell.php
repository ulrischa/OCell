<?php

/*
 * Zelle kann Zustand new, exxpand, free haben.
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
abstract class Cell implements SplObserver, SplSubject {
    protected $id;
    protected $arr_neighbours;
    protected $state;
    
    
            
    function __construct($id, $initial_state) {
        $this->id = $id;
        $this->state = $initial_state;
    }
    public function attach(\SplObserver $cell) {
        $i = array_search($cell,  $this->arr_neighbours);
        if ($i === false) {
             $this->arr_neighbours[] = $cell;
        }
    }
    

    public function detach(\SplObserver $cell) {
         if (!empty($this->arr_neighbours)) {
            $i = array_search($cell, $this->arr_neighbours);
            if ($i !== false) {
                unset($this->arr_neighbours[$i]);
            }
        }
    }
    
     
    public function getId() {
        return $this->id;
    }
    
     public function getArr_neighbours() {
        return $this->arr_neighbours;
    }

    public function getState() {
        return $this->state;
    }

    public function setArr_neighbours($arr_neighbours) {
        $this->arr_neighbours = $arr_neighbours;
    }
    
    public function setState($state) {
       if (in_array($state, static::getStates())) {
             $this->state = $state;
             $this->notify();
        }
    }
    
    abstract public function update(\SplSubject $calling_cell);

    abstract public function notify();

    abstract  static public function getStates();

}
