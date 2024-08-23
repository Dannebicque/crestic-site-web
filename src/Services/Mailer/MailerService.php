<?php

namespace App\Services\Mailer;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Service d'envoi d'e-mails.
 */
class MailerService
{
    private MailerInterface $mailer;

    /**
     * Constructeur de la classe MailerService.
     *
     * @param MailerInterface $mailer Instance du service de messagerie à injecter
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Envoie d'un e-mail.
     * Cette méthode envoie un e-mail avec un sujet et un contenu spécifiés.
     *
     * @param string $subject Sujet de l'e-mail
     * @param string $text Contenu de l'e-mail
     *
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail
     */
    public function Mailer_sent(string $subject, string $text): void
    {
        $email = (new Email())
            ->from("") // Adresse e-mail de l'expéditeur
            ->to("") // Adresse e-mail du destinataire
            ->subject($subject) // Sujet de l'e-mail
            ->text($text) // Contenu de l'e-mail
        ;

        // Envoi de l'e-mail via le service de messagerie injecté
        $this->mailer->send($email);
    }
}
