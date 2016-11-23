<?php
    $app->group('/toucan', function() use($app) {
        $app->group('/students', function() use($app) {
            $app->get('/list',              'Toucan\Controller\StudentController:actionGetStudents');

            $app->get('/list/:school_name', 'Toucan\Controller\StudentController:actionGetStudentsPerSchool')->conditions(array(':school_name' => '\w+'));

            $app->get( '/create',           'Toucan\Controller\StudentController:actionCreateStudent');
            $app->post('/create',           'Toucan\Controller\StudentController:actionCreateStudent');
        });
    });
