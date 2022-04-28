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
  $app->map(['GET', 'POST'], '/app/EditarMontadora', 'BrandController:editBrand')->setName('dashboard.appBrandEdit');
  $app->map(['GET', 'POST'], '/app/addHeadAdd', 'HeadController:addHead')->setName('dashboard.appHeadAdd');
  $app->map(['GET', 'POST'], '/app/addHead', 'DashboardController:appHead')->setName('dashboard.appHead');
  $app->map(['GET', 'POST'], '/app/addCar', 'CarController:createCar')->setName('car.createCar');
  $app->map(['GET', 'POST'], '/app/EditCar', 'CarController:updateCar')->setName('car.editCar');
  $app->map(['GET', 'POST'], '/app/HeadCar', 'DashboardController:appHeadCar')->setName('dashboard.appHeadCar');
});

$app->get('/brands', 'BrandController:getBrand')->setName('getBrand');
$app->get('/brand', 'BrandController:getSingleBrand')->setName('getSingleBrand');
$app->get('/car', 'CarController:findCarsById')->setName('getCars');
$app->get('/heads', 'HeadController:allHeads')->setName('getAllHeads');
$app->post('/app/edit-car', 'CarController:editCar')->setName('carEdit');
$app->post('/app/edit-head', 'HeadController:updateHeads')->setName('headEdit');
$app->post('/app/delete-car', 'CarController:deleteCar')->setName('carDelete');
$app->post('/app/delete-head', 'HeadController:deleteHead')->setName('headDelete');
$app->post('/app/EditarMontadora/sim', 'BrandController:editPostBrand')->setName('mudar');