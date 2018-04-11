<?php

namespace AnimalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AnimalBundle\Form\MascotesType;
use AnimalBundle\Entity\Mascotes;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function createAction()
    {
        $pug = new \AnimalBundle\Entity\Pug;
        $pug->setNom("Vesper");
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($pug);
        $flush = $em->flush();
        
        if($flush == null){
            echo "Creat correctament";
        }
        die();
        
        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $pugs_repo = $em->getRepository("AnimalBundle:Pug");
        $pug = $pugs_repo->find($id);
        
        $em->remove($pug);
        $flush = $em->flush();
        
        if($flush == null){
            echo "Esborrat correctament";
        }
        die();

        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function readAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $pugs_repo = $em->getRepository("AnimalBundle:Pug");
        $pug = $pugs_repo->find($id);
        
        echo $pug->getId()." - ".$pug->getNom();
        die();
        
        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function updateAction($id,$nom)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $pugs_repo = $em->getRepository("AnimalBundle:Pug");
        $pug = $pugs_repo->find($id);
        
        $pug->setNom($nom);
        
        $em->persist($pug);
        $flush = $em->flush();
        
        if($flush == null){
            echo "Actualitzat correctament";
        }
        die();
        
        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $pugs_repo = $em->getRepository("AnimalBundle:Pug");
        $pugs = $pugs_repo->findAll();
        
        foreach ($pugs as $pug) {
            echo $pug->getNom()."<br>";
        }
        die();
//        return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function dqlAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $pugs_repo = $em->getRepository("AnimalBundle:Pug");
        $pugs = $pugs_repo->totsAll();
        
        foreach ($pugs as $pug) {
            echo $pug['nom']."<br>";
        }
        die();
        
        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function sqlAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();
        
        $sql = "SELECT * FROM pug";
        
        $stmt = $db->prepare($sql);
        $params = array();
        $stmt->execute($params);
        
        $pugs = $stmt->fetchAll();
        
        foreach ($pugs as $pug) {
            echo $pug['nom']."<br>";
        }
        die();
        
        //return $this->render('AnimalBundle:Default:index.html.twig');
    }
    
    public function formAction(Request $request){
        $mascota = new Mascotes();
        $form = $this->createForm(MascotesType::class,$mascota);
        
        $form->handleRequest($request);
        if($form->isValid()){
            $status = "Formulari OK";
            $data = array(
              'nom' => $form->get("nom")->getData()  
            );
        } else{
            $status = null;
            $data = null;
        }
        
        return $this->render('AnimalBundle:Default:form.html.twig', array(
            'form' => $form->createView(),
            'status' => $status,
            'data' => $data
        ));
    }
    
}
