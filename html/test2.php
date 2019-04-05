<?php

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ERRMODE_EXCEPTION => 1
 
    ];

$db = new \PDO(
    'mysql:host=192.168.1.8;dbname=db462252800',
    'hoteltest',
    'hoteltest', $options
);


$statement = $db->prepare('SELECT * FROM th_hotels where hotel_id = ?');
$exec = $statement->execute([561]);
$rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
    var_dump( $rows);

