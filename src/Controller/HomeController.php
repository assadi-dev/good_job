<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Entity\Upload;
use App\Entity\Candidature;
use App\Form\UploadFileType;
use App\Repository\OffresRepository;
use App\Repository\FavorisRepository;
use App\Repository\CandidatRepository;
use App\Repository\CandidatureRepository;
use App\Repository\RecruteurRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
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
    public function getOffres(OffresRepository $offresRepoD, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();

        $offres = $offresRepoD->createQueryBuilder('e')
            ->orderBy('e.create_at', 'DESC')
            ->getQuery()
            ->getArrayResult();

        $resultats = $serializer->serialize(
            $offres,
            "json",
            [
                "groups" => ["offre_general"]
            ]
        );

        return new JsonResponse($resultats, Response::HTTP_OK, [], true);


        //return $this->json(["code" => 200, "message" => "ok", "data" => $resultats], 200);
    }


    /**
     * @Route("/offre/{id}", name="offre")
     */

    public function offres(Offres $offres, Request $request, EntityManagerInterface $manager, CandidatRepository $candidatRepo, RecruteurRepository $recruteurRepo, CandidatureRepository $candidatureRepo)
    {

        /////Upload fichiers ////



        $upload = new Upload();
        $form = $this->createForm(UploadFileType::class, $upload);
        $form->handleRequest($request);
        $auteurId = $request->get("auteur");
        $offreId = $request->get("offre");

        $recruteur = $recruteurRepo->findOneBy(["id" => $auteurId]);






        $idCandidat = $this->idCandidat($candidatRepo);
        $cheminUpload = $this->getParameter('upload_directory');
        $dirname = strtolower($idCandidat->getPrenom() . "_" . $idCandidat->getNom());

        $dirnameFull  = $cheminUpload . "\\" . $dirname;




        if ($form->isSubmitted() && $form->isValid()) {

            $candidature = new Candidature();
            $candidature->setOffre($offres);
            $candidature->setName($offres->getName());
            $candidature->setRecruteur($recruteur);
            $candidature->setCandidat($idCandidat);
            $candidature->setReponse("Candidature en cours");
            $manager->persist($candidature);
            $manager->flush();

            $candidature = $candidatureRepo->findOneBy(["id" => $candidature->getId()]);

            $this->create_dir($cheminUpload, $dirname);


            $files = $form->get("fichiers")->getData();




            foreach ($files as $file) {
                $filename = md5(uniqid()) . "." . $file->guessExtension();
                $filenameOriginal = $file->getClientOriginalName();
                $file->move($dirnameFull,  $filename);


                $chemin = $dirname . "/" .  $filename;

                $type = $file->getClientMimeType();
                $extension = explode(".", $filename);
                $extension = trim($extension[1]);

                $upload = new Upload();
                $upload->setName($filenameOriginal);
                $upload->setType($extension);
                $upload->setCandidat($idCandidat);
                $upload->setChemin($chemin);
                $upload->setCandidature($candidature);
                $manager->persist($upload);
            }
            $manager->flush();

            return $this->redirectToRoute('espace_candidat');
        }




        return $this->render('home/offres.html.twig', [
            "offre" => $offres,
            'form' => $form->createView(),

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


    /**
     *Methode créer un dossier
     * 
     */
    public function create_dir($cheminUpload, $dirname)
    {

        if (!file_exists($cheminUpload . '/')) {
            mkdir($dirname, 0777, true);
        }
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
