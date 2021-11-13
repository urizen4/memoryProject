<?php

namespace App\Controller;

header("Access-Control-Allow-Origin: *");
 header('Access-Control-Allow-Credentials: true');
 header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
 header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 header("Content-Type: application/json; charset=UTF-8");
 
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class UniversController extends AbstractController
{
    /**
     * @Route("/univers/utilisateur", name="univers_utilisateur",methods={"GET"})
     */
    public function index(UtilisateurRepository $repo,Request $request,SerializerInterface $si)
    {
        $ListeU = $repo->findAll();
          return  $this->json($ListeU,200,[]);
         
    } 

     /**
     * @Route("/univers/recherche", name="univers_user",methods={"GET","POST"})
     */
    public function recherche(UtilisateurRepository $repo,Request $request,SerializerInterface $si)
    {
          $postdata = file_get_contents("php://input");
          // $postdata=$request->getContent();
          try {
          $Prenom=$si->deserialize($postdata,Utilisateur::class,'json');
        $data2=$Prenom->getPrenom();
         if ($data2!=null) {
           $ListeU = $repo->findBy(['prenom'=>$data2]);
           return  $this->json($ListeU,201,[]);
        }
        } 
        catch (NotEncodableValueException $e) {
          return  $this->json([
            'statut'=> 400,
            'message'=>"Erreur de lecture du json"
          ],400);  
        }
         
       
         
    } 


    /**
     * @Route("/univers/inscription", name="univers_inscription",methods={"POST"})
     */
    public function Subscibre(Request $request, SerializerInterface $serializerInterface,EntityManagerInterface $em)
    {
        $data = $request->getContent();
        $Inscrit= $serializerInterface->deserialize($data,Utilisateur::class,'json');
        $em->persist($Inscrit);
        $em->flush();
        return $this->json($Inscrit,201,[]);
    }
  
}
