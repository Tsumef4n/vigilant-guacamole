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

        //create a multidimensional array to hold a list of category and parent category
        $category = array(
            'categories' => array(),
            'parent_cats' => array(),
        );
        //build the array lists with data from the category table
        foreach ($categories as $cat) {
            $category['categories'][$cat['id']] = $cat;
            $category['parent_cats'][$cat['parent']][] = $cat['id'];
        }

        return $this->container->view->render($response, 'shop.list.twig', [
          'title' => 'Warenangebot',
          'active' => 'stock',
          'products' => $products,
          'id' => $id,
          'category_html' => self::buildCategory(0, $category),
      ]);
    }

  //TODO: In eigene Datei trennen oder anders machen
      public function buildCategory($parent, $category)
      {
          $html = '';
          if (isset($category['parent_cats'][$parent])) {
              $html .= '<ul class="nav nav-sub">';
              foreach ($category['parent_cats'][$parent] as $cat_id) {
                  if (!isset($category['parent_cats'][$cat_id])) {
                      $html .= "<li><a href='".$this->container->router->pathFor('stock').'/'.$category['categories'][$cat_id]['id']."'>".$category['categories'][$cat_id]['name'].'</a></li>';
                  }
                  if (isset($category['parent_cats'][$cat_id])) {
                      $html .= '<li><a>'.$category['categories'][$cat_id]['name'].'</a>';
                      $html .= self::buildCategory($cat_id, $category);
                      $html .= '</li>';
                  }
              }
              $html .= '</ul>';
          }

          return $html;
      }
}
