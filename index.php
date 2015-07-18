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
        include_once 'GifCreator.php';
        include_once 'World.php';
        include_once 'SimpleWorld.php';

        $w = new SimpleWorld(10);
       // $w->big_bang();
       // $w->run_the_world();
        $w->anmimatedgif(100);
       
        ?>
    </body>
</html>
