<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of World
 *
 * @author schaefflers
 */
abstract class World {
    protected $lifetime;
    private $all_cells;
    
    function __construct($lifetime) {
        $this->lifetime = $lifetime;
    }

    function getLifetime() {
        return $this->lifetime;
    }

    function getAll_cells() {
        return $this->all_cells;
    }
    
    function setLifetime($lifetime) {
        $this->lifetime = $lifetime;
    }

    function setAll_cells($all_cells) {
        $this->all_cells = $all_cells;
    }

    
        
    abstract public function populate_world();
    abstract public function big_bang();
    abstract public function what_happens_now(Cell $c);
    abstract public function display_now(Cell $c);
    abstract public function display_time_separator($i);
    
    public function run_the_world(){
        for ($i = 0; $i < $this->lifetime; $i++){
            foreach ($this->getAll_cells() as $c) {
                $this->display_now($c);
                $this->what_happens_now($c);
             }
             $this->display_time_separator($i);
       }
    }
}
