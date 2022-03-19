<?php


namespace App\Controller\reservation;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomSeekerController extends AbstractController
{

    public function roomSeeker(Request $request): Response {


        return $this->render('reservation/list_rooms.html.twig', [
            'request' => $request
        ]);
    }
}