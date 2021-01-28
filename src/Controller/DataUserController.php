<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class DataUserController extends AbstractController
{
    /**
     * @Route("/api/candidat/profile", name="get_candidat", methods={"GET"})
     */
    public function get_candidat(CandidatRepository $candidatRepo, SerializerInterface $serializer): Response
    {
        $candidat = $this->idCandidat($candidatRepo);

        $resultat = $serializer->serialize(
            $candidat,
            "json",
            [
                "groups" => ["simpleCandidatures"]
            ]
        );

        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }


    /**
     * fonction qui retourne l'Id du candidat 
     * 
     */
    public function idCandidat($repo)
    {
        $user = $this->getUser();
        $username = $user->getUsername();

        $candidat = $repo->findOneBy(["email" => $username]);

        return $candidat;
    }
}
