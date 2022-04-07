<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class CarController extends Controller {
  
  public function createCar($request, $response) {

    $data = [
      'brands' => Brand::all()
    ];

    if($request->isGet())
      return $this->container->view->render($response, 'add-car.twig', $data);

      $validation = $this->container->validator->validate($request, [
        'car' => v::stringType()->notEmpty(),
        'brands' => v::notEmpty()
      ]);

      if($validation->failed()){
        $this->container->flash->addMessage('error', 'Houve um erro ao cadastrar o carro!');
        return $response->withRedirect($this->container->router->pathFor('car.createCar'));
      } else {
        Car::create([
          'name_car' => $request->getParam('car'),
          'brands_id' => $request->getParam('brands')
        ]);
        $this->container->flash->addMessage('success', 'Carro cadastrado com sucesso!');
      }
    return $response->withRedirect($this->container->router->pathFor('car.createCar'));
  }

  public function updateCar($request, $response) {

    if($request->isGet())
      return $this->container->view->render($response, 'edit-car.twig');

    $validation = $this->container->validator->validate($request, [
      'brand' => v::stringType()->notEmpty()
    ]);

    if($validation->failed()) {
      $this->container->flash->addMessage('error', 'Houve um erro ao consultar a montadora');
      return $response->withRedirect($this->container->router->pathFor('car.editCar'));
    } else {
      
    }
  }

  public function findCarsById($request, $response){
    
    $nameBrand = $request->getParam("name");

    $idBrand = $this->container->capsule::table('brands')->where('name', '=', $nameBrand)->first();

    $returnIdBrand = $idBrand->id;

    $namesCar = Car::where('brands_id', '=', $returnIdBrand)->get();

    return $response->write(json_encode($namesCar));
  }


}