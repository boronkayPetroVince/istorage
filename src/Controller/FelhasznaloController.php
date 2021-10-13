<?php


namespace App\Controller;


use App\Entity\Felhasznalo;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FelhasznaloController extends AbstractController
{
    /** @var SecurityService */
    private $security;

    /**
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils): Response{

        /** @var Felhasznalo $user */
        $user = $this->getUser();
        return $this->render("");
    }

}