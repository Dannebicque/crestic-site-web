<?php

namespace App\Twig\Components;

use App\Entity\MembresCrestic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class UploadFiles
{
    use DefaultActionTrait;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator)
    {
    }

    #[LiveProp]
    public ?string $singleUploadFilename = null;
    #[LiveProp]
    public ?string $singleFileUploadError = null;

    #[LiveProp]
    public MembresCrestic $membreCrestic;


    #[LiveAction]
    public function uploadFiles(Request $request): void
    {
        $singleFileUpload = $request->files->get('single');
        if ($singleFileUpload) {
            $this->validateSingleFile($singleFileUpload);
        }

        if ($singleFileUpload instanceof UploadedFile) {
            $this->singleUploadFilename = $this->processFileUpload($singleFileUpload);
        }
    }

    private function processFileUpload(UploadedFile $file): string
    {
        $file->move('uploads/membresCrestic', $file->getClientOriginalName());
        $this->membreCrestic->setImage($file->getClientOriginalName());

        $this->entityManager->flush();
        return $file->getClientOriginalName();
    }

    private function validateSingleFile(UploadedFile $singleFileUpload): void
    {
        $errors = $this->validator->validate($singleFileUpload, [
            new Assert\File([
                'maxSize' => '1M',
            ]),
        ]);

        if (0 === \count($errors)) {
            return;
        }

        $this->singleFileUploadError = $errors->get(0)->getMessage();

        // causes the component to re-render
        throw new UnprocessableEntityHttpException('Validation failed');
    }
}
