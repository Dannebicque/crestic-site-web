<?php

namespace App\Controller\Admin;

use App\Classes\MyExcelWriter;
use App\Repository\MembresCresticRepository;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class MembresCresticExportController extends AbstractController
{

    #[Route('/admin/membres/crestic/export', name: 'admin_membres_crestic_export')]
    public function exportMembresCrestic(
        MembresCresticRepository $membresCresticRepository,
        MyExcelWriter            $myExcelWriter
    ): StreamedResponse
    {
        $myExcelWriter->createSheet('Membres Crestic');

        /*Nom ; Prénom ; Status ; HDR ; Equipe ; idHal ; dateDépart ; ancienMembreCrestic ; email */
        $myExcelWriter->writeCellName('A1', 'Nom');
        $myExcelWriter->writeCellName('B1', 'Prénom');
        $myExcelWriter->writeCellName('C1', 'Status');
        $myExcelWriter->writeCellName('D1', 'HDR');
        $myExcelWriter->writeCellName('E1', 'Equipe');
        $myExcelWriter->writeCellName('F1', 'idHal');
        $myExcelWriter->writeCellName('G1', 'dateDépart');
        $myExcelWriter->writeCellName('H1', 'ancienMembreCrestic');
        $myExcelWriter->writeCellName('I1', 'email');

        $membres = $membresCresticRepository->findAllMembres();
        $row = 2;

        foreach ($membres as $membre) {
            if ($membre->getEquipesHasMembres()->count() > 0) {
                $equipes = $membre->getEquipesHasMembres();
                foreach ($equipes as $equipeHasMembre) {
                    $myExcelWriter->writeCellName('A' . $row, $membre->getNom());
                    $myExcelWriter->writeCellName('B' . $row, $membre->getPrenom());
                    $myExcelWriter->writeCellName('C' . $row, $membre->getStatus());
                    $myExcelWriter->writeCellName('D' . $row, $membre->getHdr());
                    $myExcelWriter->writeCellName('E' . $row, $equipeHasMembre->getEquipe()->getNom());
                    $myExcelWriter->writeCellName('F' . $row, $membre->getIdHal());
                    $myExcelWriter->writeCellName('G' . $row, $membre->getDateDepart()?->format('d/m/Y'));
                    $myExcelWriter->writeCellName('H' . $row, $membre->getAncienMembresCrestic());
                    $myExcelWriter->writeCellName('I' . $row, $membre->getEmail());
                    $row++;
                }
            } else {
                $myExcelWriter->writeCellName('A' . $row, $membre->getNom());
                $myExcelWriter->writeCellName('B' . $row, $membre->getPrenom());
                $myExcelWriter->writeCellName('C' . $row, $membre->getStatus());
                $myExcelWriter->writeCellName('D' . $row, $membre->getHdr());
                $myExcelWriter->writeCellName('E' . $row, '-');
                $myExcelWriter->writeCellName('F' . $row, $membre->getIdHal());
                $myExcelWriter->writeCellName('G' . $row, $membre->getDateDepart()?->format('d/m/Y'));
                $myExcelWriter->writeCellName('H' . $row, $membre->getAncienMembresCrestic());
                $myExcelWriter->writeCellName('I' . $row, $membre->getEmail());
                $row++;
            }

        }


        $writer = new Xlsx($myExcelWriter->getSpreadsheet());
        $name = 'membres_crestic_' . date('Y-m-d_H-i-s');

        return new StreamedResponse(
            static function () use ($writer) {
                $writer->save('php://output');
            },
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $name . '.xlsx"',
            ]
        );
    }
}
