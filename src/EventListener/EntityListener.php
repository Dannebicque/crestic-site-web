<?php

namespace App\EventListener;

use App\Entity\EquipesHasMembres;
use App\Entity\MailingList;
use App\Services\Mailer\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use InvalidArgumentException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\MembresCrestic;

/**
 * Cette classe définit les écouteurs d'événements pour les entités dans l'application.
 */
class EntityListener
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    /**
     * Constructeur de la classe EntityListener.
     *
     * @param MailerInterface $mailer L'interface de messagerie utilisée pour envoyer des emails.
     * @param EntityManagerInterface $entityManager L'interface du gestionnaire d'entités pour interagir avec la base de données.
     */
    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    /**
     * Action exécutée avant la suppression d'une entité.
     * Cette méthode envoie un e-mail pour notifier la suppression d'un utilisateur.
     *
     * @param PreRemoveEventArgs $args Les arguments de l'événement de suppression.
     *
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail.
     */
    public function preRemove(PreRemoveEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof MembresCrestic) {
            // Récupérer les listes de diffusion auxquelles l'utilisateur est inscrit
            $mailingLists = $entity->getMailingLists();

            // Désinscrire l'utilisateur de chaque liste de diffusion et envoyer un e-mail de notification
            foreach ($mailingLists as $mailingList) {
                $message = new MailerService($this->mailer);
                $message->Mailer_sent("DEL {$mailingList->getNomlist()} {$entity->getEmail()}", "Suppression de l'utilisateur {$entity->getUsername()} de la mailinglist {$mailingList->getNomlist()} .");
            }

            // Autres actions de nettoyage ou de gestion liées à la suppression de l'utilisateur
            $this->delEquipeHasMembre($entity, $this->entityManager);
        }

        if ($entity instanceof EquipesHasMembres) {
            // Récupérer les informations sur l'équipe et le membre associé
            $equipe = $entity->getEquipe();
            $membre= $entity->getMembreCrestic();

            // Effectuer des actions spécifiques liées à la suppression d'une relation entre équipe et membre
            $mailresult = $this->selectMailByMembreCrestic($membre->getStatus(),$equipe->getNom());
            $this->delMailingList($mailresult, $membre, $this->entityManager);
        }
    }

    /**
     * Action exécutée après la création d'une nouvelle entité.
     * Cette méthode envoie un e-mail pour notifier l'ajout d'un nouvel utilisateur.
     *
     * @param mixed $args Les arguments de l'événement de création.
     *
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail.
     */
    public function postPersist(mixed $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof MembresCrestic) {
            // Récupérer le statut et les informations de mailing associées au membre
            $status = $entity->getStatus();
            $mailresult = $this->selectMailByMembreCrestic($status, "");

            // Ajouter le membre aux listes de diffusion correspondantes et envoyer un e-mail de notification
            $this->setMailingList($mailresult, $entity, $this->entityManager);

            $message = new MailerService($this->mailer);
            $message->Mailer_sent("ADD $mailresult {$entity->getEmail()}", "Ajout de l'utilisateur {$entity->getUsername()} de la mailinglist $mailresult .");
        }

        if ($entity instanceof EquipesHasMembres) {
            // Récupérer les informations sur l'équipe et le membre associé
            $equipe = $entity->getEquipe();
            $membre = $entity->getMembreCrestic();

            // Mettre à jour les listes de diffusion pour l'équipe et l'utilisateur associés
            $mailresult = $this->selectMailByMembreCrestic($membre->getStatus(), $equipe->getNom());
            $maildelete = $this->selectMailByMembreCrestic($membre->getStatus(), "");

            $this->setMailingList($mailresult, $membre, $this->entityManager);
            $this->delMailingList($maildelete, $membre, $this->entityManager);
        }
    }

    /**
     * Action exécutée après la mise à jour d'une entité.
     * Cette méthode envoie un e-mail pour notifier les modifications apportées à un utilisateur.
     *
     * @param PostUpdateEventArgs $args Les arguments de l'événement de mise à jour.
     *
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail.
     */
    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof MembresCrestic) {
            // Récupérer les listes de diffusion auxquelles l'utilisateur est inscrit
            $mailingLists = $entity->getMailingLists();
            // Récupérer les modifications apportées à l'utilisateur
            $changeset = $this->entityManager->getUnitOfWork()->getEntityChangeSet($entity);

            if (array_key_exists('email', $changeset)) {
                // Si l'e-mail de l'utilisateur a été modifié, envoyer des notifications aux listes de diffusion concernées
                foreach ($mailingLists as $mailingList) {
                    $message = new MailerService($this->mailer);
                    $message->Mailer_sent("DEL {$mailingList->getNomlist()} {$changeset['email'][0]}", "Modification d'email de l'utilisateur {$entity->getUsername()} suppresion de la mailling list {$mailingList->getNomlist()} .");

                    $message2 = new MailerService($this->mailer);
                    $message2->Mailer_sent("ADD {$mailingList->getNomlist()} {$changeset['email'][1]}", "Modification d'email de l'utilisateur {$entity->getUsername()} ajout de la mailling list {$mailingList->getNomlist()} .");
                }
            }

            if (array_key_exists('status', $changeset)) {
                // Si le statut de l'utilisateur a été modifié, mettre à jour les listes de diffusion en conséquence
                $boolequipe = $this->searchByEquipeForStatus($entity, $this->entityManager);
                $status = $entity->getStatus();
                $oldstatus = $changeset['status'][0];

                if ($boolequipe == "") {
                    $mailresult = $this->selectMailByMembreCrestic($status, "");
                    $oldmailresult = $this->selectMailByMembreCrestic($oldstatus, "");

                    $this->setMailingList($mailresult, $entity, $this->entityManager);
                    $this->delMailingList($oldmailresult, $entity, $this->entityManager);
                } else {
                    foreach ($boolequipe as $equipe) {
                        $mailresult = $this->selectMailByMembreCrestic($status, $equipe->getEquipe());
                        $oldmailresult = $this->selectMailByMembreCrestic($oldstatus, $equipe->getEquipe());

                        $this->setMailingList($mailresult, $entity, $this->entityManager);
                        $this->delMailingList($oldmailresult, $entity, $this->entityManager);
                    }
                }
            }
        }
    }

    /**
     * Fonction utilisée pour gérer les listes de diffusion des utilisateurs.
     *
     * Cette méthode ajoute un utilisateur à une liste de diffusion spécifiée par son nom.
     * Si la liste de diffusion n'existe pas, elle est créée.
     *
     * @param string $nomlist Le nom de la liste de diffusion.
     * @param mixed $entity L'entité à associer à la liste de diffusion.
     * @param EntityManagerInterface $entityManager L'interface du gestionnaire d'entités pour interagir avec la base de données.
     */
    public function setMailingList(string $nomlist, mixed $entity, EntityManagerInterface $entityManager ): void
    {
        // Rechercher la liste de diffusion par son nom
        $mailingList = $entityManager->getRepository(MailingList::class)->findOneBy(['nomlist' => $nomlist]);

        if(empty($mailingList)) {
            // Si la liste de diffusion n'existe pas, la créer
            $mailingList = new MailingList();
            $mailingList->setNomlist($nomlist);
        }

        // Ajouter l'entité à la liste de diffusion
        $mailingList->addMembreCresticId($entity);

        // Persiste la liste de diffusion en base de données
        $entityManager->persist($mailingList);
        $entityManager->flush();
    }

    /**
     * Fonction utilisée pour rechercher les équipes associées à un membre Crestic en fonction de son statut.
     *
     * Cette méthode recherche les équipes auxquelles un membre Crestic est associé en fonction de son statut.
     * Elle retourne un tableau d'objets EquipesHasMembres ou une chaîne vide si aucune équipe n'est trouvée.
     *
     * @param MembresCrestic $membreCrestic L'entité MembresCrestic pour laquelle rechercher les équipes.
     * @param EntityManagerInterface $entityManager L'interface du gestionnaire d'entités pour interagir avec la base de données.
     *
     * @return array|string Un tableau d'objets EquipesHasMembres ou une chaîne vide.
     *
     * @throws TransportExceptionInterface En cas d'erreur lors de l'envoi de l'e-mail.
     */
    public function searchByEquipeForStatus(MembresCrestic $membreCrestic, EntityManagerInterface $entityManager): array|string
    {
        // Rechercher les équipes associées au membre Crestic
        $equipes = $entityManager->getRepository(EquipesHasMembres::class)->findby([
            'membreCrestic' => $membreCrestic
        ]);

        // Envoyer un e-mail de notification
        $message = new MailerService($this->mailer);
        $message->Mailer_sent("DEL", " {$equipes[1]->getEquipe()}.$equipes[0]");

        // Vérifier si des équipes ont été trouvées
        if(empty($equipes)) {
            return "";
        } else {
            return $equipes;
        }
    }

    /**
     * Fonction utilisée pour supprimer un utilisateur d'une liste de diffusion.
     *
     * Cette méthode recherche la liste de diffusion spécifiée par son nom, puis supprime l'entité associée à cette liste.
     * Les modifications sont ensuite persistées en base de données.
     *
     * @param string $nomlist Le nom de la liste de diffusion à modifier.
     * @param mixed $entity L'entité (utilisateur) à supprimer de la liste de diffusion.
     * @param EntityManagerInterface $entityManager L'interface du gestionnaire d'entités pour interagir avec la base de données.
     */
    public function delMailingList(string $nomlist, mixed $entity, EntityManagerInterface $entityManager): void
    {
        // Rechercher la liste de diffusion par son nom
        $mailingList = $entityManager->getRepository(MailingList::class)->findOneBy(['nomlist' => $nomlist]);
        if ($mailingList !== null) {
            // Supprimer l'entité de la liste de diffusion
            $mailingList->RemoveMembreCresticId($entity);

            // Persiste les modifications en base de données
            $entityManager->persist($mailingList);
            $entityManager->flush();
        }
    }

    /**
     * Fonction utilisée pour supprimer toutes les associations d'un membre Crestic avec des équipes.
     *
     * Cette méthode recherche toutes les associations (EquipesHasMembres) d'un membre Crestic spécifié et les supprime de la base de données.
     *
     * @param MembresCrestic $membreCrestic L'entité MembresCrestic à traiter.
     * @param EntityManagerInterface $entityManager L'interface du gestionnaire d'entités pour interagir avec la base de données.
     */
    public function delEquipeHasMembre(MembresCrestic $membreCrestic, EntityManagerInterface $entityManager): void
    {
        // Rechercher toutes les associations d'équipes pour le membre Crestic spécifié
        $equipes = $entityManager->getRepository(EquipesHasMembres::class)->findBy(['membreCrestic' => $membreCrestic]);

        // Supprimer chaque association trouvée
        foreach ($equipes as $equipe) {
            $entityManager->remove($equipe);
        }

        // Persiste les suppressions en base de données
        $entityManager->flush();
    }

    /**
     * Sélectionne une adresse e-mail en fonction du statut et éventuellement de l'équipe d'un membre Crestic.
     *
     * Cette méthode retourne une adresse e-mail correspondant au statut et, le cas échéant, à l'équipe spécifiée.
     * Si l'équipe est vide (""), elle sélectionne une adresse générique en fonction du statut.
     * Si une équipe est spécifiée, elle utilise l'équipe pour composer une adresse e-mail spécifique au statut et à l'équipe.
     *
     * @param string $status Le statut du membre Crestic (ex: "PR", "MCF", "Assoc", etc.).
     * @param string $equipe Le nom de l'équipe (peut être vide si non applicable).
     *
     * @return string L'adresse e-mail correspondante au statut et à l'équipe spécifiée.
     *
     * @throws InvalidArgumentException Si le statut spécifié n'est pas reconnu ou si l'équipe est vide et le statut est invalide.
     */
    public function selectMailByMembreCrestic(string $status, string $equipe): string
    {
        if ($equipe== "") {
            return match ($status) {
                "PR", "PU-PH" => "crestic.prof@univ-reims.fr",
                "MCF", "MCU-PH", "PAST" => "crestic.mcf@univ-reims.fr",
                "Assoc" => "crestic.assoc@univ-reims.fr",
                "ING", "ING-R", "TECH", "ADM" => "crestic.biatss@univ-reims.fr",
                "P-DOC", "ATER", "ING-C" => "crestic.contract@univ-reims.fr",
                "DOC", "DOCH" => "crestic.doc@univ-reims.fr",
                default => throw new InvalidArgumentException("Statut non reconnu, équipe nulle : $status"),
            };
        } else {
            // Utilisation de l'équipe pour composer une adresse e-mail spécifique au statut et à l'équipe
            $equipe = strtolower($equipe);

            if (empty($status)) {
                // Adresse générique pour équipe non spécifiée
                return "crestic.$equipe.divers";
            }

            return match ($status) {
                "PR", "PU-PH" => "crestic.$equipe.prof@univ-reims.fr",
                "MCF", "MCU-PH", "PAST" => "crestic.$equipe.mcf@univ-reims.fr",
                "Assoc" => "crestic.$equipe.assoc@univ-reims.fr",
                "ING", "ING-R", "TECH", "ADM" => "crestic.biatss@univ-reims.fr",
                "P-DOC", "ATER", "ING-C" => "crestic.$equipe.contract@univ-reims.fr",
                "DOC", "DOCH" => "crestic.$equipe.doc@univ-reims.fr",
                default => throw new InvalidArgumentException("Statut non reconnu : $status"),
            };
        }
    }
}
