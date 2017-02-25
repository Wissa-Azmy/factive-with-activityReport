<?php

try{
    $dbh = new pdo( 'mysql:host=localhost;dbname=marsadma_mian',
                    'marsadma_root',
                    'q~aTT)Bfm#C0',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}

?>
