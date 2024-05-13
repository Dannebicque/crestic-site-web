<?php

namespace App\EventListener;

use App\Entity\MaillingList;
use App\Services\Mailer\MailerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\MembresCrestic;

/**
 * Classe EntityListener
 *
 * Cette classe définit les écouteurs d'événements pour les entités dans l'application.
 */

class EntityListener
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;
    private string $SauvMembremail;
    private string $SauvMembrestatus;
    private string $SauvMembrequipe;

    /**
     * Constructeur de classe
     *
     * @param MailerInterface $mailer Un service de messagerie pour envoyer des e-mails.
     * @param EntityManager $entityManager
     */
    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    /**
     * Action réalisée après la suppression d'une entité.
     *
     * Cette méthode envoie un e-mail pour notifier la suppression d'un utilisateur.
     *
     * @param PostRemoveEventArgs $args Les arguments de l'événement de suppression.
     * @return void
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail.
     */

    public function preRemove(PreRemoveEventArgs $args): void
    {
        $entity = $args->getObject();
        /*
         * Cette méthode envoie un e-mail pour notifier la suppression d'un utilisateur
         * Dans l'entity MembreCrestic
         *
         */
        if ($entity instanceof MembresCrestic) {
            $mailingLists = $entity->getMaillingLists();
            foreach ($mailingLists as $mailingList) {

                $message = new MailerService($this->mailer);
                $message->Mailer_sent("DEL {$mailingList} {$entity->getEmail()}", "Suppression de l'utilisateur {$entity->getUsername()} de la maillinglist {$mailingList} .");
            }
        }
    }

    /**
     * Action réalisée après la création d'une nouvelle entité.
     *
     * Cette méthode envoie un e-mail pour notifier l'ajout d'un nouvel utilisateur.
     *
     * @param mixed $args Les arguments de l'événement de création.
     * @return void
     */
    public function postPersist($args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof MembresCrestic) {
            // notre l'equipe peut prendre un forme d'un objject et non du titre
            $status = $entity->getStatus();
            $mailresult = $this->SelectMailbyMembreCrestic($status, null);
            $this->SetMailingList($mailresult, $entity,$this->entityManager);

            $message = new MailerService($this->mailer);
            $message->Mailer_sent("DEL }", "Ajout de l'utilisateur  .");

            }
    }


    /**
     * Action réalisée avant la mise à jour d'une entité.
     *
     * Cette méthode récupère l'ancien e-mail de l'utilisateur avant la mise à jour.
     *
     * @param PreUpdateEventArgs $args Les arguments de l'événement de mise à jour.
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof MembresCrestic) {
            $this->SauvMembremail = $entity->getEmail();
            $this->SauvMembrestatus = $entity->getStatus();
            $this->SauvMembrequipe = $entity->getEquipes() ?? [];
        }


    }

    /**
     * Action réalisée après la mise à jour d'une entité.
     *
     * Cette méthode envoie un e-mail pour notifier les modifications de l'utilisateur.
     *
     * @param PostUpdateEventArgs $args Les arguments de l'événement de mise à jour.
     * @return void
     */
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $mailingLists = $entity->getMaillingLists();

        if ($entity instanceof MembresCrestic) {

            if ($this->SauvMembremail !== $entity->getEmail()) {
                foreach ($mailingLists as $mailingList) {

                    $message = new MailerService($this->mailer);
                    $message->Mailer_sent("DEL {$mailingList} {$this->SauvMembremail})", "Suppression de l'ancien email de l'utilisateur {$entity->getUsername()}.");

                    $message2 = new MailerService($this->mailer);
                    $message2->Mailer_sent("ADD {$mailingList} {$entity->getEmail()}", "Ajout de l'utilisateur {$entity->getUsername()}.");
                }
                if ($this->SauvMembrestatus !== $entity->getStatus()) {

                    $message = new MailerService($this->mailer);
                    $message->Mailer_sent("DEL {$mailingList} {$this->SauvMembremail})", "Suppression de l'ancien email de l'utilisateur {$entity->getUsername()}.");

                    $message2 = new MailerService($this->mailer);
                    $message2->Mailer_sent("ADD {$mailingList} {$entity->getEmail()}", "Ajout de l'utilisateur {$entity->getUsername()}.");
                }
                /*
                if ($this->SauvMembrequipe !== $entity->getEquipes()) {

                    if ($this->SauvMembrequipe == [])
                    {
                        $message = new MailerService($this->mailer);
                        $message->Mailer_sent("DEL {$mailingList} {$this->SauvMembremail})", "Suppression de l'ancien email de l'utilisateur {$entity->getUsername()}.");

                    }
                    else {
                        foreach ($entity->getEquipes() as $equipe) {
                            if(!in_array($equipe,$this->SauvMembrequipe))
                            {
                                $message = new MailerService($this->mailer);
                                $message->Mailer_sent("DEL {$mailingList} {$this->SauvMembremail})", "Suppression de l'ancien email de l'utilisateur {$entity->getUsername()}.");
                            }

                        }
                    }

                }*/
            }


        }
    }
    public function SetMailingList(string $nomlist, $entity, EntityManagerInterface $entityManager ): void
    {
        $mailingList = $entityManager->getRepository(MaillingList::class)->findOneBy(['nomlist' => $nomlist]);

        if(empty($mailingList))
        {
            $mailingList = new MaillingList();
            $mailingList->setNomlist($nomlist);

        }
        // Si votre entité est liée à la MailingList, vous pouvez l'associer ici
        $mailingList->addMembreCresticId($entity);

        // Persistez la nouvelle MailingList en base de données
        $entityManager->persist($mailingList);
        $entityManager->flush();
    }

    public function SelectMailbyMembreCrestic(string $status, ?string $equipe): string
    {
        if ($equipe == null) {
            switch ($status) {
                case "PR":
                case "PU-PH":
                    return "crestic.prof@univ-reims.fr";
                case "MCF":
                case "MCU-PH":
                case "PAST":
                    return "crestic.mcf@univ-reims.fr";
                case "Assoc":
                    return "crestic.assoc@univ-reims.fr";
                case "ING":
                case "ING-R":
                case "TECH":
                case "ADM":
                    return "crestic.biatss@univ-reims.fr";
                case "P-DOC":
                case "ATER":
                case "ING-C":
                    return "crestic.contract@univ-reims.fr";
                case "DOC":
                case "DOCH":
                    return "crestic.doc@univ-reims.fr";
                default:
                    throw new \InvalidArgumentException("Statut non reconnu, équipe nulle : $status");
            }
        } else {
            switch ($status) {
                case "PR":
                case "PU-PH":
                    return "crestic.{$equipe}.prof@univ-reims.fr";
                case "MCF":
                case "MCU-PH":
                case "PAST":
                    return "crestic.{$equipe}.mcf@univ-reims.fr";
                case "Assoc":
                    return "crestic.{$equipe}.assoc@univ-reims.fr";
                case "ING":
                case "ING-R":
                case "TECH":
                case "ADM":
                    return "crestic.biatss@univ-reims.fr";
                case "P-DOC":
                case "ATER":
                case "ING-C":
                    return "crestic.{$equipe}.contract@univ-reims.fr";
                case "DOC":
                case "DOCH":
                    return "crestic.{$equipe}.doc@univ-reims.fr";
                default:
                    throw new \InvalidArgumentException("Statut non reconnu : $status");
            }
        }
    }
}