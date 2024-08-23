<?php

namespace App\Controller\Visiteur;

use App\Entity\Agenda;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route(path: '/agenda')]
class PublicAgendaController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_agenda')]
    public function index(
    ): Response
    {
        $evt = $this->managerRegistry->getRepository(Agenda::class)->findAll();

        return $this->render('publicAgenda/index.html.twig', [
            'evenements' => $evt,
        ]);
    }

    //méthode qui récupère une URL en HTTPClient et retourne une reponse au format ics
    #[Route(path: '/ics', name: 'public_agenda_ics')]
    public function getIcs(HttpClientInterface $client): Response
    {
        $url = 'https://caldav.univ-reims.fr/remote.php/dav/public-calendars/JEPCDEWSO7V4K0SI?export';

        $response = $client->request('GET', $url, [
            'headers' => [
                'Depth' => '1',
                'Content-Type' => 'application/xml; charset="utf-8"',
                'Authorization' => 'Basic ' . base64_encode('username:password')
            ],
            'body' => '
            <?xml version="1.0"?>
                <d:propfind  xmlns:d="DAV:" xmlns:cs="http://calendarserver.org/ns/">
                    <d:prop>
                        <d:getetag/>
                        <cs:getctag/>
                    </d:prop>
                </d:propfind>'
        ]);

        $statusCode = $response->getStatusCode();
        $data = $response->getContent();

        return new Response($data, $statusCode);
    }

    #[Route(path: '/{id}', name: 'public_agenda_show')]
    public function show(Agenda $id): Response
    {
        return $this->render('publicAgenda/show.html.twig', [
            'agenda' => $id
        ]);
    }
}
