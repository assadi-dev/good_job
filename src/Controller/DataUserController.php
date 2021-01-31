<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Connection;
use App\Repository\CandidatRepository;
use App\Repository\ConnectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ConnectionRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/api/candidat/profile/{id}", name="edit_candidat", methods={"PUT"})
     */
    public function edit_candidat(Request $request, ConnectionRepository $conectionRepo, Candidat $candidat, SerializerInterface $serializer, EntityManagerInterface $manager): Response
    {

        $data = $request->getContent();
        $user = $this->getUser();

        $candidat = $serializer->deserialize(
            $data,
            Candidat::class,
            'json',
            ['object_to_populate' => $candidat],
            $candidat,

        );

        $userConnect = $conectionRepo->findOneBy(['id' => $user]);
        $candidatEmail = $candidat->getEmail();
        $userConnect->setUsername($candidatEmail);

        $manager->persist($candidat);
        $manager->flush();

        return new JsonResponse("Le profil du candidat à été modifier", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/candidat/connection/{username}", name="edit_password", methods={"PUT"})
     */
    public function edit_password(Request $request, Connection $connection, SerializerInterface $serializer, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {

        $data = $request->getContent();

        $dataUser = json_decode($data, true);



        if ($dataUser["password"] != $dataUser["confirmPassword"]) {

            return new JsonResponse("Le mode passe saisie ne sont pas similaire", Response::HTTP_UNAUTHORIZED, [], true);
        }

        $connection = $serializer->deserialize(
            $data,
            Connection::class,
            'json',
            ['object_to_populate' => $connection],
            $connection,

        );

        $password = $encoder->encodePassword($connection, $connection->getPassword());
        $connection->setPassword($password);


        $manager->persist($connection);
        $manager->flush();

        return new JsonResponse("Le Mot de passe du candidat à été mise à jour", Response::HTTP_OK, [], true);
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
