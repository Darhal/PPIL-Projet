<?php
class BDD extends SQLie3
{
    private $file_path;
    private $file_name;
    private $table_name;
    private static $DB_PATH = "PPIL-Projet/Assets/BD/";

    function __construct($filename, $tab_name) {
        $file_path = $DB_PATH+$filename;
        $file_name = $filename;
        $table_name = $tab_name;
        $this->open($file_path);
    }

    function __destruct() {
        $this->close();
    }

    function getFilePath() {
        return $file_path;
    }

    function getFileName()
    {
        return $file_name;
    }

    function fetchResults($query)
    {
        $ret = $this->query($query);
        $res_array = array();

        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            array_push($res_array, $row);
        }

        // print_r($res_array);
        return $res_array;
    }

    function execQuery($query)
    {
        $ret = $this->exec($query);
        $this->handleErrors($ret);
    }

    function insertRow($row_data)
    {
        $attribs = "";
        $values = "";

        foreach ( $row_data as $key => $value ) {
            $attribs = $attribs."$key,";
            $values  = $values."'".$value."',";
        }

        // Remove trimming ","
        $attribs = rtrim($attribs, ",");
        $values = rtrim($values, ",");
        $ret = $db->exec("INSERT INTO $table_name ($attribs) VALUES($values);");
        $this->handleErrors($ret);
    }

    function handleErrors($ret){
        if(!$ret) { // error managment
            echo $this->lastErrorMsg();
        }
    }
}
?>