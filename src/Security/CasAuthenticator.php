<?php
// Copyright (c) 2020. | David Annebicque | IUT de Troyes  - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetV3/src/Security/CasAuthenticator.php
// @author davidannebicque
// @project intranetV3
// @lastUpdate 12/12/2020 14:31

namespace App\Security;

use App\Event\CASAuthenticationFailureEvent;
use phpCAS;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class CasAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private ?\Symfony\Component\Security\Core\User\UserInterface $user = null;

    public function __construct(private readonly ParameterBagInterface $parameterBag, private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function supports(Request $request): bool
    {
        return $request->getPathInfo() === '/sso/cas';
    }

    public function getCredentials(): ?string
    {
        $cas_host = $this->parameterBag->get('CAS_HOST');
        $cas_context = $this->parameterBag->get('CAS_CONTEXT');
        $cas_port = (int)$this->parameterBag->get('CAS_PORT');
        $client_service_name = $this->parameterBag->get('CAS_CLIENT_SERVICE_NAME');
//        $cas_host = 'cas.univ-reims.fr';
//        $cas_context = '/cas';
//        $cas_port = 443;
//        $client_service_name = 'https://crestic.univ-reims.fr';
        phpCAS::setVerbose(true);
        phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, $client_service_name);
        phpCAS::setFixedServiceURL($this->urlGenerator->generate('cas_return', [],
            UrlGeneratorInterface::ABSOLUTE_URL));
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();

        if (phpCAS::getUser()) {
            return phpCAS::getUser();
        }

        return null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        $this->user = $userProvider->loadUserByIdentifier($credentials);

        return $this->user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        $def_response = new JsonResponse($data, \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
        $event = new CASAuthenticationFailureEvent($request, $exception, $def_response);

        return $event->getResponse();

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
            return new RedirectResponse($this->urlGenerator->generate('default_homepage'));
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null): \Symfony\Component\HttpFoundation\Response
    {
        return new RedirectResponse($this->urlGenerator->generate('cas_return'));
    }

    public function authenticate(Request $request): Passport
    {
        $username = $this->getCredentials();
        if (null === $username) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('Authentification CAS incorrecte. Utilisateur inconnu.');
        }

        return new SelfValidatingPassport(new UserBadge($username));
    }
}
