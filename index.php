<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // 11 12 13
        // 21 22 23
        // 31 32 33
        include_once 'Cell.php';
        include_once 'SimpleCell.php';
        
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
        
        $all_cells = array($c11,
                            $c12,
                            $c13,
                            $c21,
                            $c22,
                            $c23,
                            $c31,
                            $c32,
                            $c33
                            );
        
        $rand_expand = array_rand($all_cells, 2);
        echo "<strong>Erste Runde</strong> <br />";
        echo  $all_cells[$rand_expand[0]]->getId().' expand <br />';
        echo  $all_cells[$rand_expand[1]]->getId().' expand <br />';
       $all_cells[$rand_expand[0]]->setState(SimpleCell::getStates()['expand']);
       $all_cells[$rand_expand[1]]->setState(SimpleCell::getStates()['expand']);
       
       //Durchläufe
       $rounds = 20;
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
      
        
        
        ?>
    </body>
</html>
