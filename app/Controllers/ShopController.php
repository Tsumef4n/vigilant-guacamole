<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Cat_Group;
use App\Models\Product;
use Slim\Views\Twig as View;

class ShopController extends Controller
{
    public function stock($request, $response, $args)
    {
        //TODO: Pagination!!!
        $id = 0;
        if (isset($args['id'])) {
            $id = $args['id'];
            $products = Product::with('category')->where('maker_id', '=', $id)->orderBy('name')->get();
        } else {
            $products = Product::with('category')->orderBy('name')->get();
        }
        //get all categories
        $categories = Category::orderBy('parent')->orderBy('name')->get();
        //get groups for categories //NOTE: abfragen reduzieren?
        $cat_groups = Cat_Group::orderBy('name')->get();

        $cat_html = self::buildCategory($cat_groups, $categories);

        return $this->container->view->render($response, 'shop.list.twig', [
          'title' => 'Warenangebot',
          'active' => 'stock',
          'products' => $products,
          'id' => $id,
          'category_html' => $cat_html,
      ]);
    }

    public function buildCategory($cat_groups, $categories)
    {
        $html = '';
        $html .= '<ul class="nav nav-sub">';
        foreach ($cat_groups as $cat_group) {
            $html .= '<li><div class="nav-group">'.$cat_group['name'].'</div>';
            $html .= '<ul class="nav nav-sub">';
            foreach ($categories as $category) {
                if ($category['parent'] == $cat_group['id']) {
                    $html .= "<li><a href='".$this->container->router->pathFor('stock').'/'.$category['id']."'>".$category['name'].'</a></li>';
                }
            }
            $html .= '</ul>';
        }
        $html .= '</ul>';

        return $html;
    }
}
