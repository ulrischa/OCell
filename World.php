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
    protected $now = 0;
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
    abstract public function what_happens_now_in_cell(Cell $c);
    abstract public function display_now($now);
    
    public function run_the_world(){
        for ($i = 0; $i < $this->lifetime; $i++){
            $this->now = $i;
            echo '<br />Vorher:<br />';
            $this->display_now($this->now);
            foreach ($this->getAll_cells() as $c) {
               $c->notify();
            }
            echo '<br />Nachher:<br />';
            $this->display_now($this->now);
            echo '<hr />';
       }
    }
}
