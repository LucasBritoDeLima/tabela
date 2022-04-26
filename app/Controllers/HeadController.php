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
}