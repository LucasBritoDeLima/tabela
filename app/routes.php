<?php

$app->get('/', 'HomeController:index');

$app->group('/auth', function($app){
  $app->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('auth.login');
  $app->map(['GET', 'POST'], '/registrar', 'AuthController:register')->setName('auth.register');
  $app->get('/logout', 'AuthController:logout')->setName('auth.logout');
});