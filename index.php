<?php
require __DIR__ . '/autoload.php';

if (isset($_POST['logpas']) and !empty($_POST['logpas'])) {
    $logPas  = '';
    $logPas = $_POST['logpas'];
    $select = new \Models\Select();
    $result = $select->Connect($logPas);
}
