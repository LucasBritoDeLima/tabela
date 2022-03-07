<?php

namespace App\Controllers;

class AuthController extends Controller {

  public function login($request, $response) {
    return $this->container->view->render($response, 'index.twig');
  }
}