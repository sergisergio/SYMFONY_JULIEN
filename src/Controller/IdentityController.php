<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentityController extends AbstractController
{
    public function reference(string $firstname, string $lastname, int $age)
    {
        ob_start();
        ?><!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Symfony | Route</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            </head>
            <body>
                <div class="container py-5">
                    <div class="row">
                        <div class="col">
                            <h1>Symfony | Route</h1>
                            <table class="table table-striped table-bordered table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">FIRSTNAME</th>
                                        <th scope="col">LASTNAME</th>
                                        <th scope="col">AGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>[___FIRSTNAME___]</td>
                                        <td>[___LASTNAME___]</td>
                                        <td>[___AGE___]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </body>
        </html><?php
        $html = ob_get_contents();
        $html = str_replace('[___FIRSTNAME___]', $firstname, $html);
        $html = str_replace('[___LASTNAME___]', $lastname, $html);
        $html = str_replace('[___AGE___]', $age, $html);
        ob_end_clean();
        return new Response($html);
    }

    public function forum(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $attributes = $request->attributes->all();
        ob_start();
        ?><!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Symfony | Route</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            </head>
            <body>
                <div class="container py-5">
                    <div class="row">
                        <div class="col">
                            <h1>Symfony | Route</h1>
                            <table class="table table-striped table-bordered table-hover table-dark">
                                <tr><th>PATH</th><td>[___PATH___]</td></tr>
                                <tr><th>YEAR</th><td>[___YEAR___]</td></tr>
                                <tr><th>MONTH</th><td>[___MONTH___]</td></tr>
                                <tr><th>ID</th><td>[___ID___]</td></tr>
                                <tr><th>FORMAT</th><td>[___FORMAT___]</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </body>
        </html><?php
        $html = ob_get_contents();
        $html = str_replace('[___PATH___]', $pathInfo, $html);
        $html = str_replace('[___YEAR___]', $attributes['_route_params']['year'], $html);
        $html = str_replace('[___MONTH___]', $attributes['_route_params']['month'], $html);
        $html = str_replace('[___ID___]', $attributes['_route_params']['id'], $html);
        $html = str_replace('[___FORMAT___]', $attributes['_route_params']['_format'], $html);
        ob_end_clean();
        return new Response(
            $html,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
    }
}
