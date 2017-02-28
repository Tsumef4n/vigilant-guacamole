<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Maker;
use Slim\Views\Twig as View;

class AdminController extends Controller
{
  public function getList($request, $response, $args)
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

    return $this->container->view->render($response, 'admin/admin.list.twig', [
          'title' => "Warenangebot",
          'active' => "admin",
          'products' => $products,
          'makers' => $makers,
          'id' => $id,
      ]);
  }
}
