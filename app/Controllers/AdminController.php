<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cat_Group;
use App\Models\News;
use App\Models\Press;
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

    public function postNewsNew($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
          'title' => v::notEmpty(),
          'text' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('admin.news.new'));
        }

        $news = News::create([
          'title' => $request->getParam('title'),
          'text' => $request->getParam('text'),
        ]);

        $this->container->flash->addMessage('info', 'News erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('admin.news.list'));
    }

    public function getNewsEdit($request, $response, $args)
    {
        $id = $args['id'];

        $news = News::where('id', $id)->first();
        // check if user found
        if (!$news) {
            //falls es die id nicht gibt, weil z.b. jemand so auf die seite ging
            //return false;
        }

        return $this->container->view->render($response, 'admin/admin.news.edit.twig', [
          'title' => 'News bearbeiten',
          'active' => 'admin.news',
          'id' => $id,
          'news' => $news,
      ]);
    }

    public function postNewsEdit($request, $response, $args)
    {
        $id = $args['id'];

        $validation = $this->container->validator->validate($request, [
          'title' => v::notEmpty(),
          'text' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler beim Update!');

            return $response->withRedirect($this->container->router->pathFor('admin.news.edit', ['id' => $id]));
        }

        $product = News::where('id', $args['id'])->update([
            'title' => $request->getParam('title'),
            'text' => $request->getParam('text'),
        ]);

        $this->container->flash->addMessage('info', 'News erfolgreich geupdatet!');

        return $response->withRedirect($this->container->router->pathFor('admin.news.list'));
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

        $cat_html = self::buildCategory($cat_groups, $categories);

        return $this->container->view->render($response, 'admin/admin.shop.list.twig', [
          'title' => 'Warenangebot',
          'active' => 'admin.shop',
          'products' => $products,
          'categories' => $categories,
          'groups' => $cat_groups,
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
                    $html .= "<li><a href='".$this->container->router->pathFor('admin.shop.list').'/'.$category['id']."'>".$category['name'].'</a></li>';
                }
            }
            $html .= '</ul>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function getShopNew($request, $response)
    {
        //get all categories
        $categories = Category::orderBy('parent')->orderBy('name')->get();
        //get groups for categories //NOTE: abfragen reduzieren?
        $cat_groups = Cat_Group::orderBy('name')->get();

        return $this->container->view->render($response, 'admin/admin.shop.new.twig', [
          'title' => 'Neues Produkt',
          'active' => 'admin.shop',
          'categories' => $categories,
          'groups' => $cat_groups,
      ]);
    }

    public function postShopNew($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
          'name' => v::notEmpty(),
          'description' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('admin.shop.new'));
        }

        // Get selected file
        $files = $request->getUploadedFiles();
        $ext = '';
        $file = $files['file'];

        if ($file->file == '') {
            // Keine Datei ausgewaehlt...
            $nextId = Product::insertGetId([
                'name' => $request->getParam('name'),
                'description' => $request->getParam('description'),
                'maker_id' => $request->getParam('maker_id'),
                'image' => 'png',
            ]);
            copy('public/images/fix/platzhalter.png', 'public/images/products/'.$nextId.'.png');
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
                $nextId = Product::insertGetId([
                    'name' => $request->getParam('name'),
                    'description' => $request->getParam('description'),
                    'maker_id' => $request->getParam('maker_id'),
                    'image' => $ext,
                ]);
                $file->moveTo('public/images/products/'.$nextId.'.'.$ext);
            }
        }

        $this->container->flash->addMessage('info', 'Produkt erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('admin.shop.list'));
    }

    public function getShopEdit($request, $response, $args)
    {
        $id = $args['id'];

        $product = Product::where('id', $id)->first();
        // check if user found
        if (!$product) {
            //falls es die id nicht gibt, weil z.b. jemand so auf die seite ging
            //return false;
        }

        //get all categories
        $categories = Category::orderBy('parent')->orderBy('name')->get();
        //get groups for categories //NOTE: abfragen reduzieren?
        $cat_groups = Cat_Group::orderBy('name')->get();

        return $this->container->view->render($response, 'admin/admin.shop.edit.twig', [
          'title' => 'Produkt bearbeiten',
          'active' => 'admin.shop',
          'categories' => $categories,
          'groups' => $cat_groups,
          'id' => $id,
          'product' => $product,
      ]);
    }

    public function putShopEdit($request, $response, $args)
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

    public function getPressList($request, $response)
    {
        $press = Press::orderBy('created_at')->get();

        return $this->container->view->render($response, 'admin/admin.press.list.twig', [
          'title' => 'Presse',
          'active' => 'admin.press',
          'press' => $press,
      ]);
    }

    public function getPressNew($request, $response)
    {
        return $this->container->view->render($response, 'admin/admin.press.new.twig', [
          'title' => 'Neuer Presseeintrag',
          'active' => 'admin.press',
      ]);
    }

    public function postPressNew($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
          'title' => v::notEmpty(),
          'text' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('admin.press.new'));
        }

        $press = Press::create([
          'title' => $request->getParam('title'),
          'text' => $request->getParam('text'),
        ]);

        $this->container->flash->addMessage('info', 'Presseeintrag erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('admin.press.list'));
    }

    public function getPressEdit($request, $response, $args)
    {
        $id = $args['id'];

        $press = Press::where('id', $id)->first();
        // check if user found
        if (!$press) {
            //falls es die id nicht gibt, weil z.b. jemand so auf die seite ging
            //return false;
        }

        return $this->container->view->render($response, 'admin/admin.press.edit.twig', [
          'title' => 'Presseeintrag bearbeiten',
          'active' => 'admin.press',
          'id' => $id,
          'press' => $press,
      ]);
    }

    public function postPressEdit($request, $response, $args)
    {
        $id = $args['id'];

        $validation = $this->container->validator->validate($request, [
          'title' => v::notEmpty(),
          'text' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler beim Update!');

            return $response->withRedirect($this->container->router->pathFor('admin.press.edit', ['id' => $id]));
        }

        $product = Press::where('id', $args['id'])->update([
            'title' => $request->getParam('title'),
            'text' => $request->getParam('text'),
        ]);

        $this->container->flash->addMessage('info', 'Presseeintrag erfolgreich geupdatet!');

        return $response->withRedirect($this->container->router->pathFor('admin.press.list'));
    }
}
