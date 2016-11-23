<?php
// default index action, GET /
$app->get('/', 'Toucan\Controller\IndexController:actionIndex')
    ->name('get-homepage');
