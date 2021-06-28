<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Offres;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use App\Entity\Candidature;
use App\Entity\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;





class AppFixtures extends Fixture
{

    private $encoder;

    public function  __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        /**
         * Génerer des donnée avec la librarie Fake
         *@param string $generator
         * contient la classe Fctory qui permet la creation des fausses données
         */

        $generator = Factory::create('fr_FR');
        /**
         * stockera les offres afin de pouvoir les reutilisé 
         * @param string $offres
         * @return array
         */
        $offres = [];

        /**
         * stockera les recruteurs afin de pouvoir les reutilisé 
         * @param string $recruteurs 
         * @return array
         */


        /**
         * création des tables qui seront utilisé ultérieurment lors de la generation des valeurs
         */

        $recruteurs = [];
        $candidats = [];

        $reponses = ["candidature en cours", "Refusé", "Accépté"];

        $villes = ["Paris", "Rennes", "Lille", "Montpelier", "Toulouse", "Marseille", "Nice", "Monaco"];

        $secteurs = ["Automobile", "Hotellerie / Réstauration", "Agroalimentaire", "Banque / Assurance", "BTP/Materiaux de construction", "Industrie pharmaceutique", "Electonique/Eléctricité", "Edition /Comunnication/Multimédia", "Services aux entreprises", "Informatique"];

        $postes = ["Développeur informatique", "Responsable Marketing", "Chargé de comunucation", "Chef de projet digitale", "Agent de maintenance"];

        $contrats = ["CDD", "CDI", "Stage", "Alternance"];


        $height = 480;
        $width = 640;

        //Générer Connection


        $connection = new Connection();
        $connection->setUsername("recruteur@gmail.com")
            ->setPassword($this->encoder->encodePassword($connection, "password"))
            ->setRoles("ROLE_RECRUTEUR")
            ->setCreatedAt($generator->dateTimeThisMonth('now', 'Europe/Paris'));
        $manager->persist($connection);


        $recruteur = new Recruteur();
        $recruteur->setNom($generator->lastName)
            ->setPrenom($generator->firstName)
            ->setPhone($generator->phoneNumber)
            ->setEmail("recruteur@gmail.com")
            ->setBirth($generator->dateTimeBetween('-30 years', '2000-12-30')->format('Y-m-d'))
            ->setEntreprise($generator->company)
            ->setCreateAt($generator->dateTimeThisMonth('now', 'Europe/Paris'))
            ->setAvatar($generator->imageUrl());
            



        $manager->persist($recruteur);
     

        $recruteurs[] = $recruteur;


        /**
         * Genearteur de candidat
         */


        $connection = new Connection();

        $connection->setUsername("candidat@gmail.com")
            ->setPassword($this->encoder->encodePassword($connection, "password"))
            ->setRoles("ROLE_CANDIDAT")
            ->setCreatedAt($generator->dateTimeThisMonth('now', 'Europe/Paris'));
        $manager->persist($connection);


        $candidat = new Candidat();

        $candidat->setAvatar($generator->imageUrl())
            ->setNom($generator->lastName)
            ->setPrenom($generator->firstName)
            ->setBirth($generator->dateTimeBetween('-30 years', '2000-12-30')->format('Y-m-d'))
            ->setEmail('candidat@gmail.com')
            ->setPhone($generator->phoneNumber)
            ->setCreatedAt($generator->dateTimeThisMonth('now', 'Europe/Paris'));



        $manager->persist($candidat);

        $candidats[] = $candidat;







        for ($i = 0; $i < 50; $i++) {
            $offre = new Offres();






            $offre->setName("Offre numéro " . $i)
                ->setEntreprise($generator->company)
                ->setPoste($generator->randomElement($postes))
                ->setSecteur($generator->randomElement($secteurs))
                ->setVille($generator->randomElement(($villes)))
                ->setContrat($generator->randomElement($contrats))
                ->setDisponible($generator->dateTimeThisMonth('now')->format('Y-m-d'))
                ->setLogo($generator->imageUrl())
                ->setCreateAt($generator->dateTimeThisMonth('now'));
            $manager->persist($offre);
            $offres[] = $offre;
        }



        for ($c = 0; $c < 10; $c++) {
            $candidature = new Candidature();
            $candidature->setOffre($generator->randomElement($offres))
                ->setName("candidature numéro " . $c)
                ->setRecruteur($generator->randomElement($recruteurs))
                ->setReponse($generator->randomElement(($reponses)))
                ->setCandidat($generator->randomElement($candidats));
            $manager->persist($candidature);
        }






        $manager->flush();

        // $product = new Product();
        // $manager->persist($product);

        //$manager->flush();
    }
}
