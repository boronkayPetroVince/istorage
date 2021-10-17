<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;
    /** @var EntityManagerInterface */
    private $em;
    /** @var RouterInterface */
    private $router;
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getLoginUrl(){
        return $this->router->generate("app_login");
    }

    public function supports(Request $request){
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod("POST");
    }

    public function getCredentials(Request $request){
        $felhNev = $request->request->get('felhNev');
        $request->getSession()->set(Security::LAST_USERNAME, $felhNev);
        $jelszo = $request->request->get('jelszo');
        return [
            'felhNev' => $felhNev,
            'jelszo' => $jelszo,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider){
        $felhNev = $credentials['felhNev'];
        $felhasznalo = $userProvider->loadUserByUsername($felhNev);
        if (!$felhasznalo){
            throw new CustomUserMessageAuthenticationException("Rossz felhasználónév!");
        }
        return $felhasznalo;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $felhasznalo
     * @return bool|void
     */
    public function checkCredentials($credentials, UserInterface $felhasznalo)
    {
        $tisztaJelszo = $credentials['jelszo'];
        if ($this->passwordEncoder->isPasswordValid($felhasznalo, $tisztaJelszo)){
            return true;
        }

        throw new BadCredentialsException();
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        if ($targetPath){
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate("app_login"));
    }





}