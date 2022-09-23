<?php
namespace App\Controller;

use App\Entity\File;
use App\Form\Uploader;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ConverterController extends AbstractController
{
    
    #[Route('/',name: 'app_homepage')]
     
    public function index()
    {
      return $this->render('home.html.twig');
    }

    #[Route('/add',name: 'app_homepage')]
     
    public function addFile(Request $request): Response 
    {
      $file = new File();

      $form = $this->createForm(Uploader::class,$file);
      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) { 
        $file = $request->files->get('uploader')['file'];
        $uploads_directory = $this->getParameter('uploads_directory');

        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move(
          $uploads_directory,
          $filename
        );

        echo "<pre>";
        var_dump($filename);die;
      }


      return $this->renderForm('converter/homepage.html.twig',
            ['form' => $form,]);
    }
}