<?php

namespace App\Controllers;

use App\Models\Brand;
use Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;

class BrandController extends Controller {

  public function createBrand($request, $response){
    if($request->isGet())
      return $this->container->view->render($response, 'add-brand.twig');

    $directory = $this->container->upload_directory;
    $picture = $request->getUploadedFiles()['picture'];

    if(!$picture->getError()){
      $filename = $this->moveUploadFile($directory, $picture);

      $validation = $this->container->validator->validate($request, [
        'name' => v::length(3)->notEmpty(),
      ]);

      if($validation->failed())
        return $response->withRedirect($this->container->router->pathFor('dashboard.createBrand'));

      Brand::create([
        'name' => $request->getParam('name'),
        'picture' => $filename,
        'brands_id' => 1
      ]);

      
      $this->container->flash->addMessage('success', 'Dados enviados com sucesso!');
    } else {
      $this->container->flash->addMessage('error', 'Houve um erro ao processar a requisição!');
    }

    return $response->withRedirect($this->container->router->pathFor('dashboard.createBrand'));

  }

  private function moveUploadFile($directory, UploadedFile $uploadedFile) {
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename  = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    return $filename;
  }
}