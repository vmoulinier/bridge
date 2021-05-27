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

        //C D H S NT
        $deals = [
            $deal1 = [
                'actions' => [
                    'D1',
                    'C2',
                    'H4',
                    'NT4',
                    'P',
                    'P',
                    'P',
                ]
            ],
            $deal2 = [
                'actions' => [
                    'H1',
                    'NT1',
                    'D2',
                    'NT5',
                    'P',
                    'P',
                    'P',
                ]
            ],
            $deal3 = [
                'actions' => [
                    'H1',
                    'NT1',
                    'D2',
                    'NT5',
                    'P',
                    'P',
                    'P',
                ]
            ],
            $deal4 = [
                'actions' => [
                    'H1',
                    'NT1',
                    'D2',
                    'NT5',
                    'P',
                    'P',
                    'P',
                ]
            ],
        ];

        return new Response(json_encode($deals, JSON_HEX_QUOT));

        $lastPlays = [];
        $result = [];

        foreach ($deals as $key => $deal) {
            $actions = $deal['actions'];

            foreach ($actions as $key => $action) {
                if ('P' !== $action && 0 < $key) {
                    $currentAction = $this->separeNumeric($action);
                    $previousAction = $this->separeNumeric($actions[$key - 1]);
                    //TODO verif si le coup est valable par rapport au précédent
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
                        $str = 'Les joueurs 1 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 1) {
                        $str = 'Les joueurs 2 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 2) {
                        $str = 'Les joueurs 3 a joué en dernier le contrat : ' . $value;
                    }
                    if ($key === 3) {
                        $str = 'Les joueurs 4 a joué en dernier le contrat : ' . $value;
                    }
                    $result[] = $str;
                }
            }

        }

        return new Response(json_encode($result, JSON_HEX_QUOT));
    }

    private static function separeNumeric($text)
    {
        $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $text);
        return $arr;
    }
}
