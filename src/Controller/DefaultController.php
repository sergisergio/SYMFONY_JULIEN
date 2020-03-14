<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('base.html.twig');
    }

    public function reponse()
    {
        return new Response('ok');
    }

    public function dump()
    {
        $date = new \DateTime(date('Y-m-d'));
        dump($date->format('d/m/Y'));
        exit;
    }

    public function data()
    {
        return $this->render(
            'default/data.html.twig',
            [
                'twig_base_contact' => 'François DUPOND',
                'twig_base_offre' => '-50%',
                'twig_base_demande' => 'Ordinateur',
                'twig_base_favori' => 'Alienware',
                'twig_base_boutique' => 'DELL'
            ]
        );
    }
}
