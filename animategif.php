<?php
        include_once 'GifCreator.php';
    $directory = './';
    
    $pause = 50;

    if (! is_dir($directory)) {
        exit('Invalid diretory path');
    }

    $files = array();

    foreach (scandir($directory) as $file) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        $parts = explode('.',$file);
        if (end($parts) == 'gif')$files[] = $parts[0];
    }
        sort($files, SORT_NUMERIC);
        var_dump($files);
    
        $frames = array();
        $durations = array();
       foreach($files as $gif){
            $frames[] = $gif.'.gif';
            $durations[] = $pause;
        }
        $gc = new GifCreator\GifCreator();
        $gc->create($frames, $durations, 1);
        $gifBinary = $gc->getGif();        
        file_put_contents('./animated_picture.gif', $gifBinary);  
?>