<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Maker;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class AdminController extends Controller
{
    public function getList($request, $response, $args)
    {
        $id = 0;
        if (isset($args['id'])) {
            $id = $args['id'];
            $products = Product::with('maker')->where('maker_id', '=', $id)->orderBy('name')->get();
        } else {
            $products = Product::with('maker')->orderBy('name')->get();
        }
        $makers = Maker::where('status', '!=', 2)->orderBy('name')->get();

        return $this->container->view->render($response, 'admin/admin.list.twig', [
          'title' => 'Warenangebot',
          'active' => 'admin',
          'products' => $products,
          'makers' => $makers,
          'id' => $id,
      ]);
    }

    public function postNewProduct($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
          'name' => v::notEmpty(),
          'description' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('admin.list'));
        }

    // getParam uses name of element, not the id
    $user = Product::create([
      'name' => $request->getParam('name'),
      'description' => $request->getParam('description'),
      'maker_id' => 1,
    ]);

        $this->container->flash->addMessage('info', 'Produkt erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('admin.list'));
    }

    public function putUpdateProduct($request, $response, $args)
    {
        $validation = $this->container->validator->validate($request, [
          'name' => v::notEmpty(),
          'description' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler beim Update!');

            return $response->withRedirect($this->container->router->pathFor('admin.list'));
        }

        $product = Product::where('id', $args['id'])->update([
            'name' => $request->getParam('name'),
            'description' => $request->getParam('description'),
        ]);
        $this->container->flash->addMessage('info', 'Produkt erfolgreich geupdatet!');

        return $response->withRedirect($this->container->router->pathFor('admin.list'));
    }
}
