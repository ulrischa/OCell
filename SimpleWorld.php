<?php
include_once 'World.php';
include_once 'Cell.php';
include_once 'SimpleCell.php';
include_once 'GifCreator.php';
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
    
    private $last_row = '1';
    
    function __construct($lifetime) {
        parent::__construct($lifetime);
        $this->big_bang();
        $this->run_the_world();
    }

    public function big_bang() {
        //Zellen bilden und NAchbarschaft aufbauen
       $this->populate_world();
       //Zufällig zwei auf expand setzen
       $rand_expand = array_rand($this->getAll_cells(), 2);
       $this->getAll_cells()[$rand_expand[0]]->setState(SimpleCell::getStates()['expand']);
       $this->getAll_cells()[$rand_expand[1]]->setState(SimpleCell::getStates()['expand']);
       echo 'Start bei '.$this->getAll_cells()[$rand_expand[0]]->getId(). ' und '.$this->getAll_cells()[$rand_expand[1]]->getId();
       
    }

    public function populate_world() {
        $c11 = new SimpleCell('1,1',  'free');
        $c12 = new SimpleCell('1,2',  'free');
        $c13 = new SimpleCell('1,3',  'free');
        $c21 = new SimpleCell('2,1',  'free');
        $c22 = new SimpleCell('2,2',  'free');
        $c23 = new SimpleCell('2,3', 'free');
        $c31 = new SimpleCell('3,1',  'free');
        $c32 = new SimpleCell('3,2',  'free');
        $c33 = new SimpleCell('3,3',  'free');
        // 11 12 13
        // 21 22 23
        // 31 32 33
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

    public function what_happens_now_in_cell(Cell $c) {
//         if ($c->getState() == SimpleCell::getStates()['new']){
//            $c->setState(SimpleCell::getStates()['expand']);
//         }   
        //$c->notify();
    }

    public function display_now($i) {
        echo '<br />Jetzt: '.$i.'<br />';  
        $this->output_now_to_gif(10);
        foreach ($this->getAll_cells() as $c) {
            $row = $c->getRow();
                  
            if ($this->last_row != $row){
                       echo '<br />';
            }
            $color = 'white';
            if ($c->getState() == SimpleCell::getStates()['new']) $color = 'green';
            elseif ($c->getState() == SimpleCell::getStates()['expand']) $color = 'red';
            echo ' <span style="color:'.$color.'; display:inline-block; background-color:'.$color.'; width:10px; height:10px;border:1px solid black;">&nbsp;'.'</span>';
            $this->last_row = $row;
        }

    }
    
    public function getNumRows(){
        $num_rows = 0;
        foreach ($this->getAll_cells() as $c){
            if ($c->getRow() > $num_rows) $num_rows = $c->getRow();
        }
        return $num_rows;
    }
    
    public function getNumCols(){
        $num_cols = 0;
        foreach ($this->getAll_cells() as $c){
            if ($c->getCol() > $num_cols) $num_cols = $c->getCol();
        }
        return $num_cols;
    }
    
    public function output_now_to_gif($size)
    {
            $width = $this->getNumCols()*$size;
            $height = $this->getNumRows()*$size;

            $img = imagecreate($width, $height);
            imagefill($img, 0, 0, imagecolorallocate($img, 0, 0, 0));

            


            foreach ($this->getAll_cells() as $c) {
                $onColour = imagecolorallocate($img, 0, 255, 0);
                   $i_c= intval($c->getCol());
                   $x1 = ($i_c-1)*$size;
                   $x2 = $x1+$size;
                 
                   $i_r = intval($c->getRow());
                   $y1 = ($i_r-1)*$size;
                   $y2 = $y1+$size;
                   
                   if ($c->getState() == SimpleCell::getStates()['new']){
                       imagefilledrectangle($img, $x1, $y1, $x2, $y2, $onColour);
                   }
                   elseif ($c->getState() == SimpleCell::getStates()['expand']) {
                       $onColour = imagecolorallocate($img, 255, 0, 0);
                       imagefilledrectangle($img, $x1, $y1, $x2, $y2, $onColour);
                       
                   }
                   

             }
            $filename = $this->now;

            imagegif($img, "{$filename}.gif");
            imagedestroy($img);
    }
    
    public function anmimatedgif($pause){
        $frames = array();
        $durations = array();
        for ($i=0; $i<$this->lifetime; $i++){
            $frames[] = $i.'.gif';
            $durations[] = $pause;
        }
        // Initialize and create the GIF !
        $gc = new GifCreator\GifCreator();
        $gc->create($frames, $durations, 1);
        $gifBinary = $gc->getGif();        
        file_put_contents('./animated_picture.gif', $gifBinary);  
    }

}
