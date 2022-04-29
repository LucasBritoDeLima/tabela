<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;
use App\Models\Head;

class HeadController extends Controller {
  
  public function addHead($request, $response){
    if ($request->isGet())
      return $this->container->view->render($response, 'add-head.twig');

    $validation = $this->container->validator->validate($request, [
      'fuel' => v::length(3)->stringType()->notEmpty(),
      'material' => v::length(5)->stringType()->notEmpty(),
      'engine-name' => v::length(5)->stringType()->notEmpty(),
      'height-std' => v::length(3)->stringType()->notEmpty(),
      'min-height' => v::length(3)->stringType()->notEmpty(),
      'observation' => v::stringType(),
    ]);

    if($validation->failed())
      return $response->withRedirect($this->container->router->pathFor('dashboard.appHeadAdd'));
      /*echo "<pre>";
      print_r($validation);
      echo "</pre>";
      die();*/

    Head::create([
      'fuel' => $request->getParam('fuel'),
      'material_kind' => $request->getParam('material'),
      'name_engine' => $request->getParam('engine-name'),
      'standard_height' => $request->getParam('height-std'),
      'minimum_height' => $request->getParam('min-height'),
      'observation' => $request->getParam('observation')
    ]);

    $this->container->flash->addMessage('success', 'Cabeçote adicionado com sucesso!');
    return $response->withRedirect($this->container->router->pathFor('dashboard.appHeadAdd'));
  }

  public function allHeads($request, $response) {
    $data = [
      'heads' => Head::all()
    ];
    return $response->withJson($data);
  }

  public function updateHeads($request, $response) {

    $idHead = $request->getParam('head_id');
    $nameHead = $request->getParam('edit_name_head');
    $fuelHead = $request->getParam('edit_head_fuel');
    $materialHead = $request->getParam('edit_material_head');
    $stdHead = $request->getParam('edit_std_head');
    $minHead = $request->getParam('edit_min_head');
    $obsHead = $request->getParam('edit_obs_head');

    $validation = $this->container->validator->validate($request, [
      'head_id' => v::stringType()->notEmpty(),
      'edit_name_head' => v::stringType()->notEmpty(),
      'edit_head_fuel' => v::stringType()->notEmpty(),
      'edit_material_head' => v::stringType()->notEmpty(),
      'edit_std_head' => v::stringType()->notEmpty(),
      'edit_min_height' => v::stringType()->notEmpty(),
      'edit_obs_head' => v::stringType()->notEmpty()
    ]);

    if ($validation->failed()){
      $this->container->flash->addMessage('error', 'Houve um erro ao processar a requisição!');
    }

    Head::where('id', $idHead)->update([
      'fuel' => $fuelHead,
      'material_kind' => $materialHead,
      'name_engine' => $nameHead,
      'standard_height' => $stdHead,
      'minimum_height' => $minHead,
      'observation' => $obsHead
    ]);

    $this->container->flash->addMessage('success', 'Cabeçote atualizado com sucesso!');
  }

  public function deleteHead($request, $response) {
    $idHead = $request->getParam("id");

    $head = Head::find($idHead);
    
    if($head) {
      $head->delete();
    } else {
      $this->container->flash->addMessage('danger', 'Erro: O cabeçote não pode ser apagado!');
    }
  }

  public function searchLive($request, $response) {
    $searchTerm = $request->getParam("search");

    if($searchTerm) {
      // $result = Head::where('name_engine', 'LIKE', '%'.$searchTerm.'%')->get();
      $result = [
        'heads' => $this->container->capsule::table('cylinder_head')->where('name_engine', 'LIKE', '%'.$searchTerm.'%')->get()
      ];
    } else {
      $result = [
        'heads' => Head::all()
      ];
    }

    return $response->withJson($result);
  }
}