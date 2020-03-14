<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Advert;
use App\Entity\Application;
use App\Form\AdvertType;
use App\Form\ApplicationType;

/**
 * @Route("/{_locale}", defaults={"_locale"="en"}, requirements={ "_locale": "en|fr" })
 */
class AdvertController extends AbstractController
{
    /**
     * @Route("/adverts-plateform/{page}", name="index_advert", methods={"GET","POST"}, defaults={"page"=1})
     */
    public function index(Request $request, PaginatorInterface $paginator, int $page = 1)
    {
        $limitPerPage = 5;
        // $em = $this->get('doctrine')->getManager();
        // $adverts = $em->getRepository(Advert::class)->getPublishedWithPagination($page, $limitPerPage);
        // return $this->render('advert/home.html.twig', [
        //     'page' => $page,
        //     'limit' => $limitPerPage,
        //     'all' => count($entityRepository->findByPublished(true)),
        //     'adverts' => $adverts
        // ]);
        $em = $this->get('doctrine')->getManager();
        $adverts = $paginator->paginate(
            $em->createQuery("SELECT a FROM App\Entity\Advert a WHERE a.published = true ORDER BY a.id ASC"),
            $request->query->getInt('page', $page),
            $limitPerPage
        );
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->add('submit', SubmitType::class);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($application);
                $em->flush();
                $this->addFlash('success', '<h4><b>Your application is sended!</b></h4><p class="my-0">Check your mailbox regularly to see if you have any answers.</p>');
                return $this->redirectToRoute('index_advert', [
                    'page' => $page
                ]);
            }
        }
        return $this->render('advert/home.html.twig', [
            'page' => $page,
            'adverts' => $adverts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/adverts", name="advert_list", methods={"GET"})
     */
    public function list()
    {
        $em = $this->get('doctrine')->getManager();
        $adverts = $em->getRepository(Advert::class)->findAll();
        return $this->render('advert/list.html.twig', [
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/advert/{advert_id}", name="advert_show", methods={"GET"}, requirements={"advert_id"="\d+"})
     */
    public function show(Request $request, int $advert_id)
    {
        $em = $this->get('doctrine')->getManager();
        $advert = $em->getRepository(Advert::class)->find($advert_id);
        return $this->render('advert/show.html.twig', [
            'advert' => $advert
        ]);
    }

    /**
     * @Route("/advert/insert", name="advert_insert", methods={"GET","POST"})
     */
    public function insert(Request $request)
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->add('submit', SubmitType::class);
        $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('advert_list') . '", "_self")']]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();
                return $this->redirectToRoute('advert_list');
            }
        }
        return $this->render('advert/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/advert/update/{advert_id}", name="advert_update", methods={"GET","POST"}, requirements={"advert_id"="\d+"})
     */
    public function update(Request $request, int $advert_id)
    {
        $em = $this->get('doctrine')->getManager();
        $advert = $em->getRepository(Advert::class)->find($advert_id);
        $originalSkills = new ArrayCollection();
        foreach ($advert->getSkills() as $skill) {
            $originalSkills->add($skill);
        }
        $form = $this->createForm(AdvertType::class, $advert);
        $form->add('submit', SubmitType::class);
        $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('advert_list') . '", "_self")']]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                foreach ($originalSkills as $skill) {
                    if (false === $advert->getSkills()->contains($skill)) {
                        $em->remove($skill);
                    }
                }
                $em->persist($advert);
                $em->flush();
                return $this->redirectToRoute('advert_list');
            }
        }
        return $this->render('advert/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/advert/delete/{advert_id}", name="advert_delete", methods={"GET"}, requirements={"advert_id"="\d+"})
     */
    public function delete(Request $request, int $advert_id)
    {
        $em = $this->get('doctrine')->getManager();
        $advert = $em->getRepository(Advert::class)->find($advert_id);
        $em->remove($advert);
        $em->flush();
        return $this->redirectToRoute('advert_list');
    }

    /**
     * Count number of adverts in database
     */
    public function count()
    {
        $em = $this->get('doctrine')->getManager();
        $adverts = $em->getRepository(Advert::class)->findAll();
        return new Response(count($adverts));
    }

    /**
     * Count number of adverts published in database
     */
    public function countPublished()
    {
        $em = $this->get('doctrine')->getManager();
        $adverts = $em->getRepository(Advert::class)->findByPublished(true);
        return new Response(count($adverts));
    }
}
