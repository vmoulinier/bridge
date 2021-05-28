<?php

namespace App\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{    
    /**
     * @Route("/index", name="index" ,methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $data = $request->getContent();
        $deals = json_decode($data, true);

        $lastPlays = [];
        $result = [];
        $cases = ['P'];

        for ($i=1;$i<=7;$i++) {
            $cases[] = 'C'.$i;
            $cases[] = 'D'.$i;
            $cases[] = 'H'.$i;
            $cases[] = 'S'.$i;
            $cases[] = 'NT'.$i;
        }

        foreach ($deals as $key => $deal) {
            $actions = $deal['actions'];

            foreach ($actions as $key => $action) {
                if (!in_array($action, $cases)) {
                    throw new Exception("L'action n'existe pas !");
                }
                if ('P' !== $action && 0 < $key) {
                    $keyCurrentAction = array_search($action, $cases);
                    $keyPreviousAction = array_search($actions[$key-1], $cases);

                    if ($keyPreviousAction > $keyCurrentAction) {
                        throw new Exception("Le contrat proposé ne peut pas être plus faible que le précédent !");
                    }
                }
                if ('P' === $action && 'P' === $actions[$key+1] && 'P' === $actions[$key + 2]) {
                    $previousKey = $key - 1;
                    $lastContract = $actions[$previousKey];
                    $lastPlays[] = [$previousKey => $lastContract];
                    break;
                }
            }

            foreach ($lastPlays as $lastPlay) {
                foreach ($lastPlay as $key => $value) {
                    if ($key === 0) {
                        $str = 'Le joueur 1 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 1) {
                        $str = 'Le joueur 2 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 2) {
                        $str = 'Le joueur 3 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 3) {
                        $str = 'Le joueur 4 a joué en dernier le contrat : ' . $value;
                    }
                    $result[] = $str;
                }
            }

        }

        return new Response(json_encode($result, JSON_HEX_QUOT));
    }
}
