<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Skill;
use App\Form\SkillType;

/**
 * @Route("/{_locale}", defaults={"_locale"="en"}, requirements={ "_locale": "en|fr" })
 */
class SkillController extends AbstractController
{
    /**
     * @Route("/skills", name="skill_list", methods={"GET"})
     */
    public function index(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $skills = $em->getRepository(Skill::class)->findAll();
        return $this->render('skill/list.html.twig', [
            'skills' => $skills
        ]);
    }

    /**
     * @Route("/skill/{skill_id}", name="skill_show", methods={"GET"}, requirements={"skill_id"="\d+"})
     */
    public function show(Request $request, int $skill_id)
    {
        $em = $this->get('doctrine')->getManager();
        $skill = $em->getRepository(Skill::class)->find($skill_id);
        return $this->render('skill/show.html.twig', [
            'skill' => $skill
        ]);
    }

    /**
     * @Route("/skill/insert", name="skill_insert", methods={"GET","POST"})
     */
    public function insert(Request $request)
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->add('submit', SubmitType::class);
        $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('skill_list') . '", "_self")']]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($skill);
                $em->flush();
                return $this->redirectToRoute('skill_list');
            }
        }
        return $this->render('skill/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/skill/update/{skill_id}", name="skill_update", methods={"GET","POST"}, requirements={"skill_id"="\d+"})
     */
    public function update(Request $request, int $skill_id)
    {
        $em = $this->get('doctrine')->getManager();
        $skill = $em->getRepository(Skill::class)->find($skill_id);
        $form = $this->createForm(SkillType::class, $skill);
        $form->add('submit', SubmitType::class);
        $form->add('back', ButtonType::class, ['attr' => ['onclick' => 'window.open("' . $this->generateUrl('skill_list') . '", "_self")']]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($skill);
                $em->flush();
                return $this->redirectToRoute('skill_list');
            }
        }
        return $this->render('skill/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/skill/delete/{skill_id}", name="skill_delete", methods={"GET"}, requirements={"skill_id"="\d+"})
     */
    public function delete(Request $request, int $skill_id)
    {
        $em = $this->get('doctrine')->getManager();
        $skill = $em->getRepository(Skill::class)->find($skill_id);
        $em->remove($skill);
        $em->flush();
        return $this->redirectToRoute('skill_list');
    }

    /**
     * Count number of skills in database
     */
    public function count()
    {
        $em = $this->get('doctrine')->getManager();
        $skills = $em->getRepository(Skill::class)->findAll();
        return new Response(count($skills));
    }
}
