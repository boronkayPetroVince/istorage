<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route(path="/all")
     */
    public function getAllUser():Response{
        //return new Response("SUCCESS");
        return new JsonResponse(["visszateres"=>"Király"]);
    }
}