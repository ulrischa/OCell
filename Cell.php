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
abstract class Cell implements SplObserver, SplSubject {
    protected $id;
    protected $arr_neighbours;
    protected $state;
    protected $next_state;
    protected $world;
                            
    function __construct($id, $initial_state, $world) {
        $this->id = $id;
        $this->state = $initial_state;
        $this->next_state = $initial_state;
        $this->world = $world;
    }
    public function attach(\SplObserver $cell) {
           if ($cell instanceof Cell){
                $i = array_search($cell,  $this->arr_neighbours);
                if ($i === false) {
                     $this->arr_neighbours[] = $cell;
                }
           }
    }
    

    public function detach(\SplObserver $cell) {
           if ($cell instanceof Cell){
               if (!empty($this->arr_neighbours)) {
                    $i = array_search($cell, $this->arr_neighbours);
                    if ($i !== false) {
                        unset($this->arr_neighbours[$i]);
                    }
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
    
    abstract public function  setState($state);

    abstract public function update(\SplSubject $calling_cell);

    public function notify() {
            if (!empty($this->arr_neighbours)) {
                foreach ($this->arr_neighbours as $n){
                    $n->update($this);
                }
            }
    }

    abstract  static public function getStates();
    
    public function getWorld() {
        return $this->world;
    }

    public function setWorld($world) {
        $this->world = $world;
    }

    public function getNext_state() {
        return $this->next_state;
    }

    public function setNext_state($next_state) {
         if (in_array($next_state, static::getStates())) {
            $this->next_state = $next_state;
         }
    }



}
