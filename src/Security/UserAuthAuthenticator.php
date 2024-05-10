<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    // public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    // {
    //     if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
    //         return new RedirectResponse($targetPath);
    //     }

    //     // For example:
    //     // return new RedirectResponse($this->urlGenerator->generate('some_route'));
    //     // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    // }
//     public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
// {
//     $role = $request->getPayload()->getString('role');

//     if ($role === 'ROLE_ADMIN') {
//         return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
//     }
    
//     return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
// }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
{
    // $role = $request->getPayload()->getString('role');

    // if ($role === 'ROLE_ADMIN') {
    //     return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
    // }

    // if ($role === 'ROLE_ENSEIGNANT' || $role === 'ROLE_ETUDIANT') {
    //     return new RedirectResponse($this->urlGenerator->generate('app_projet_index'));
    // }

    // return new RedirectResponse($this->urlGenerator->generate('app_login'));

    // Get the user roles
    $roles = $token->getRoleNames();
    // Check if the user has ROLE_MEDECIN or ROLE_PHARMACIEN
    if (in_array('ROLE_ADMIN', $roles)) {
        // Redirect to the ordonnance index route for medecin
        return new RedirectResponse($this->urlGenerator->generate('app_user_index'));

    } 
    // elseif (in_array('ROLE_ETUDIANT', $roles)) {
    //     // Redirect to the appropriate route for pharmacien
    //     // You should replace 'app_pharmacie_index' with the actual route name for pharmacien
    //     return new RedirectResponse($this->urlGenerator->generate('app_projet_index'));
    // }
    // elseif (in_array('ROLE_ETUDIANT', $roles)) {
    //     // Redirect to the appropriate route for pharmacien
    //     // You should replace 'app_pharmacie_index' with the actual route name for pharmacien
    //     return new RedirectResponse($this->urlGenerator->generate('app_projet_index'));
    // }
    elseif (in_array('ROLE_SPECTATEUR', $roles)) {
        // Redirect to the appropriate route for pharmacien
        // You should replace 'app_pharmacie_index' with the actual route name for pharmacien
        return new RedirectResponse($this->urlGenerator->generate('app_ticket_index'));
    }



    // // If user has no specific role, fallback to default redirect
    // if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
    //     return new RedirectResponse($targetPath);
    // }

    // Fallback redirect if no target path is found
    return new RedirectResponse($this->urlGenerator->generate('app_projet_selected'));
}


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
