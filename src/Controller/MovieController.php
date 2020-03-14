<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="movie_list", methods={"GET"})
     */
    public function list()
    {
        $entityManager = $this->get('doctrine')->getManager();
        $entityRepository = $entityManager->getRepository(Movie::class);
        $movies = $entityRepository->findAll();
        return $this->render('movie/list.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $entityRepository = $entityManager->getRepository(Movie::class);
        $attributes = $request->attributes->all();
        $movie = $entityRepository->find($attributes['id']);
        if(!$movie){ return $this->redirectToRoute('movie_list'); }
        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/movie/update/{id}", name="movie_update", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function update(Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $entityRepository = $entityManager->getRepository(Movie::class);
        $attributes = $request->attributes->all();
        $movie = $entityRepository->find($attributes['id']);
        if(!$movie){ return $this->redirectToRoute('movie_list'); }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $date = new \DateTime($_POST['date']);
            $date->format('Y-m-d H:i:s');

            $movie->setTitle($_POST['title']);
            $movie->setDate($date);
            $movie->setDirector($_POST['director']);
            $movie->setCast($_POST['cast']);
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('movie_show', [
                'id' => $movie->getId()
            ]);

        } else {

            return $this->render('movie/update.html.twig', [
                'movie' => $movie
            ]);

        }
    }

    /**
     * @Route("/movie/delete/{id}", name="movie_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $entityRepository = $entityManager->getRepository(Movie::class);
        $attributes = $request->attributes->all();
        $movie = $entityRepository->find($attributes['id']);
        if(!$movie){ return $this->redirectToRoute('movie_list'); }
        $entityManager->remove($movie);
        $entityManager->flush();
        return $this->redirectToRoute('movie_list');
    }
}
