<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Maker;
use App\Models\Product;
use Slim\Views\Twig as View;

class ShopController extends Controller
{
  public function stock($request, $response)
  {
    $products = Maker::all();

    return $this->container->view->render($response, 'shop.list.twig', [
          'title' => "Warenangebot",
          'active' => "stock",
          'products' => $products,
      ]);
  }
}
