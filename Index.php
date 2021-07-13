<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once 'php/AutoLoader.php';

$AutoLoader = new AutoLoader;
$AutoLoader->addDirectory('php');
$AutoLoader->register();

$HomePage = new HomePage();
$HomePage->start();



?>