<?php
    include ("../BDD.php");

    $db = new BDD("test.db");
    $db->createTable("test",  array("user" => "VARCHAR(16) PRIMARY KEY", "pass" => "VARCHAR(64)", "num" => "INTEGER"));

    $db->insertRow("test", array("user" => "test", "pass" => "XD", "num" => 666));

    $arr = $db->fetchResults("test");
    foreach( $arr as $v){
        echo "USER = ". $v['user'] . "\n";
        echo "PASS = ". $v['pass'] ."\n";
        echo "NUM = ". $v['num'] ."\n";
    }
?>