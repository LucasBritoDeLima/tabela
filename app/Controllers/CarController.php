<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use App\Models\Car;

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


}