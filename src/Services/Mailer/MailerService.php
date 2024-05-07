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
     *
     * @param string $subject Sujet de l'e-mail
     * @param string $text Contenu de l'e-mail
     *
     * @throws TransportExceptionInterface
     */
    public function Mailer_sent(string $subject, string $text): void
    {
        $email = (new Email())
            ->from("")
            ->to("")
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }
}
