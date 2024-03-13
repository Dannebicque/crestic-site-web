<?php


namespace App\Classes;


use App\Entity\Departements;
use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Hal
{
    final public const STRUCTURE = 21189;

    private array $statsDepartement = [];
    private array $statsEquipe = [];
    private array $statsMembre = [];

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function getHalMembre(MembresCrestic $membresCrestic)
    {
        $response = null;
        if ($membresCrestic->getIdhal() !== '' && $membresCrestic->getIdhal() !== null) {
            $response = $this->client->request(
                'GET',
                'https://api.archives-ouvertes.fr/search/?q=authIdHal_s:' . $membresCrestic->getIdhal() . '&wt=json&indent=true'
            );
        }

        $content = $response->toArray();

    }

    public function calculStatistiques(Departements $departement)
    {
        $this->statsDepartement[$departement->getId()]['membre'] = 0;
        $this->statsDepartement[$departement->getId()]['total'] = 0;
        $this->statsDepartement[$departement->getId()]['total2016'] = 0;
        $dateFin = date('Y');
        /** @var MembresCrestic $membre */
        foreach ($departement->getMembres() as $membre) {
            if ($membre->getIdhal() !== null && $membre->getIdhal() !== '') {
                $response = $this->client->request(
                    'GET',
                    'https://api.archives-ouvertes.fr/search/?q=structId_i:' . self::STRUCTURE . ' AND authIdHal_s:' . $membre->getIdhal() . '&wt=json&rows=0');

                $content = $response->toArray();

                $response = $this->client->request(
                    'GET',
                    'https://api.archives-ouvertes.fr/search/?q=structId_i:' . self::STRUCTURE . ' AND authIdHal_s:' . $membre->getIdhal() . '&wt=json&rows=0&fq=producedDateY_i:[2016 TO ' . $dateFin . ']');
                $content2 = $response->toArray();

                $this->statsMembre[$membre->getId()] = [
                    'membre' => $membre,
                    'total' => $content['response']['numFound'],
                    'total2016' => $content2['response']['numFound']
                ];

                $this->statsDepartement[$departement->getId()]['membre']++;
                $this->statsDepartement[$departement->getId()]['total'] +=$content['response']['numFound'];
                $this->statsDepartement[$departement->getId()]['total2016']+=$content2['response']['numFound'];

                //equipes
                foreach ($membre->getEquipesHasMembres() as $equipesHasMembre)
                {
                    $equipe = $equipesHasMembre->getEquipe();
                    if (!array_key_exists($equipe->getId(), $this->statsEquipe)) {
                        $this->statsEquipe[$equipe->getId()]= [
                            'equipe' => $equipe,
                            'membre' => 0,
                            'total' => 0,
                            'total2016' => 0
                        ];
                    }
                    $this->statsEquipe[$equipe->getId()]['membre']++;
                    $this->statsEquipe[$equipe->getId()]['total'] +=$content['response']['numFound'];
                    $this->statsEquipe[$equipe->getId()]['total2016']+=$content2['response']['numFound'];
                }
            }
        }
    }

    public function getStatsDepartement(): array
    {
        return $this->statsDepartement;
    }

    public function getStatsEquipe(): array
    {
        return $this->statsEquipe;
    }

    public function getStatsMembre(): array
    {
        return $this->statsMembre;
    }
}
