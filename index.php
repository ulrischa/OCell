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

        include_once 'World.php';
        include_once 'SimpleWorld.php';
        
        $w = new SimpleWorld(10);
        $w->big_bang();
        $w->run_the_world();
        
        
        ?>
    </body>
</html>
