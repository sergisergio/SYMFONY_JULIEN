<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Advert;
use App\Entity\Application;
use App\Form\ApplicationType;

/**
 * @Route("/{_locale}", defaults={"_locale"="en"}, requirements={ "_locale": "en|fr" })
 */
class ApplicationController extends AbstractController
{
    /**
     * @Route("/applications", name="application_list", methods={"GET"})
     * @Route("/advert/{advert_id}/applications", name="application_list_by_advert", methods={"GET"}, requirements={"advert_id"="\d+"})
     */
    public function list(Request $request, int $advert_id = null)
    {
        $em = $this->get('doctrine')->getManager();
        if (!is_null($advert_id)) {
            $advert = $em->getRepository(Advert::class)->find($advert_id);
            $applications = $em->getRepository(Application::class)->findByAdvert($advert);
            return $this->render('application/list.html.twig', [
                'advert' => $advert,
                'applications' => $applications
            ]);
        }
        $applications = $em->getRepository(Application::class)->findAll();
        return $this->render('application/list.html.twig', [
            'applications' => $applications
        ]);
    }

    /**
     * @Route("/application/show/{application_id}", name="application_show", methods={"GET"}, requirements={"application_id"="\d+"})
     * @Route("/advert/{advert_id}/application/show/{application_id}", name="application_show_by_advert", methods={"GET"}, requirements={"advert_id"="\d+","application_id"="\d+"})
     */
    public function show(Request $request, int $application_id, int $advert_id = null)
    {
        $em = $this->get('doctrine')->getManager();
        if (!is_null($advert_id)) {
            $advert = $em->getRepository(Advert::class)->find($advert_id);
            $application = $em->getRepository(Application::class)->find($application_id);
            return $this->render('application/show.html.twig', [
                'advert' => $advert,
                'application' => $application
            ]);
        }
        $application = $em->getRepository(Application::class)->find($application_id);
        return $this->render('application/show.html.twig', [
            'application' => $application
        ]);
    }

    /**
     * @Route("/application/insert", name="application_insert", methods={"GET","POST"})
     * @Route("/advert/{advert_id}/application/insert", name="application_insert_by_advert", methods={"GET","POST"}, requirements={"advert_id"="\d+"})
     */
    public function insert(Request $request, int $advert_id = null)
    {
        $em = $this->get('doctrine')->getManager();
        $application = new Application();
        if (!is_null($advert_id)) {
            $advert = $em->getRepository(Advert::class)->find($advert_id);
            $application->setAdvert($advert);
        }
        $form = $this->createForm(ApplicationType::class, $application);
        $form->add('submit', SubmitType::class);
        if (!is_null($advert_id)) {
            $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('application_list_by_advert', ['advert_id' => $advert_id]) . '", "_self")']]);
        } else {
            $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('application_list') . '", "_self")']]);
        }
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($application);
                $em->flush();
                if (!is_null($advert_id)) {
                    return $this->redirectToRoute('application_list_by_advert', [
                        'advert_id' => $advert_id
                    ]);
                }
                return $this->redirectToRoute('application_list');
            }
        }
        if (!is_null($advert_id)) {
            return $this->render('application/insert.html.twig', [
                'advert' => $advert,
                'form' => $form->createView()
            ]);
        }
        return $this->render('application/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/application/update/{application_id}", name="application_update", methods={"GET","POST"}, requirements={"application_id"="\d+"})
     * @Route("/advert/{advert_id}/application/update/{application_id}", name="application_update_by_advert", methods={"GET","POST"}, requirements={"advert_id"="\d+","application_id"="\d+"})
     */
    public function update(Request $request, int $application_id, int $advert_id = null)
    {
        $em = $this->get('doctrine')->getManager();
        $application = $em->getRepository(Application::class)->find($application_id);
        if (!is_null($advert_id)) {
            $advert = $em->getRepository(Advert::class)->find($advert_id);
            $application->setAdvert($advert);
        }
        $form = $this->createForm(ApplicationType::class, $application);
        $form->add('submit', SubmitType::class);
        if (!is_null($advert_id)) {
            $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('application_list_by_advert', ['advert_id' => $advert_id]) . '", "_self")']]);
        } else {
            $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('application_list') . '", "_self")']]);
        }
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($application);
                $em->flush();
                if (!is_null($advert_id)) {
                    return $this->redirectToRoute('application_list_by_advert', [
                        'advert_id' => $advert_id
                    ]);
                }
                return $this->redirectToRoute('application_list');
            }
        } 
        if (!is_null($advert_id)) {
            return $this->render('application/update.html.twig', [
                'advert' => $advert,
                'application' => $application,
                'form' => $form->createView()
            ]);
        }
        return $this->render('application/update.html.twig', [
            'application' => $application,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/application/delete/{application_id}", name="application_delete", methods={"GET"}, requirements={"application_id"="\d+"})
     * @Route("/advert/{advert_id}/application/delete/{application_id}", name="application_delete_by_advert", methods={"GET"}, requirements={"advert_id"="\d+","application_id"="\d+"})
     */
    public function delete(Request $request, int $application_id, int $advert_id = null)
    {
        $em = $this->get('doctrine')->getManager();
        $application = $em->getRepository(Application::class)->find($application_id);
        $em->remove($application);
        $em->flush();
        if (!is_null($advert_id)) {
            return $this->redirectToRoute('application_list_by_advert', [
                'advert_id' => $advert_id
            ]); 
        }  
        return $this->redirectToRoute('application_list');     
    }

    /**
     * Count number of applications in database
     */
    public function count()
    {
        $em = $this->get('doctrine')->getManager();
        $applications = $em->getRepository(Application::class)->findAll();
        return new Response(count($applications));
    }
}
