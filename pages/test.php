<?php

use Exception;
use MongoDB\Driver\Manager;

try
{
    $uri = 'mongodb+srv://sadmin:sadmin@cluster0.5ufcvsy.mongodb.net/?retryWrites=true&w=majority&authSource=expenseData&authMechanism=SCRAM';
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";
}
catch (Exception $e)
{
    printf($e->getMessage());
}

$manager = new MongoDB\Driver\Manager($uri);
var_dump($manager);

?>