<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Classes/Configuration.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 07/02/2021 10:10
 */

/*
 * Pull your hearder here, for exemple, Licence header.
 */

namespace App\Classes;

use App\Repository\ConfigurationRepository;

class Configuration
{
    /**
     * @var \App\Entity\Configuration[]
     */
    private array $settings = [];

    public function __construct(private readonly ConfigurationRepository $configurationRepository)
    {
    }

    public function get($name): string
    {
        if (0 === \count($this->settings)) {
            $this->getAllSettings();
        }

        return $this->settings[$name];
    }

    public function getAllSettings(): void
    {
        $settings = $this->configurationRepository->findAll();

        foreach ($settings as $conf) {
            $this->settings[$conf->getCle()] = $conf->getValue();
        }
    }
}
