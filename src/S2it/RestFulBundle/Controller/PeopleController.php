<?php

namespace S2it\RestFulBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use S2it\RestFulBundle\Entity\People;
use S2it\RestFulBundle\Entity\Phone;

class PeopleController extends FOSRestController
{
	/**
	 * @Rest\Get("/people")
	 */
    public function getAction()
    {
		$restresult = $this->getDoctrine()->getRepository('S2itRestFulBundle:People')->findAll();
		
		if ($restresult === null) {
			return new View("não existe pessoas", Response::HTTP_NOT_FOUND);
		}
		
		return $restresult;
    }
	
	/**
	 * @Rest\Get("/people/{id}")
	 */
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('S2itRestFullBundle:User')->find($id);
		
		if ($singleresult === null) {
			return new View("Pessoa não encontrada", Response::HTTP_NOT_FOUND);
		}
		
		return $singleresult;
	}
	
	/**
	 * @Rest\Post("/people")
	 */
	public function postAction(Request $request)
	{
		$people = $request->files->get('people');
		
        
		if(empty($people))
		{
			return new View("VALORES NULOS NÃO SÃO PERMITIDOS", Response::HTTP_NOT_ACCEPTABLE); 
		} 
        
		
		$page = file_get_contents( $people->getPathname() );
		$xml = simplexml_load_string($page);
		$json = json_encode($xml);
		$arrPeople = json_decode($json, TRUE);
		
		/*
		echo '<pre>';
		print_r($people);
		echo '</pre>';
		die;
		*/
		
		for($i=0; $i<count($arrPeople['person']); $i++)
		{
			$people = new People;
            $people->setPersonid($arrPeople['person'][$i]['personid']);
			$people->setPersonname($arrPeople['person'][$i]['personname']);
			
            $em = $this->getDoctrine()->getManager();
			$em->persist($people);
			$em->flush();
            $em->clear();
            
            //print_r($people->getId());die;
            /*
            foreach($arrPeople['person'][$i]['phones'] as $value)
            {
                $phone = new Phone;
                $phone->setPhone($value);
                $phone->setPeople($people->getId());
                //$em = $this->getDoctrine()->getManager();
                $em->persist($phone);
                
                
            }
            
            $em->flush();
            //$em->clear();
            */
		}
		
		return new View("Pessoas adicionadas com sucesso", Response::HTTP_OK);
	}
}
