<?php

namespace App\Controllers;

use App\Models\Guestbook;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class GuestbookController extends Controller
{
    public function getList($request, $response, $args)
    {
        $page = 1;
        $perPage = 20;
        if (isset($args['page'])) {
            $page = $args['page'];
        }
        $offset = ($page - 1) * $perPage;
        //Alle Eintraege holen
        $guestbook = Guestbook::orderBy('created_at', 'DESC')->limit($perPage)->offset($offset)->get();

        return $this->container->view->render($response, 'guestbook.twig', [
          'title' => 'Gästebuch',
          'active' => 'guestbook',
          'guestbook' => $guestbook,
          'page' => $page,
      ]);
    }

    public function postNewEntry($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email(),
            'text' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->container->flash->addMessage('error', 'Fehler bei der Erstellung!');

            return $response->withRedirect($this->container->router->pathFor('guestbook'));
        }

            // Eintrag anlegen
            $entry = Guestbook::create([
          'name' => $request->getParam('name'),
          'email' => $request->getParam('email'),
          'text' => $request->getParam('text'),
        ]);

        $this->container->flash->addMessage('info', 'Eintrag erfolgreich hinzugefügt!');

        return $response->withRedirect($this->container->router->pathFor('guestbook'));
    }
}
