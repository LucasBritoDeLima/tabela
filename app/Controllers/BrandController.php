<?php

namespace App\Controllers;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;
use Exception;

class BrandController extends Controller
{

  public function createBrand($request, $response)
  {
    if ($request->isGet())
      return $this->container->view->render($response, 'add-brand.twig');

    $directory = $this->container->upload_directory;
    $brandPicture = $request->getUploadedFiles()['picture'];
    $files = $request->getUploadedFiles();

    if (!$brandPicture->getError()) {
      $filename = $this->moveUploadFile($directory, $brandPicture);

      $validation = $this->container->validator->validate($request, [
        'name' => v::stringType()->notEmpty(),
      ]);

      if (empty($brandPicture)) {
        throw new Exception('Invalid Image');
      }

      $uploadedFile = $files['picture'];

      if ($uploadedFile->getClientMediaType() == 'image/jpeg' || $uploadedFile->getClientMediaType() == 'image/png') {
        if ($validation->failed()) {
          return $response->withRedirect($this->container->router->pathFor('dashboard.createBrand'));
        }
        Brand::create([
          'name' => $request->getParam('name'),
          'picture' => $filename
        ]);
      } else {
        $this->container->flash->addMessage('error', 'Escolha um formato de arquivo válido');
      }

      $this->container->flash->addMessage('success', 'Dados enviados com sucesso!');
    } else {
      $this->container->flash->addMessage('error', 'Houve um erro ao processar a requisição!');
    }
    return $response->withRedirect($this->container->router->pathFor('dashboard.createBrand'));
  }

  private function moveUploadFile($directory, UploadedFile $uploadedFile)
  {
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename  = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    return $filename;
  }

  public function getBrand($request, $response)
  {
    $data = [
      'brands' => Brand::all()
    ];
    return $response->withJson($data);
  }

  // public function editBrand($request, $response) {
  //   if ($request->isGet())
  //     return $this->container->view->render($response, 'edit-brand.twig', $data = [
  //       'brands' => Brand::all()
  //     ]);
  // }

  public function editBrand($request, $response, $params)
  {
    $data = [
      'brands' => Brand::all()
    ];
    return $this->container->view->render($response, 'edit-brand.twig', $data);
  }

  public function editPostBrand($request, $response, $params)
  {
    $name = $request->getParam('name');
    $id = $request->getParam('idBrand');
    $directory = $this->container->upload_directory;
    $brandPicture = $request->getUploadedFiles()['picture'];
    $files = $request->getUploadedFiles();
    if (empty($brandPicture)) {
      throw new Exception('Invalid Image');
    }

    $uploadedFile = $files['picture'];

    if (!$brandPicture->getError()) {
      $filename = $this->moveUploadFile($directory, $brandPicture);
      $brand = Brand::where('id',$id)
      ->update(['name' => $name, 'picture' => $filename]);
      return $response->withRedirect($this->container->router->pathFor('dashboard.createBrand'));
    }
  }
}
