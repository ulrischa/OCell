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
    protected $all_cells;
    
    abstract public function populate_world();
    abstract public function build_neighbourhood();
    abstract public function what_happens();
    
    public function run_the_world(){
               for ($i = 0; $i<$rounds; $i++){
            echo "<br />Runde ".$i.' <br />';
             $last_row = '1';
            foreach ($all_cells as $c) {
                //Ausgabe des Zustandes
                 $row = $c->getRow();
                 if ($last_row != $row){
                    echo '<br />';
                 }
                 $color = 'white';
                 if ($c->getState() == SimpleCell::getStates()['new']) $color = 'green';

                 echo ' <span style="color:'.$color.'; display:inline-block; background-color:'.$color.'; width:10px; height:10px;border:1px solid black;">&nbsp;'.'</span>';
                 //Alle neuen auf expand setzen
                  //echo $c->getState();
                 if ($c->getState() == SimpleCell::getStates()['new']){

                     $c->setState(SimpleCell::getStates()['expand']);
                 }

                 $last_row = $row;
             }
              echo "<br />Runde ".$i.' zuende <br /><br />';
       }
    }
}
