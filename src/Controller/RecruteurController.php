<?php

namespace App\Controller;

use DateTime;
use App\Entity\Offres;
use DateTimeInterface;
use App\Entity\Recruteur;
use App\Entity\Connection;
use App\Entity\Candidature;
use App\Repository\OffresRepository;
use App\Repository\RecruteurRepository;
use App\Repository\ConnectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecruteurController extends AbstractController
{


    /**
     * @Route("/recruteur/login", name = "login_recruteur")
     */

    public function login(AuthenticationUtils $auth)
    {


        return $this->render('recruteur/login_form.html.twig', [
            "lastUsername" => $auth->getLastUsername(),
            "error" => $auth->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/espace/recruteur", name="espace_recruteur")
     */
    public function espace(): Response
    {
        return $this->render('recruteur/index.html.twig', [
            'controller_name' => 'RecruteurController',
        ]);
    }


    /**
     * @Route("/recruteur/logout", name = "logout_recruteur")
     */

    public function logout()
    {
    }


    /**
     * @Route("/espace/recruteur/offres", name = "offres_recruteur")
     */
    public function show_offres(): Response
    {
        return $this->render('recruteur/offres.html.twig', [
            'controller_name' => 'RecruteurController',
        ]);
    }

    /**
     * @Route("/espace/recruteur/profile", name = "info_recruteur")
     */
    public function show_recruteur(): Response
    {
        return $this->render('recruteur/info_recruteur.html.twig', []);
    }


    /**
     * @Route("/espace/recruteur/candidatures", name = "candidature_recruteur")
     */
    public function show_candidature(): Response
    {
        return $this->render('recruteur/candidatures.html.twig', [
            'controller_name' => 'RecruteurController',
        ]);
    }

    /**
     * Api afficher les offres creer par le recruteur
     * @Route("/api/recruteur/offres", name = "get_offres_recruteur", methods={"GET"})
     */
    public function get_offres(OffresRepository $offresRepo, RecruteurRepository $recruteuRepo, SerializerInterface $serializer): Response
    {
        $recruteur = $this->idRecruteur($recruteuRepo);
        $offres = $offresRepo->findBy(["auteur" => $recruteur]);
        $resultat = $serializer->serialize(
            $offres,
            "json",
            [
                "groups" => ["simpleOffres"]
            ]
        );



        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }

    /**
     * Api afficher les offres creer par le recruteur
     * @Route("/api/recruteur/offres/{id}", name = "get_offres_recruteur_single", methods={"GET"})
     */
    public function get_offres_single(Offres $offres, SerializerInterface $serializer): Response
    {


        $resultat = $serializer->serialize(
            $offres,
            "json",
            [
                "groups" => ["simpleOffres"]
            ]
        );



        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }

    /**
     * Api Modifier l'offres creer par le recruteur
     * @Route("/api/recruteur/offres/edit/{id}", name = "edit_offres_recruteur", methods={"PUT"})
     */
    public function edit_offres(Offres $offres, EntityManagerInterface $manager, Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $offres = $serializer->deserialize(
            $data,
            Offres::class,
            'json',
            ['object_to_populate' => $offres],
            $offres,

        );


        $manager->persist($offres);
        $manager->flush();



        return new JsonResponse(
            "L'offre à été modifier",
            Response::HTTP_OK,
            //["location" => "api/commande/".$commande->getId()]
            ["location" => $this->generateUrl(
                "get_offres_recruteur_single",
                ["id" => $offres->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            )],
            true
        );
    }


    /**
     * @Route("/api/recruteur/offres/create/", name = "create_offres_recruteur", methods={"POST"})
     */
    public function create_offres(EntityManagerInterface $manager, Request $request, SerializerInterface $serializer, RecruteurRepository $recruteuRepo): Response
    {
        $idRecruteur = $this->idRecruteur($recruteuRepo);
        $today = new DateTime("now");
        $data = $request->getContent();
        $offres = $serializer->deserialize($data, Offres::class, "json");
        $offres->setAuteur($idRecruteur);
        $offres->setLogo("https://lorempixel.com/640/480/?27315");
        $offres->setCreateAt($today);
        $manager->persist($offres);
        $manager->flush();

        return new JsonResponse(
            "L'offre à été crée ",
            Response::HTTP_CREATED,
            //["location" => "api/commande/".$commande->getId()]
            ["location" => $this->generateUrl(
                "get_offres_recruteur_single",
                ["id" => $offres->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            )],
            true
        );
    }


    /**
     * @Route("/api/recruteur/offres/delete/{id}", name = "delete_offres_recruteur", methods={"DELETE"})
     */
    public function delete_offres(Offres $offres, EntityManagerInterface $manager, Request $request, SerializerInterface $serializer): Response
    {
        $manager->remove($offres);
        $manager->flush();

        return new JsonResponse("L'offre à été Supprimé ", Response::HTTP_OK, [], true);
    }


    /**
     * Méthode qui retourne l'Id du recruteur connecté
     * 
     */
    public function idRecruteur($repo)
    {
        $user = $this->getUser();
        $username = $user->getUsername();

        $recruteur = $repo->findOneBy(["email" => $username]);

        return $recruteur;
    }


    /**
     * Api afficher les candidatures creer par les candidats
     * @Route("/api/recruteur/candidatures", name = "get_candidatures_recruteur", methods={"GET"})
     */
    public function get_candidatures(CandidatureRepository $candidaturesRepo, RecruteurRepository $recruteuRepo, SerializerInterface $serializer): Response
    {
        $recruteur = $this->idRecruteur($recruteuRepo);
        $candidature = $candidaturesRepo->findBy(["recruteur" => $recruteur]);
        $resultat = $serializer->serialize(
            $candidature,
            "json",
            [
                "groups" => ["simpleCandidatures"]
            ]
        );

        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }




    /**
     * Api afficher les candidatures creer par les candidats
     * @Route("/api/recruteur/candidatures/edit/{id}", name = "edit_candidatures_recruteur", methods={"PUT"})
     */
    public function edit_candidatures(Candidature $candidature, SerializerInterface $serializer, EntityManagerInterface $manager, Request $request): Response
    {

        $data = $request->getContent();
        $resultat = $serializer->deserialize(
            $data,
            Candidature::class,
            'json',
            ['object_to_populate' => $candidature],
            $candidature,

        );


        $manager->persist($resultat);
        $manager->flush();


        return new JsonResponse("La candidature à été mise à jour", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/recruteur/profile" , name="get_recruteur" , methods={"GET"})
     */
    public function get_recruteur(SerializerInterface $serializer, RecruteurRepository $recruteurRepo): Response
    {
        $recruteur = $this->idRecruteur($recruteurRepo);

        $resultat = $serializer->serialize(
            $recruteur,
            "json",
            [
                "groups" => ["simpleRecruteur"]
            ]
        );

        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }


    /**
     * Api afficher les candidatures creer par les candidats
     * @Route("/api/recruteur/profile/{id}", name = "edit_recruteur", methods={"PUT"})
     */
    public function edit_recruteur(Recruteur $recruteur, ConnectionRepository $conectionRepo, SerializerInterface $serializer, EntityManagerInterface $manager, Request $request): Response
    {

        $data = $request->getContent();
        $user = $this->getUser();
        $resultat = $serializer->deserialize(
            $data,
            Recruteur::class,
            'json',
            ['object_to_populate' => $recruteur],
            $recruteur,

        );
        $userConnect = $conectionRepo->findOneBy(['id' => $user]);
        $recruteurEmail = $resultat->getEmail();
        $userConnect->setUsername($recruteurEmail);

        $manager->persist($resultat);
        $manager->flush();


        return new JsonResponse("La profile à été mise à jour", Response::HTTP_OK, [], true);
    }
}
