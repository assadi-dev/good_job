<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\Candidat;
use App\Form\UploadFileType;
use App\Repository\OffresRepository;
use App\Repository\UploadRepository;
use App\Repository\FavorisRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat/login", name="login_candidat")
     */
    public function login(AuthenticationUtils $auth): Response
    {
        return $this->render('candidat/loginForm.html.twig', [
            "lastUsername" => $auth->getLastUsername(),
            "error" => $auth->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/espace/candidat", name="espace_candidat")
     * 
     */
    public function epspace(CandidatureRepository $candidatureRepo, CandidatRepository $candidatRepo, OffresRepository $offreRepo, FavorisRepository $favorisRepo, UploadRepository $uploadRepo, Request $request, EntityManagerInterface $manager)
    {
        /**
         * Retourne les donnes de l'utilisateur connecté
         * @var $user
         * @return array
         */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute("login");
        }


        $userEmail = $user->getUsername();

        $userCandidat = $candidatRepo->findOneBy(["email" => $userEmail]);

        $userCandidature = $candidatureRepo->findBy(["candidat" => $userCandidat]);

        /**
         * Retourne un array qui contiendra le infos necessaire pour afficher dans le tableaux des candidatures cotés client
         * @var $finalArray
         * @return array
         */

        $finalArray = [];

        foreach ($userCandidature as $elements) {

            $offreId = $elements->getOffre();

            $offres = $offreRepo->findBy(["id" => $offreId]);



            $arrayOffre = $offres[0];

            if ($offreId->getId() == $arrayOffre->getId()) {
                array_push($finalArray, array("idOffre" => $arrayOffre->getId(), "candidature" => $elements->getName(), "offre" => $arrayOffre->getName(), "disponible" => $arrayOffre->getDisponible(), "reponse" => $elements->getReponse()));
            }
        }




        /**
         * recuperation des offres en fonctions des favoris
         */



        $favoris = $favorisRepo->findBy(["candidat" => $userCandidat]);

        $offresFavoris = [];

        function comparaison($offreIdFavori, $offres)
        {
            return $offreIdFavori == $offres;
        }

        foreach ($favoris as $elements) {
            $offreIdFavori = $elements->getOffre();
            $offreIdFavori = $offreIdFavori->getId();

            $offres = $offreRepo->findBy(["id" => $offreIdFavori]);

            array_push($offresFavoris, $offres);
        }




        $nb = count($offresFavoris);
        $offresFavorisFinal = [];
        for ($i = 0; $i < $nb; $i++) {


            array_push($offresFavorisFinal, $offresFavoris[$i][0]);
        }






        /////Upload fichiers ////



        $upload = new Upload();
        $form = $this->createForm(UploadFileType::class, $upload);
        $form->handleRequest($request);

        $idCandidat = $this->idCandidat($candidatRepo);
        $cheminUpload = $this->getParameter('upload_directory');
        $dirname = strtolower($idCandidat->getPrenom() . "_" . $idCandidat->getNom());

        $dirnameFull  = $cheminUpload . "\\" . $dirname;




        if ($form->isSubmitted() && $form->isValid()) {


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
                $upload->setName($filename);
                $upload->setType($extension);
                $upload->setCandidat($idCandidat);
                $upload->setChemin($chemin);
                $manager->persist($upload);
            }
            $manager->flush();

            return $this->redirectToRoute('espace_candidat');
        }


        $uploadsFiles = $this->filesCandidat($uploadRepo, $idCandidat);






        return $this->render('candidat/espace.html.twig', [
            'candidatures' =>  $finalArray,
            'candidats' => $userCandidat,
            'offres' => $offresFavorisFinal,
            'form' => $form->createView(),
            'uploads' =>  $uploadsFiles,
        ]);
    }
    /**
     *Fonction qui récupere les fichiers uploadé par le candidat 
     * @param var $upload Repo de l'uplooad
     * @param var $candidat repod du candidat
     * @
     */

    public function filesCandidat($uploadRepo, $candidat)
    {


        $upload = $uploadRepo->findBy(["candidat" => $candidat]);

        return $upload;
    }


    /**
     *fonction créer un dossier
     * 
     */
    public function create_dir($cheminUpload, $dirname)
    {

        if (!file_exists($cheminUpload . '/')) {
            mkdir($dirname, 0777, true);
        }
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
     * action supprimmer un fichier
     * @Route("/api/upload/{id}" , name="delete_file",methods={"DELETE"})
     */
    public function delete_file(Upload $upload, Request $request, EntityManagerInterface $manager)
    {
        $data = json_decode($request->getContent());



        $manager->remove($upload);
        $manager->flush();
        $nom = $upload->getChemin();
        $path = $this->getParameter('upload_directory') . "/" . $nom;
        unlink($path);
        return $this->json(["success" => 1, "message" => "le fichier " . $upload->getName() . " à été supprimé"], 200);
    }

    /**
     * api upload fichier
     * @Route("/api/upload/", name = "add_file",methods={"POST"})
     */

    public function add_file(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, CandidatRepository $candidatRepo)
    {
        $data = json_decode($request->getContent(), true);



        $idCandidat = $this->idCandidat($candidatRepo);
        $rootPath = $this->getParameter('upload_directory');
        $dirname = strtolower($idCandidat->getPrenom() . "_" . $idCandidat->getNom());
        $dirnameFull  =  $rootPath . "\\" . $dirname;

        // $this->create_dir($rootPath, $dirname);
        $files = $data["data"];

        //dump($files);



        foreach ($files as $file) {
            // dump($file["extension"]);
            $filename = md5(uniqid()) . "." . $file["extension"];
            $filenameOriginal = $file["nom"];
            // $file->move($dirnameFull,  $filename);


            $chemin = $dirname . "/" .  $filename;
            $extension = $file["extension"];

            $upload = new Upload();
            $upload->setName($filename);
            $upload->setType($extension);
            $upload->setCandidat($idCandidat);
            $upload->setChemin($chemin);
            $manager->persist($upload);
        }
        //exit;



        $manager->flush();

        return $this->json(["success" => 1, "message" => "fichier uploadé"], 200);
    }


    /**
     * Api récuperation des fichier uploadé par le candidat
     * @Route("/api/upload" , name="get_uploads",methods={"GET"})
     */
    public function get_uploads(UploadRepository $uploadRepo, SerializerInterface $serializer, CandidatRepository $candidatRepo)
    {
        $candidat = $this->idCandidat($candidatRepo);
        $uploadsFiles = $this->filesCandidat($uploadRepo, $candidat);

        $resultat = $serializer->serialize(
            $uploadsFiles,
            "json",
            [
                "groups" => ["uploadSimple"]
            ]


        );



        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/candidat/logout" , name="logout_candidat")
     */

    public function logout()
    {
    }
}
