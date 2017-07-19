<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MapType;
use AppBundle\Form\MapTypeType;

/**
 * MapType controller.
 *
 * @Route("/map_type")
 */
class MapTypeController extends Controller
{
    /**
     * Lists all MapType entities.
     *
     * @Route("/", name="map_type_index")
     * @Method("GET")
     * @Template()
	 * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(MapType::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $mapTypes = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'mapTypes' => $mapTypes,
        );
    }
    /**
     * Search for MapType entities.
	 *
	 * To make this work, add a method like this one to the 
	 * AppBundle:MapType repository. Replace the fieldName with
	 * something appropriate, and adjust the generated search.html.twig
	 * template.
	 * 
     //    public function searchQuery($q) {
     //        $qb = $this->createQueryBuilder('e');
     //        $qb->where("e.fieldName like '%$q%'");
     //        return $qb->getQuery();
     //    }
	 *
     *
     * @Route("/search", name="map_type_search")
     * @Method("GET")
     * @Template()
	 * @param Request $request
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('AppBundle:MapType');
		$q = $request->query->get('q');
		if($q) {
	        $query = $repo->searchQuery($q);
			$paginator = $this->get('knp_paginator');
			$mapTypes = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
		} else {
			$mapTypes = array();
		}

        return array(
            'mapTypes' => $mapTypes,
			'q' => $q,
        );
    }
    /**
     * Full text search for MapType entities.
	 *
	 * To make this work, add a method like this one to the 
	 * AppBundle:MapType repository. Replace the fieldName with
	 * something appropriate, and adjust the generated fulltext.html.twig
	 * template.
	 * 
	//    public function fulltextQuery($q) {
	//        $qb = $this->createQueryBuilder('e');
	//        $qb->addSelect("MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') as score");
	//        $qb->add('where', "MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') > 0.5");
	//        $qb->orderBy('score', 'desc');
	//        $qb->setParameter('q', $q);
	//        return $qb->getQuery();
	//    }	 
	 * 
	 * Requires a MatchAgainst function be added to doctrine, and appropriate
	 * fulltext indexes on your MapType entity.
	 *     ORM\Index(name="alias_name_idx",columns="name", flags={"fulltext"})
	 *
     *
     * @Route("/fulltext", name="map_type_fulltext")
     * @Method("GET")
     * @Template()
	 * @param Request $request
	 * @return array
     */
    public function fulltextAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('AppBundle:MapType');
		$q = $request->query->get('q');
		if($q) {
	        $query = $repo->fulltextQuery($q);
			$paginator = $this->get('knp_paginator');
			$mapTypes = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
		} else {
			$mapTypes = array();
		}

        return array(
            'mapTypes' => $mapTypes,
			'q' => $q,
        );
    }

    /**
     * Creates a new MapType entity.
     *
     * @Route("/new", name="map_type_new")
     * @Method({"GET", "POST"})
     * @Template()
	 * @param Request $request
     */
    public function newAction(Request $request)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $mapType = new MapType();
        $form = $this->createForm(MapTypeType::class, $mapType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mapType);
            $em->flush();

            $this->addFlash('success', 'The new mapType was created.');
            return $this->redirectToRoute('map_type_show', array('id' => $mapType->getId()));
        }

        return array(
            'mapType' => $mapType,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a MapType entity.
     *
     * @Route("/{id}", name="map_type_show")
     * @Method("GET")
     * @Template()
	 * @param MapType $mapType
     */
    public function showAction(MapType $mapType)
    {

        return array(
            'mapType' => $mapType,
        );
    }

    /**
     * Displays a form to edit an existing MapType entity.
     *
     * @Route("/{id}/edit", name="map_type_edit")
     * @Method({"GET", "POST"})
     * @Template()
	 * @param Request $request
	 * @param MapType $mapType
     */
    public function editAction(Request $request, MapType $mapType)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $editForm = $this->createForm(MapTypeType::class, $mapType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'The mapType has been updated.');
            return $this->redirectToRoute('map_type_show', array('id' => $mapType->getId()));
        }

        return array(
            'mapType' => $mapType,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a MapType entity.
     *
     * @Route("/{id}/delete", name="map_type_delete")
     * @Method("GET")
	 * @param Request $request
	 * @param MapType $mapType
     */
    public function deleteAction(Request $request, MapType $mapType)
    {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($mapType);
        $em->flush();
        $this->addFlash('success', 'The mapType was deleted.');

        return $this->redirectToRoute('map_type_index');
    }
}
