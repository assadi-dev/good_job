<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadFileType;
use App\Repository\OffresRepository;
use App\Repository\UploadRepository;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatureController extends AbstractController
{
    /**
     * @Route("/candidature/", name="candidature")
     */
    public function index(Request $request, EntityManagerInterface $manager, CandidatRepository $candidatRepo, OffresRepository $offreRepo): Response
    {
        /////Upload fichiers ////



        $upload = new Upload();
        $form = $this->createForm(UploadFileType::class, $upload);
        $form->handleRequest($request);
        $auteurId = $request->get("auteur");
        $offreId = $request->get("offre");

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
     * @Route("/candidature/uploads",name="get_upload" , methods={"GET"})
     */

    public function get_uploadsCandidatures(UploadRepository $uploadRepo, SerializerInterface $serializer): Response
    {
        $uploads = $uploadRepo->findAll();
        $resultat = $serializer->serialize(
            $uploads,
            "json",
            [
                "groups" => ["uploadSimple"]
            ]
        );

        return new JsonResponse($resultat, Response::HTTP_OK, [], true);
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
     *Methode créer un dossier
     * 
     */
    public function create_dir($cheminUpload, $dirname)
    {

        if (!file_exists($cheminUpload . '/')) {
            mkdir($dirname, 0777, true);
        }
    }
}
