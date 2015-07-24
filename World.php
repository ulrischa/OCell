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
    

    function getLifetime() {
        return $this->lifetime;
    }
    
    function setLifetime($lifetime) {
        $this->lifetime = $lifetime;
    }
    
    function getAll_cells() {
        return $this->all_cells;
    }

    function setAll_cells($all_cells) {
        $this->all_cells = $all_cells;
    }
    function getNow() {
        return $this->now;
    }

    abstract public function populate_world();
    abstract public function big_bang();
    abstract public function display_now($now);
    abstract public function what_happens_now($now);
    public function increment_now() {
        $this->now++;
    }
    
    
    public function run_the_world(){
         for ($i = 0; $i < $this->getLifetime(); $i++){
             $this->what_happens_now($this->now);
        }
     }
    
    
}
