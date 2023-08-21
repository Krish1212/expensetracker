<?php

use Exception;
use MongoDB\Driver\Manager;

$uname = 'sadmin';
$upass = 'sadmin';
$uri = 'mongodb+srv://' . $uname . ':' . $upass . '@cluster0.5ufcvsy.mongodb.net/?retryWrites=true&w=majority&authSource=expenseData&authMechanism=SCRAM-SHA-1';

$manager = new MongoDB\Driver\Manager($uri);
$command = new MongoDB\Driver\Command(['count' => 'collection']);
try
{
    $cursor = $manager->executeCommand('db', $command);
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";
}
catch (Exception $e)
{
    printf($e->getMessage());
    exit;
}
$response = $cursor->toArray()[0];
var_dump($response);

?>