<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cat_Group;
use App\Models\News;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class AdminController extends Controller
{
    public function getNewsList($request, $response)
    {
        $news = News::orderBy('created_at')->get();

        return $this->container->view->render($response, 'admin/admin.news.list.twig', [
          'title' => 'News',
          'active' => 'admin.news',
          'news' => $news,
      ]);
    }

    public function getNewsNew($request, $response)
    {
        return $this->container->view->render($response, 'admin/admin.news.new.twig', [
          'title' => 'Neue News',
          'active' => 'admin.news',
      ]);
    }

    public function getShopList($request, $response, $args)
    {
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

        return $this->container->view->render($response, 'admin/admin.shop.twig', [
          'title' => 'Warenangebot',
          'active' => 'admin.shop',
          'products' => $products,
          'categories' => $categories,
          'groups' => $cat_groups,
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

    public function postShopNewProduct($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
          'name' => v::notEmpty(),
          'description' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('admin.shop'));
        }

        // Get selected file
        $files = $request->getUploadedFiles();
        $ext = '';
        if (empty($files['file'])) {
            // Keine Datei ausgewaehlt...
        } else {
            $file = $files['file'];
            // Upload zu big
            if ($file->getError() === UPLOAD_ERR_INI_SIZE || $file->getError() === UPLOAD_ERR_FORM_SIZE) {
                $this->container->flash->addMessage('error', 'Fehler beim Upload. Bild zu groß!');
                $ext = '';
            }
            //  Upload new file
            if ($file->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $file->getClientFilename();
                $ext = pathinfo($uploadFileName, PATHINFO_EXTENSION);
                $file->moveTo('public/images/products/'.$args['id'].'.'.$ext);
            }
        }
        // check, ob neues Bild
        if ($ext == '') {
            // getParam uses name of element, not the id
            $user = Product::create([
          'name' => $request->getParam('name'),
          'description' => $request->getParam('description'),
          'maker_id' => 1,
        ]);
        } else {
            $user = Product::create([
          'name' => $request->getParam('name'),
          'description' => $request->getParam('description'),
          'maker_id' => 1,
          'image' => $ext,
        ]);
        }

        $this->container->flash->addMessage('info', 'Produkt erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('admin.shop'));
    }

    public function putShopUpdateProduct($request, $response, $args)
    {
        $validation = $this->container->validator->validate($request, [
          'name' => v::notEmpty(),
          'description' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler beim Update!');

            return $response->withRedirect($this->container->router->pathFor('admin.shop'));
        }
        // Get selected file
        $files = $request->getUploadedFiles();
        $ext = '';
        if (empty($files['file'])) {
            // Keine Datei ausgewaehlt...komplett nutzlos aktuell
        } else {
            $file = $files['file'];
            // Upload zu big
            if ($file->getError() === UPLOAD_ERR_INI_SIZE || $file->getError() === UPLOAD_ERR_FORM_SIZE) {
                $this->container->flash->addMessage('error', 'Fehler beim Upload. Bild zu groß!');
                $ext = '';
            }
            //  Upload new file
            if ($file->getError() === UPLOAD_ERR_OK) {
                // Check for old file to delete
                $list = glob('public/images/products/'.$args['id'].'.*');
                if (count($list) > 0) {
                    unlink($list[0]);
                }
                $uploadFileName = $file->getClientFilename();
                $ext = pathinfo($uploadFileName, PATHINFO_EXTENSION);
                $file->moveTo('public/images/products/'.$args['id'].'.'.$ext);
            }
        }
        // check, ob neues Bild
        if ($ext == '') {
            $product = Product::where('id', $args['id'])->update([
            'name' => $request->getParam('name'),
            'description' => $request->getParam('description'),
            'maker_id' => $request->getParam('maker_id'),
        ]);
        } else {
            $product = Product::where('id', $args['id'])->update([
            'name' => $request->getParam('name'),
            'description' => $request->getParam('description'),
            'maker_id' => $request->getParam('maker_id'),
            'image' => $ext,
        ]);
        }

        $this->container->flash->addMessage('info', 'Produktdaten erfolgreich geupdatet!');

        return $response->withRedirect($this->container->router->pathFor('admin.shop'));
    }
}
