<?php


namespace App\Service;


use App\Entity\User;
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

    /**
     * @inheritDoc
     */
    protected function getLoginUrl(){
        return $this->router->generate("app_login");
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request){
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod("POST");
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request){
        $username = $request->request->get('username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('password');
        return [
            'username' => $username,
            'password' => $password,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider){
        $username = $credentials['username'];
        file_put_contents("debug.txt", "$username", FILE_APPEND);
        /** @var User $user */
        $user = $userProvider->loadUserByIdentifier($username);
        file_put_contents("debug.txt", "\n".$user->getPassword()."\n", FILE_APPEND);
        if (!$user){
            file_put_contents("debug.txt", "\nRossz felhasználónév!\n", FILE_APPEND);
            throw new CustomUserMessageAuthenticationException("Rossz felhasználónév!");
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        file_put_contents("debug.txt", "$plainPassword", FILE_APPEND);
        if ($this->passwordEncoder->isPasswordValid($user,$plainPassword)){
            file_put_contents("debug.txt", "\nJó jelszó!\n", FILE_APPEND);
            return true;
        }
        file_put_contents("debug.txt", "\nRossz jelszó!\n", FILE_APPEND);
        throw new BadCredentialsException();
    }


    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }





}