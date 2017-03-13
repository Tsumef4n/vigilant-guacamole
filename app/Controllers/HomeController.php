<?php

namespace App\Controllers;

use App\Models\Product;
use Slim\Views\Twig as View;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'welcome.twig', [
        'title' => 'Willkommen',
        'active' => 'welcome',
    ]);
    }

    public function news($request, $response, $args)
    {
        //id = page
        $id = 0;
        if (isset($args['id'])) {
            $id = $args['id'];
        }
        $news = Product::orderBy('created_at', 'DESC')->simplePaginate(5)->get();

        return $this->container->view->render($response, 'news.twig', [
        'title' => 'News',
        'active' => 'news',
        'news' => $news,
    ]);
    }

    public function onepage($request, $response)
    {
        return $this->container->view->render($response, 'onepage.twig', [
      'title' => 'Allgemeines auf einer Seite',
      'active' => 'onepage',
    ]);
    }

    public function impressum($request, $response)
    {
        return $this->container->view->render($response, 'impressum.twig', [
        'title' => 'Impressum',
        'active' => 'impressum',
    ]);
    }

    public function approach($request, $response)
    {
        return $this->container->view->render($response, 'approach.twig', [
        'title' => 'Anfahrt & Öffnungszeiten',
        'active' => 'approach',
    ]);
    }
}
