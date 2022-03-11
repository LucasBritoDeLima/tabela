<?php

namespace App\Controllers;

class DashboardController extends Controller {

  public function dashboard($request, $response) {
    return $this->container->view->render($response, 'dashboard.twig');
  }

  public function app($request, $response) {
    return $this->container->view->render($response, 'app-options.twig');
  }

}