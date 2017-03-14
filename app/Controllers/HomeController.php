<?php

namespace App\Controllers;

use App\Models\News;
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

    public function kulinarisches($request, $response)
    {
        return $this->container->view->render($response, 'kulinarisches.twig', [
        'title' => 'Kulinarisches',
        'active' => 'kulinarisches',
    ]);
    }

    public function aboutUs($request, $response)
    {
        return $this->container->view->render($response, 'aboutUs.twig', [
        'title' => 'Über uns',
        'active' => 'aboutUs',
    ]);
    }

    public function press($request, $response)
    {
        return $this->container->view->render($response, 'press.twig', [
        'title' => 'Presse',
        'active' => 'press',
    ]);
    }

    public function news($request, $response, $args)
    {
        $page = 1;
        if (isset($args['page'])) {
            $page = $args['page'];
        }
        $offset = ($page - 1) * 5;
        $news = News::orderBy('created_at', 'DESC')->limit(5)->offset($offset)->get();

        return $this->container->view->render($response, 'news.twig', [
        'title' => 'News',
        'active' => 'news',
        'news' => $news,
        'page' => $page,
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
