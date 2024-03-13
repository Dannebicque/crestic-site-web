<?php

namespace App\Twig;

use App\Classes\Configuration;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension.
 */
class AppExtension extends AbstractExtension
{
    public function __construct(private readonly RouterInterface $router, protected Configuration $config)
    {
    }

    public function getFilters()
    {
        return [new TwigFilter('linkMembre', $this->linkMembre(...)), new TwigFilter('tel_format', $this->telFormat(...)), new TwigFilter('moisfr', $this->moisfr(...))];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('settings', $this->getSetting(...))
        ];
    }

    public function telFormat($number)
    {
        $str = '';
        str_replace(['.', '-', ' '], '', (string) $number);
        if (\strlen((string) $number) === 10)
        {
            $str = chunk_split((string) $number, 2, ' ');
        } else
        {
            $str = $number;
        }

        return $str;
    }

    public function moisfr($date) {
        $mois = ['01' =>'Jan',
                 '02' =>'Fév',
                 '03' =>'Mar',
                 '04' =>'Avr',
                 '05' =>'Mai',
                 '06' =>'Jui',
                 '07' =>'Jui',
                 '08' =>'Aoû',
                 '09' =>'Sep',
                 '10' =>'Oct',
                 '11' =>'Nov',
                 '12' =>'Déc'];
        return $mois[$date];
    }

    public function linkMembre($obj)
    {
        if ($obj !== null) {
            $html = '<a href="' . $this->router->generate('public_membres_profil',
                    ['slug' => $obj->getSlug()]) . '" target="_blank" title = "Profil de ' . $obj->getDisplay() . '">' . $obj->getDisplay() . '</a>';
        } else {
            $html = ' - ';
        }

        return $html;
    }

    public function setConfig(Configuration $config): void
    {
        $this->config = $config;
    }

    public function getSetting($name): string
    {
        return $this->config->get($name);
    }
}
