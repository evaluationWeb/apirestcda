<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: 'GET')]
    public function test()
    {
        $tab = ["nom" => "Test", "Prenom" => "Test"];
        return $this->json(
            $tab,
            200,
            [
                'Accept-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json'
            ]
        );
    }
}
