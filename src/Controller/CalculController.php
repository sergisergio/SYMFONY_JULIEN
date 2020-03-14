<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    /**
     * @Route(
     *    "/calcul", 
     *    name="calcul_get",
     *    methods={"GET"}
     * )
     */
    public function calculGet(Request $request)
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

                            <div class="alert alert-info mt-5 mb-2">
                                <h4 class="alert-heading">Calculator</h4>
                                <p>Enter your equation and validate (with bottom buttons, with your numpad or directly in the input box).</p>
                            </div>

                            <form action="[___ROUTE___]" method="post" class="d-none">
                                <div class="form-group">
                                    <label for="a">A</label>
                                    <input type="number" class="form-control form-control-sm" id="a" name="a" required>
                                </div>
                                <div class="form-group">
                                    <label for="operator">OPERATOR</label>
                                    <select id="operator" name="operator" class="form-control form-control-sm">
                                        <option>+</option>
                                        <option>-</option>
                                        <option>*</option>
                                        <option>/</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="b">B</label>
                                    <input type="number" class="form-control form-control-sm" id="b" name="b" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">Calcul</button>
                                </div>
                            </form><!-- formulaire -->

                            <div class="container pt-3">
                                <div class="row">
                                    <div class="col text-center pt-1 d-flex">
                                        <input id="operable" type="text" class="flex-fill form-control form-control-sm" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center pt-1 d-flex">
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('7');">7</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('8');">8</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('9');">9</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('+');">+</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center pt-1 d-flex">
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('4');">4</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('5');">5</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('6');">6</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('-');">-</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center pt-1 d-flex">
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('1');">1</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('2');">2</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('3');">3</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('/');">/</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center pt-1 d-flex">
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('C');">C</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('0');">0</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('=');">=</button>
                                        <button type="button" class="flex-fill mx-1 mt-1 btn btn-sm btn-secondary" onclick="keyClick('*');">*</button>
                                    </div>
                                </div>
                            </div><!-- calculette -->

                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script type="text/javascript">
                var numA = '';
                var numB = '';
                var operator = '';
                function keyClick(key){
                    switch(key){
                        case '0': case '1': case '2': case '3': case '4': case '5': case '6': case '7': case '8': case '9': if(operator == ''){ numA += key; $('#a').val(numA); } else { numB += key; $('#b').val(numB); } break;
                        case '+': case '-': case '/': case '*': if(operator == ''){ operator = key; $('#operator').val(operator); } else { alert('Sorry, only one operation !'); } break;
                        case '=': if (numA != '' && numB != '' && operator != '') { $('form').submit(); } break;
                        case 'C': numA = ''; $('#a').val(numA); numB = ''; $('#b').val(numA); operator = ''; break;
                    }
                    $("#operable").val(numA + ' ' + operator + ' ' + numB);
                }
                $(function(){
                    $( "body" ).keypress(function(event) {
                        switch(event.which){
                            case 48: keyClick('0'); break; // 0
                            case 49: keyClick('1'); break; // 1
                            case 50: keyClick('2'); break; // 2
                            case 51: keyClick('3'); break; // 3
                            case 52: keyClick('4'); break; // 4
                            case 53: keyClick('5'); break; // 5
                            case 54: keyClick('6'); break; // 6
                            case 55: keyClick('7'); break; // 7
                            case 56: keyClick('8'); break; // 8
                            case 57: keyClick('9'); break; // 9
                            case 43: keyClick('+'); break; // + 
                            case 45: keyClick('-'); break; // -
                            case 47: keyClick('/'); break; // /
                            case 42: keyClick('*'); break; // *
                            case 61: keyClick('='); break; // =
                            case 13: keyClick('='); break; // ENTER
                            case 99: keyClick('C'); break; // c
                            case 8:  keyClick('C'); break; // BACK
                        }
                    });
                });
                </script>
            </body>
        </html><?php
        $html = ob_get_contents();
        $html = str_replace('[___ROUTE___]', $this->generateUrl('calcul_post'), $html);
        ob_end_clean();
        return new Response($html);
    }

    /**
     * @Route(
     *    "/calcul",
     *    name="calcul_post",
     *    methods={"POST"}
     * )
     */
    public function calculPost(Request $request)
    {
        $attributes = $request->request->all();
        switch ($attributes['operator']) {
            case '+': $result = $attributes['a'] + $attributes['b']; break;
            case '-': $result = $attributes['a'] - $attributes['b']; break;
            case '*': $result = $attributes['a'] * $attributes['b']; break;
            case '/': $result = $attributes['a'] / $attributes['b']; break;
        }
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

                            <h1 class="border-bottom mb-3 pb-3">Symfony | Route</h1>

                            <div class="alert alert-success mt-5 mb-2">
                                <h4 class="alert-heading">Calculator</h4>
                                <p>[___A___] [___OPERATOR___] [___B___] = <b>[___RESULT___]</b></p>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-secondary" onclick="window.open('[___ROUTE___]','_self');">Back</button>
                        
                        </div>
                    </div>
                </div>
            </body>
        </html><?php
        $html = ob_get_contents();
        $html = str_replace('[___A___]', $_POST['a'], $html);
        $html = str_replace('[___OPERATOR___]', $_POST['operator'], $html);
        $html = str_replace('[___B___]', $_POST['b'], $html);
        $html = str_replace('[___RESULT___]', $result, $html);
        $html = str_replace('[___ROUTE___]', $this->generateUrl('calcul_get'), $html);
        ob_end_clean();
        return new Response($html);
    }
}
