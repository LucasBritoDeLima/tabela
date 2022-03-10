<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserPermission;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

  public function login($request, $response) {
    if($request->isGet())
      return $this->container->view->render($response, 'index.twig');

    if(!$this->container->auth->attempt(
      $request->getParam('email'),
      $request->getParam('password'))){
        return $response->withRedirect($this->container->router->pathFor('auth.login'));
      }

    return $response->withRedirect($this->container->router->pathFor('dashboard.home'));
  }

  public function register($request, $response) {
    if($request->isGet())
      return $this->container->view->render($response, 'register.twig');

      $validation = $this->container->validator->validate($request, [
        'user' => v::notEmpty()->alpha()->length(5),
        'email' => v::notEmpty()->noWhitespace()->email(),
        'password' => v::notEmpty()->noWhitespace()
      ]);

      if($validation->failed())
        return $response->withRedirect($this->container->router->pathFor('auth.register'));
      
      $user = User::create([
        'username' => $request->getParam('user'),
        'email' => $request->getParam('email'),
        'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
      ]);

      $user->permissions()->create(UserPermission::$defaults);

      return $response->withRedirect($this->container->router->pathFor('auth.login'));
  }
}