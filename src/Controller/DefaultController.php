<?php

namespace App\Controller;

use App\Entity\CategorieProjet;
use App\Entity\Cms;
use App\Entity\Departements;
use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use App\Entity\Organigramme;
use App\Entity\Plateformes;
use App\Entity\Projets;
use App\Entity\Sites;
use App\Kernel;
use App\Repository\CmsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function __construct(private readonly Kernel $kernel, private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/accueil', name: 'default_homepage')]
    public function index(CmsRepository $cmsRepository): Response
    {
        $page = $cmsRepository->findOneBy(['slug' => 'presentation']);

        return $this->render('default/index.html.twig', [
            'page' => $page
        ]);
    }

    public function menuAlternatif(): Response
    {
        $equipes = $this->managerRegistry->getRepository(Equipes::class)->findAllEquipesActives();
        $departements = $this->managerRegistry->getRepository(Departements::class)->findAll();
        $plateformes = $this->managerRegistry->getRepository(Plateformes::class)->findAll();
        $projets = $this->managerRegistry->getRepository(Projets::class)->findAll();
        $categoriesprojets = $this->managerRegistry->getRepository(CategorieProjet::class)->findBy([],
            ['ordre' => 'ASC']);


        return $this->render('default/menuAlternatif.html.twig', [
            'equipes' => $equipes,
            'departements' => $departements,
            'plateformes' => $plateformes,
            'projets' => $projets,
            'categoriesprojets' => $categoriesprojets
        ]);
    }

    #[Route(path: '/organigramme', name: 'public_organigramme')]
    public function organigramme(): Response
    {
        $result = [
            'directeur' => $this->managerRegistry->getRepository(Organigramme::class)->findAllOrganigramme('Directeur'),
            'directeurAdjoint' => $this->managerRegistry->getRepository(Organigramme::class)->findAllOrganigramme('Directeur Adjoint'),
            'conseilLaboratoire' => $this->managerRegistry->getRepository(MembresCrestic::class)->findAllConseilLaboratoire(),
            //'departement' => $this->managerRegistry->getRepository(Departements::class)->findAllDepartements(),
            'equipe' => $this->managerRegistry->getRepository(Equipes::class)->findAllEquipes(),
            'secretaire' => $this->managerRegistry->getRepository(Organigramme::class)->findAllOrganigramme('Secrétaire'),
            'assistante' => $this->managerRegistry->getRepository(Organigramme::class)->findAllOrganigramme('assistante'),
            'technicien' => $this->managerRegistry->getRepository(Organigramme::class)->findAllOrganigramme('Technicien')
        ];

        return $this->render('default/organigramme.html.twig', [
            'organigramme' => $result
        ]);
    }

    #[Route(path: '/page/{slug}', name: 'visiteur_page')]
    public function page($slug): Response
    {

        $page = $this->managerRegistry->getRepository(Cms::class)->findOneBy(['slug' => $slug]);

        return $this->render('default/page.html.twig', [
            'page' => $page
        ]);

    }

    #[Route(path: '/contact', name: 'public_contact')]
    public function contact(): Response
    {
        $sites = $this->managerRegistry->getRepository(Sites::class)->findAll();

        return $this->render('default/contact.html.twig', [
            'sites' => $sites
        ]);
    }

    #[Route(path: '/contact/commentVenir', name: 'public_contact_comment_venir')]
    public function contactCommentVenir(Request $request): Response
    {
        $cms = $this->managerRegistry->getRepository(Cms::class)->findOneBy(['slug' => $request->request->get('slug')]);

        if ($request->request->get('site') !== null) {
            $site = $this->managerRegistry->getRepository(Sites::class)->find($request->request->get('site'));
        } else {
            $site = null;
        }

        return $this->render('default/contactCommentVenir.html.twig', [
            'cms' => $cms,
            'site' => $site
        ]);
    }

    /**
     * @return JsonResponse|Response
     */
    #[Route(path: '/tinyMce/upload', name: 'tinymce_upload')]
    public function uploadImageTinyMce(Request $request): \Symfony\Component\HttpFoundation\JsonResponse|Response
    {
        //gérer l'upload

        if ($request->files !== null) {
            foreach ($request->files as $file) {
                //var_dump($file);
                // générer un nom aléatoire et essayer de deviner l'extension (plus sécurisé)
                $extension = $file->guessExtension();
                if (!$extension) {
                    // l'extension n'a pas été trouvée
                    $extension = 'bin';
                }
                $nomfile = random_int(1, 99999) . '_' . date('YmdHis') . '.' . $extension;
                $dir = $this->kernel->getProjectDir() . '/public/uploads/images/';
                $filetowrite = $request->getSchemeAndHttpHost() . '/uploads/images/' . $nomfile;
                $file->move($dir, $nomfile);

                return new JsonResponse(['location' => $filetowrite]);
            }
            // Accept upload if there was no origin, or if it is an accepted origin

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.0 500 Server Error");
        }

        return new Response('', Response::HTTP_OK);
    }

    #[Route(path: '/deconnexion', name: 'security_logout')]
    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute('default_homepage');
    }
}
