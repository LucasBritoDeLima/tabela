<?php

$app->get('/', 'HomeController:index')->setName('home');

$app->group('/auth', function($app){
  $app->map(['GET', 'POST'], '/login', 'AuthController:login')->setName('auth.login');
  $app->map(['GET', 'POST'], '/registrar', 'AuthController:register')->setName('auth.register');
  $app->get('/logout', 'AuthController:logout')->setName('auth.logout');
});

$app->group('/dashboard', function($app){
  $app->map(['GET', 'POST'], '/home', 'DashboardController:dashboard')->setName('dashboard.home');
  $app->map(['GET', 'POST'], '/app', 'DashboardController:app')->setName('dashboard.app');
  $app->map(['GET', 'POST'], '/app/Montadora', 'BrandController:createBrand')->setName('dashboard.createBrand');
  $app->map(['GET', 'POST'], '/app/addBrandEdit', 'DashboardController:appBrandEdit')->setName('dashboard.appBrandEdit');
  $app->map(['GET', 'POST'], '/app/addHeadAdd', 'DashboardController:appHeadAdd')->setName('dashboard.appHeadAdd');
  $app->map(['GET', 'POST'], '/app/addHead', 'DashboardController:appHead')->setName('dashboard.appHead');
  $app->map(['GET', 'POST'], '/app/addCar', 'DashboardController:appCar')->setName('dashboard.appCar');
  $app->map(['GET', 'POST'], '/app/EditCar', 'DashboardController:appCarEdit')->setName('dashboard.appCarEdit');
  $app->map(['GET', 'POST'], '/app/HeadCar', 'DashboardController:appHeadCar')->setName('dashboard.appHeadCar');
});