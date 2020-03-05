<?php
    include_once (getenv('BASE')."/Shared/Libraries/BDD.php");

    // USAGE OF THE LIBRARY BDD:
    $db = new BDD("test.db"); // Create the file if it doesnt exist open it otherwise
    // Create table test:
    $db->createTable("test",  array("user" => "VARCHAR(16) PRIMARY KEY", "pass" => "VARCHAR(64)", "num" => "INTEGER"));
    // insert into the table test: the following info
    $db->insertRow("test", array("user" => "test", "pass" => "XD", "num" => 666));

    // fetch results from table test:
    $arr = $db->fetchResults("test");
    foreach( $arr as $v){
        echo "USER = ". $v['user'] . "\n";
        echo "PASS = ". $v['pass'] ."\n";
        echo "NUM = ". $v['num'] ."\n";
    }
?>