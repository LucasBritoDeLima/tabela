<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Controllers\Controller;
use App\Models\HeadCar;
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

  public function editCar($request, $response) {
    $nameCar = $request->getParam("newName");
    $id = $request->getParam("nameOriginal");

    $validation = $this->container->validator->validate($request, [
      'newName' => v::stringType()->notEmpty(),
      'nameOriginal' => v::notEmpty()
    ]);

    if ($validation->failed()){
      $this->container->flash->addMessage('error', 'Houve um erro ao processar a requisição!');
    }
    Car::where('id',$id)->update(['name_car' => $nameCar]);
    $this->container->flash->addMessage('success', 'Nome do modelo de carro editado com sucesso!');
  }

  public function deleteCar($request, $response) {
    $idCar = $request->getParam("id");

    $car = Car::find($idCar);
    
    if($car) {
      $car->delete();
    } else {
      $this->container->flash->addMessage('danger', 'Erro: O carro não pode ser deletado!');
    }
  }

  public function getCarById($request, $response){
    $brandId = $request->getParam("id");
    
    $data =  Car::where('brands_id', '=', $brandId)->get();

    if(empty($data)){
      $data = [
        [
          "id" => null,
          "name_car" => "Não existem carros para esta montadora"
        ]
      ];
    }else {
      $data = $data;
    }

    return $response->withJson($data);
  }

  public function viewAssociation($request, $response){
    if($request->isGet())
    return $this->container->view->render($response, 'edit-head-car.twig'); 
  }

  public function headJoinCar($request, $response){
    $data = $this->container->capsule::select('SELECT cylinder_head.id as idHead, cylinder_head.name_engine as cylinderHead, cars.id as idCar, cars.name_car as carName, cars_cylinder_head.id as idJoin, cars_cylinder_head.visible as isVisible FROM cars_cylinder_head INNER JOIN cars ON (cars.id = cars_cylinder_head.cars_id) INNER JOIN  cylinder_head ON (cylinder_head.id = cars_cylinder_head.cylinder_head_id) WHERE cars_cylinder_head.visible = 1;');

    return $response->withJson($data);
  }

  public function hideAssoc($request, $response){
    $idJoin = $request->getParam('idJoin');

    $statement = HeadCar::where('id', '=', $idJoin)->update(['visible' => 0]);

    if($statement)
      return "Excluido com sucesso!";
  }

  public function searchAssoc($request, $response)
  {
    $searchTerm = $request->getParam("search");

    if ($searchTerm) {
      $data = $this->container->capsule::select("SELECT cylinder_head.id as idHead, cylinder_head.name_engine as cylinderHead, cars.id as idCar, cars.name_car as carName, cars_cylinder_head.id as idJoin, cars_cylinder_head.visible as isVisible FROM cars_cylinder_head INNER JOIN cars ON (cars.id = cars_cylinder_head.cars_id) INNER JOIN  cylinder_head ON (cylinder_head.id = cars_cylinder_head.cylinder_head_id) WHERE cars.name_car LIKE '%".$searchTerm."%' AND cars_cylinder_head.visible = 1;");
    } else {
      $data = $this->container->capsule::select('SELECT cylinder_head.id as idHead, cylinder_head.name_engine as cylinderHead, cars.id as idCar, cars.name_car as carName, cars_cylinder_head.id as idJoin, cars_cylinder_head.visible as isVisible FROM cars_cylinder_head INNER JOIN cars ON (cars.id = cars_cylinder_head.cars_id) INNER JOIN  cylinder_head ON (cylinder_head.id = cars_cylinder_head.cylinder_head_id) WHERE cars_cylinder_head.visible = 1;');
    }

    return $response->withJson($data);
  }

  public function viewDetails($request, $response, $params) {

    $data = [
      'brandName' => Brand::where('name', '=', $params['brandName'])->first()
    ];
    
    if($data["brandName"]) {
      return $this->container->view->render($response, 'brand.twig', $data);
    } else {
      return $response->withRedirect($this->container->router->pathFor('home'));
    }
  }

}