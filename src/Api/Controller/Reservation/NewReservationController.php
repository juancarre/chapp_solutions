<?php


namespace App\Api\Controller\Reservation;


use App\Api\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class NewReservationController extends AbstractController
{
    public function newReservation(): Response {

        $form = $this->createForm(RoomType::class);
        $url = $this->generateUrl('room_seeker');


        return $this->render('Reservation/new.html.twig', [
            'form' => $form->createView(),
            'url' => $url
        ]);
    }
}