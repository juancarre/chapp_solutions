<?php


namespace App\Api\Controller\Reservation;


use App\Domain\Collections\RoomCollection;
use App\Domain\Service\RoomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomSeekerController extends AbstractController
{

    public function roomSeeker(Request $request, RoomService $roomService): Response
    {
        $room = $request->request->get('room');
        $roomCollection = $roomService->availablesRooms(
            new \DateTime($room['entry_date']),
            new \DateTime($room['exit_date']),
            $room['guests']
        );

        return $this->render('reservation/list_rooms.html.twig', [
            'request' => $request,
            'roomCollection' => $roomCollection
        ]);
    }
}