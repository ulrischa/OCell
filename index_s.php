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
        <p>Bei diesem Beipiel wird sofort bei einem Zustandswechsel die Nachbarschaft informiert und somit können sich innerhalb einer Generation mehrere Zwischenzustände ergeben.</p>
        <?php

        include_once 'World.php';
        include_once 'SimpleWorld.php';

        $w = new SimpleWorld(true, 5, 4, 4);

      
       
        ?>
    </body>
</html>
