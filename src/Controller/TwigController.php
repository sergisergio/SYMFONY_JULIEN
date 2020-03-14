<?php

/*

- return $this->render('default/index.html.twig');

// -------------------------------------------------- //

- Créons un tableau membre ayant comme clé nom , age et comme valeur pierre 10, paul 25 .
Affichons des conditions twig pour verifier l'age des membres sachant que
si on a moin de 12 ans on doit pas regarder le film,  si on a moin de 18 ans on peut , à part
ces tranches d'age on est trop vieux pour ce film

// -------------------------------------------------- //

- Soit un tableau evenements qui contient les noms des evenements suivants: Conference Laravel, Meetup Symfony, laravel, comme
date: 20-01-2019 15:00, 12-02-2019 09:00, 20-02-2019 10:00, comme lieu: Paris, canada, senegal
On veut afficher tous ces valeurs dans un tableau . nb: la date doit être au format de la date locale (française).

// -------------------------------------------------- //

Même tableau pour l'exercice précèdente mais ici on affichera les données dans un select du genre :
exple : 1 - Conference laravel
        2 - Meetup symfony
        3 - Laravel

// -------------------------------------------------- //

Soit le tableau membre qu'on vient de créer, affichons Paire si la valeur correspond à une clé paire, impaire si c'est impaire

// -------------------------------------------------- //

Calculons avec le filtre twig  $a * $b / $c sachant que $a est une constante, $b la valeur d'un tableau et $c la valeur d'un parametre global
de twig

// -------------------------------------------------- //

Créons deux pages où l'une héritera du template Global et l'autre contiendra deux templates (template du Bundle et du template Global) sachant
que le template du Bundle contient juste une inclusion d'une page qui affichera 'on est là'.

Le template global contient juste une liste de données comme: contact, offre, demandes, Mes favoris, Boutique qu'on récupère
dans un autre controller

*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    const CONST_NUMBER = 3;

    /**
     * @Route("/twig-page-1", name="twig_page_1")
     */
    public function page1()
    {
        $members = [[
            'name' => 'Pierre',
            'age' => 10
        ],[
            'name' => 'Paul',
            'age' => 25
        ],[
            'name' => 'Jean',
            'age' => 17
        ]];

        $events = ['Conference Laravel', 'Meetup Symfony', 'Laravel'];
        $dates = ['20-01-2019 15:00', '12-02-2019 09:00', '20-02-2019 10:00'];
        $citys = ['Paris', 'Canada', 'Senegal'];

        return $this->render(
            'default/page1.html.twig',
            [
                'members' => $members,
                'events' => $events,
                'dates' => $dates,
                'citys' => $citys
            ]
        );
    }

    /**
     * @Route("/twig-page-2", name="twig_page_2")
     */
    public function page2()
    {
        return $this->render( 'default/page2.html.twig');
    }
}
