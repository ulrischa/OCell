<?php
include_once 'World.php';
include_once 'Cell.php';
include_once 'SimpleCell.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpleWorld
 *
 * @author schaefflers
 */
class SimpleWorld extends World {
    
    private $last_row = 1;
    
    function __construct($lifetime) {
        parent::__construct($lifetime);
    }

    public function big_bang() {
       $this->populate_world();
       $rand_expand = array_rand($this->getAll_cells(), 2);
       $this->getAll_cells()[$rand_expand[0]]->setState(SimpleCell::getStates()['expand']);
       $this->getAll_cells()[$rand_expand[1]]->setState(SimpleCell::getStates()['expand']);
    }

    public function display_now(Cell $c) {
         $row = $c->getRow();
         if ($this->last_row != $row){
                    echo '<br />';
         }
         $color = 'white';
         if ($c->getState() == SimpleCell::getStates()['new']) $color = 'green';
         echo ' <span style="color:'.$color.'; display:inline-block; background-color:'.$color.'; width:10px; height:10px;border:1px solid black;">&nbsp;'.'</span>';
    
         $this->last_row = $row;
    }

    public function populate_world() {
        $c11 = new SimpleCell(11,  'free');
        $c12 = new SimpleCell(12,  'free');
        $c13 = new SimpleCell(13,  'free');
        $c21 = new SimpleCell(21,  'free');
        $c22 = new SimpleCell(22,  'free');
        $c23 = new SimpleCell(23, 'free');
        $c31 = new SimpleCell(31,  'free');
        $c32 = new SimpleCell(32,  'free');
        $c33 = new SimpleCell(33,  'free');
        
        $c11->setArr_neighbours(array($c12, $c21, $c22));
        $c12->setArr_neighbours(array($c11, $c13, $c21, $c22, $c23));
        $c13->setArr_neighbours(array($c12, $c22, $c23));
        $c21->setArr_neighbours(array($c11, $c12, $c22, $c32, $c31));
        $c22->setArr_neighbours(array($c11, $c12, $c13, $c21, $c23, $c31, $c32, $c33));
        $c23->setArr_neighbours(array($c12, $c13, $c22, $c32, $c33));
        $c31->setArr_neighbours(array($c21, $c22, $c32));
        $c32->setArr_neighbours(array($c31, $c21, $c22, $c23, $c33)); 
        $c33->setArr_neighbours(array($c32, $c22, $c23)); 
        
        $this->setAll_cells(array($c11,
                            $c12,
                            $c13,
                            $c21,
                            $c22,
                            $c23,
                            $c31,
                            $c32,
                            $c33
                            ));
        
    }

    public function what_happens_now(Cell $c) {
         if ($c->getState() == SimpleCell::getStates()['new']){
            $c->setState(SimpleCell::getStates()['expand']);
         }   
    }

    public function display_time_separator($i) {
        echo '<br />Ende '.$i.'<br />';
        
    }

}
