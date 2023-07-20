<?php

define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
include ROOT_PATH . '/handlers/dbHandler.php';
$dbHandler = new DatabaseHandler();

$data = $_POST['entryValues'];
$result = $dbHandler->insertData('budget_planner', $data);
if ($result == 1)
{
    echo 'Data inserted successfully';
}
else
{
    echo 'Unable to insert record';
}
$dbHandler->closeDB();

?>