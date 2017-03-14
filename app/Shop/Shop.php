<?php

namespace App\Shop;

class Shop extends App\Controllers\Controller
{
    public function createHTML($categories)
    {
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

        $category_html = self::buildCategory(0, $category);

        return $category_html;
    }

    public function buildCategory($parent, $category)
    {
        $html = '';
        if (isset($category['parent_cats'][$parent])) {
            $html .= '<ul class="nav nav-sub">';
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li><a href='".$this->container->router->pathFor('admin.shop').'/'.$category['categories'][$cat_id]['id']."'>".$category['categories'][$cat_id]['name'].'</a></li>';
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
