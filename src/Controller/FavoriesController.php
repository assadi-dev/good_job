<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Repository\FavorisRepository;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FavoriesController extends AbstractController
{
    /**
     * @Route("/api/favories/", name="favories", methods={"GET"})
     */
    public function get_favories(FavorisRepository $favoriRepo, CandidatRepository $candidatRepo, SerializerInterface $serializer): Response
    {
        $candidat = $this->idCandidat($candidatRepo);

        $favoris = $favoriRepo->findBy(["candidat" => $candidat]);


        $result = $serializer->serialize(
            $favoris,
            "json",
            [
                "groups" => ["simpleFavoris"]
            ]
        );

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/favories/", name="add_favories", methods={"POST"})
     */
    public function add_favories(FavorisRepository $favoriRepo, CandidatRepository $candidatRepo, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager): Response
    {
        $candidat = $this->idCandidat($candidatRepo);

        $data = json_decode($request->getContent(), true);

        $favories = $serializer->deserialize($data, Favoris::class, "json");
        $favories->setCandidat($candidat);

        $manager->persist($favories);
        $manager->flush();



        return new JsonResponse(
            "L'offre " . $favories->getName() . " à été ajouté en dans la liste des favories",
            Response::HTTP_CREATED,
            [],
            true
        );
    }



    /**
     * @Route("/api/favories/{id}", name="delete_favories", methods={"DELETE"})
     * 
     */
    public function delete_favories(Favoris $favoris, EntityManagerInterface $manager): Response
    {


        $manager->remove($favoris);
        $manager->flush();



        return new JsonResponse(
            "L'offre " . $favoris->getOffre()->getName() . " à été retiré en de la liste des favories",
            Response::HTTP_OK,
            [],
            true
        );
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
