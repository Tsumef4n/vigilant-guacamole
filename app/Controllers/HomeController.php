<?php

namespace App\Controllers;

use App\Models\News;
use App\Models\Press;
use App\Models\Kulinarisches;
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

    public function getKulinarisches($request, $response)
    {
        $cur_month = date('n');
        $cur_year = date('Y');

        return $this->container->view->render($response, 'kulinarisches.twig', [
        'title' => 'Kulinarisches',
        'active' => 'kulinarisches',
        'cur_month' => $cur_month,
        'cur_year' => $cur_year,
    ]);
    }

    public function postKulinarisches($request, $response)
    {
        $cur_month = date('n');
        $cur_year = date('Y');
        $sel_month = $request->getParam('month');
        $sel_year = $request->getParam('year');

        $kulinarisches = Kulinarisches::where('month', $sel_month)->where('year', $sel_year)->get()->first();

        return $this->container->view->render($response, 'kulinarisches.twig', [
        'title' => 'Kulinarisches',
        'active' => 'kulinarisches',
        'cur_month' => $cur_month,
        'cur_year' => $cur_year,
        'sel_month' => $sel_month,
        'sel_year' => $sel_year,
        'kulinarisches' => $kulinarisches,
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
        $page = 1;
        if (isset($args['page'])) {
            $page = $args['page'];
        }
        $offset = ($page - 1) * 5;
        $press = Press::orderBy('created_at', 'DESC')->limit(5)->offset($offset)->get();

        return $this->container->view->render($response, 'press.twig', [
        'title' => 'Presse',
        'active' => 'press',
        'press' => $press,
        'page' => $page,
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
