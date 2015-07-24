<?php
include_once 'World.php';
include_once 'Cell.php';
include_once 'GolCell.php';
include_once 'GifCreator.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GolWorld
 *
 * @author schaefflers
 */
class GolWorld extends World {
    
    private $last_row = '1';
    private $gif_output = false;
    private $size;
    private $num_seeds;
            
    function __construct($gif_output, $size, $num_seeds) {
        $this->gif_output = $gif_output;
        $this->size = $size;
        $this->num_seeds = $num_seeds;
        $this->big_bang();
    }

    public function big_bang() {
        //Zellen bilden und NAchbarschaft aufbauen
       $this->populate_world();
       //Zufällig zwei auf expand setzen
       $rand_expand = array_rand($this->getAll_cells(), $this->num_seeds);
       foreach ($rand_expand as $rand){
          echo 'Start bei '.$this->getAll_cells()[$rand]->getId().'<br />';
       } 
       echo '***<br />';
       foreach ($rand_expand as $rand){
           $this->getAll_cells()[$rand]->setState(GolCell::getStates()['alive']);
       } 
    }

    public function populate_world() {
        $size = $this->size;
        $all_cell = array();
        for ($s= 0; $s < $size*$size; $s++){
            $row = intval($s / $size);
            $col = ($s - ($row * $size));
            $row = $row + 1;
            $col = $col + 1;
            //echo 's: '. $s.' row: '.$row.' col: '.$col.'<br />';
            $all_cell[$row.','.$col] = new GolCell($row.','.$col,  GolCell::getStates()['free'], $this);
        }
        
//        $c11 = new GolCell('1,1',  GolCell::getStates()['free'], $this);
//        $c12 = new GolCell('1,2',  GolCell::getStates()['free'], $this);
//        $c13 = new GolCell('1,3',  GolCell::getStates()['free'], $this);
//        $c21 = new GolCell('2,1',  GolCell::getStates()['free'], $this);
//        $c22 = new GolCell('2,2',  GolCell::getStates()['free'], $this);
//        $c23 = new GolCell('2,3',  GolCell::getStates()['free'], $this);
//        $c31 = new GolCell('3,1',  GolCell::getStates()['free'], $this);
//        $c32 = new GolCell('3,2',  GolCell::getStates()['free'], $this);
//        $c33 = new GolCell('3,3',  GolCell::getStates()['free'], $this);
        // 11 12 13
        // 21 22 23
        // 31 32 33
        
        foreach ($all_cell as $c){
            $row = $c->getRow();
            $col = $c->getCol();
            //Alle möglichen Richtungen nach Moore
            $n = ($row-1).','.$col;
            $nw = ($row-1).','.($col-1);
            $no = ($row-1).','.($col+1);
            $w = $row.','.($col-1);
            $o = $row.','.($col+1);
            $s = ($row+1).','.$col;
            $sw = ($row+1).','.($col-1);
            $so = ($row+1).','.($col+1);        
            $arr_directions = array($n, $nw, $no, $w, $o, $s, $sw, $so);
            //Welche davon gibt es?
            $arr_existing_neighbours = array();
            foreach ($arr_directions as $d){
                if (array_key_exists($d, $all_cell)) {
                    $arr_existing_neighbours[] = $all_cell[$d];
                }
            }
            $c->setArr_neighbours($arr_existing_neighbours);        



        }
        
//        $c11->setArr_neighbours(array($c12, $c21, $c22));
//        $c12->setArr_neighbours(array($c11, $c13, $c21, $c22, $c23));
//        $c13->setArr_neighbours(array($c12, $c22, $c23));
//        $c21->setArr_neighbours(array($c11, $c12, $c22, $c32, $c31));
//        $c22->setArr_neighbours(array($c11, $c12, $c13, $c21, $c23, $c31, $c32, $c33));
//        $c23->setArr_neighbours(array($c12, $c13, $c22, $c32, $c33));
//        $c31->setArr_neighbours(array($c21, $c22, $c32));
//        $c32->setArr_neighbours(array($c31, $c21, $c22, $c23, $c33)); 
//        $c33->setArr_neighbours(array($c32, $c22, $c23)); 
        
        $this->setAll_cells($all_cell);
        
    }



    public function display_now() {
        if ($this->gif_output == true) $this->output_now_to_gif(10);

        foreach ($this->getAll_cells() as $c) {
            $row = $c->getRow();
                  
            if ($this->last_row != $row){
                       echo '<br />';
            }
            $color = 'white';
            if ($c->getState() == GolCell::getStates()['alive']) $color = 'green';
            elseif ($c->getState() == GolCell::getStates()['dead']) $color = 'red';
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
                   
                   if ($c->getState() == GolCell::getStates()['alive']){
                       imagefilledrectangle($img, $x1, $y1, $x2, $y2, $onColour);
                   }
                   elseif ($c->getState() == GolCell::getStates()['dead']) {
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
        for ($i=0; $i<$this->now-1; $i++){
            $frames[] = './'.$i.'.gif';
            $durations[] = $pause;
        }
        $gc = new GifCreator\GifCreator();
        $gc->create($frames, $durations, 1);
        $gifBinary = $gc->getGif();        
        file_put_contents('./animated_picture.gif', $gifBinary);  
    }
    
    function __destruct() {
       print "Destroying " . $this->now . "\n";
    }

}
