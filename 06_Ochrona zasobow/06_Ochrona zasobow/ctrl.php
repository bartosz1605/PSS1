<?php
require_once 'init.php';
getRouter()->setDefaultRoute('calcShow');
getRouter()->setLoginRoute('login');

getRouter()->addRoute('calcShow',    'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('process', 'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('login','LoginCtrl');
getRouter()->addRoute('logout','LoginCtrl', ['user','admin']);

try {
    getRouter()->go();
} catch (Exception $e) {
}