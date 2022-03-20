<?php


namespace App\Api\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index() {
        return $this->render('home.html.twig');
    }
}