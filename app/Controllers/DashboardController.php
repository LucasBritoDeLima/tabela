<?php

namespace App\Controllers;

class DashboardController extends Controller {

  public function dashboard($request, $response) {
    return $this->container->view->render($response, 'dashboard.twig');
  }

  public function app($request, $response) {
    return $this->container->view->render($response, 'app-options.twig');
  }

  public function appBrand($request, $response) {
    return $this->container->view->render($response, 'add-brand.twig');
  }

  public function appHead($request, $response) {
    return $this->container->view->render($response, 'edit-head.twig');
  }

  public function appHeadAdd($request, $response) {
    return $this->container->view->render($response, 'add-head.twig');
  }

  public function appCar($request, $response) {
    return $this->container->view->render($response, 'add-car.twig');
  }

  public function appCarEdit($request, $response) {
    return $this->container->view->render($response, 'edit-car.twig');
  }

}