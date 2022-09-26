<?php
namespace App\Controller;

use App\Entity\File;
use App\Form\Uploader;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConverterController extends AbstractController
{
    
  #[Route('/',name: 'app_homepage')]
    
  public function Home(Request $request): Response 
  {
    $form = $this->createForm(Uploader::class);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) { 
      $newFile = new File($request->files->get('uploader')['file']);
      
      return new BinaryFileResponse($newFile->getNewFilename());
    }

    return $this->renderForm('converter/homepage.html.twig',
          ['form' => $form,'title' => 'Welcome to my csv/xlsx Converter']);
  }


}