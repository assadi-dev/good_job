<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Repository\OffresRepository;
use App\Repository\FavorisRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(OffresRepository $offresRepo): Response
    {



        $offres = $offresRepo->createQueryBuilder('e')
            ->orderBy('e.create_at', 'DESC')
            ->getQuery()
            ->getArrayResult();

        $offreCarousel = array_slice($offres, 10);


        return $this->render('home/index.html.twig', [
            "offres" => $offres,
            "offresCarousel" => $offreCarousel
        ]);
    }


    /**
     * @Route("/api/offres", name = "listes_offres",methods={"GET"})
     */
    public function getOffres(OffresRepository $offresRepoD): Response
    {
        $user = $this->getUser();

        $offres = $offresRepoD->createQueryBuilder('e')
            ->orderBy('e.create_at', 'DESC')
            ->getQuery()
            ->getArrayResult();

        return $this->json(["code" => 200, "message" => "ok", "data" => $offres], 200);
    }


    /**
     * @Route("/offre/{id}", name="offre")
     */

    public function offres(Offres $offres)
    {
        return $this->render('home/offres.html.twig', [
            "offre" => $offres

        ]);
    }



    /**
     * @Route("/favorie/{id}/addFavorie", name="favorie_add")
     * Permet d'ajouter l'offre dans les favoris de l'utilisateur
     */

    public function favoris(Offres $offres, FavorisRepository $favorisRepo, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        //si l'utilisateur n'est pas connecté
        if (!$user) return $this->json([
            'code' => 403,
            'message' => 'unauthorize'
        ], 403);

        return $this->json(["code" => 200, "message" => "Offre ajouté dans le favories"], 200);
    }

    /**
     * @Route("/login" , name = "login")
     */

    public function login(AuthenticationUtils $auth)
    {
        return $this->render('home/login_form.html.twig', [
            "lastUsername" => $auth->getLastUsername(),
            "error" => $auth->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name = "logout")
     */

    public function logout()
    {
    }
}
