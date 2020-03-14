<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route(
     *    "/event", 
     *    name="event_list",
     *    methods={"GET"}
     * )
     */
    public function list()
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Get all entities in BDD
        // $events = $entityRepository->findAll();
        $events = $entityRepository->recupTous();

        // View
        return $this->render(
            'event/list.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route(
     *    "/event-custom-1", 
     *    name="event_list_custom_1",
     *    methods={"GET"}
     * )
     */
    public function list_custom_1()
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Affichons les 5 derniers evenements se trouvant entre deux dates
        $events = $entityRepository->findBetweenDate(
            new \DateTime('2021-01-01'),
            new \DateTime('2021-12-31'),
            5
        );

        // View
        return $this->render(
            'event/list.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route(
     *    "/event-custom-2", 
     *    name="event_list_custom_2",
     *    methods={"GET"}
     * )
     */
    public function list_custom_2()
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Recherchons une date particulière dans la liste des dates
        $events = $entityRepository->findByDate(new \DateTime('2020-10-31 03:07:36'));

        // View
        return $this->render(
            'event/list.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route(
     *    "/event-custom-3", 
     *    name="event_list_custom_3",
     *    methods={"GET"}
     * )
     */
    public function list_custom_3()
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);
        
        // Affichons le premier et le dernier évênement dans une requête
        $firstEvent = $entityRepository->findFirstDate();
        $lastEvent = $entityRepository->findLastDate();
        $events = [
            $firstEvent[0],
            $lastEvent[0]
        ];

        // View
        return $this->render(
            'event/list.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route(
     *    "/event-custom-4", 
     *    name="event_list_custom_4",
     *    methods={"GET"}
     * )
     */
    public function list_custom_4()
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Afficher toutes les dates avec les mois suivant : Janvier et Août (peu importe l'année)
        $months = ['01','08'];
        $events = $entityRepository->findByMonths($months);

        // View
        return $this->render(
            'event/list.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route(
     *    "/event/{id}", 
     *    name="event_show",
     *    methods={"GET"},
     *    requirements={"id"="\d+"}
     * )
     */
    public function show(Request $request)
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Get entity in BDD
        $attributes = $request->attributes->all();
        $event = $entityRepository->find($attributes['id']);

        // View
        return $this->render(
            'event/show.html.twig',
            [
                'event' => $event
            ]
        );
    }

    /**
     * @Route(
     *    "/event/update/{id}", 
     *    name="event_update",
     *    methods={"GET","POST"},
     *    requirements={"id"="\d+"}
     * )
     */
    public function update(Request $request)
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Get entity in BDD
        $attributes = $request->attributes->all();
        $event = $entityRepository->find($attributes['id']);

        // POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // Set entity
            $event->setName(strip_tags($_POST['name']));
            $event->setPrice(strip_tags($_POST['price']));
            $event->setDate(new \DateTime());
            $event->setDescription(strip_tags($_POST['description']));
            $event->setLocation(strip_tags($_POST['location']));

            // Save entity in BDD
            $entityManager->persist($event); // PDO->prepare();
            $entityManager->flush(); // PDO->execute();

            // Redirection
            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);

        }
        
        // GET
        else {
    
            // View
            return $this->render(
                'event/update.html.twig',
                [
                    'event' => $event
                ]
            );

        }
    }

    /**
     * @Route(
     *    "/event/delete/{id}", 
     *    name="event_delete",
     *    methods={"GET"},
     *    requirements={"id"="\d+"}
     * )
     */
    public function delete(Request $request)
    {
        // Get entity manager
        $entityManager = $this->get('doctrine')->getManager();

        // Get entity repository
        $entityRepository = $entityManager->getRepository(Event::class);

        // Get entity in BDD
        $attributes = $request->attributes->all();
        $event = $entityRepository->find($attributes['id']);

        // Delete entity in BDD
        $entityManager->remove($event); // PDO->prepare();
        $entityManager->flush(); // PDO->execute();

        // Redirection
        return $this->redirectToRoute('event_list');
    }
}
