<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Maker;
use App\Models\Product;
use Slim\Views\Twig as View;

class ShopController extends Controller
{
  public function stock($request, $response, $args)
  {
    $id = 0;
    if (isset($args['id']))
    {
      $id = $args['id'];
      $products = Product::with('maker')->where('maker_id', '=', $id)->orderBy('name')->get();
    }
    else
    {
      $products = Product::with('maker')->orderBy('name')->get();
    }
    $makers = Maker::where('status', '!=', 2)->orderBy('name')->get();

    return $this->container->view->render($response, 'shop.list.twig', [
          'title' => "Warenangebot",
          'active' => "stock",
          'products' => $products,
          'makers' => $makers,
          'id' => $id,
      ]);
  }
}
