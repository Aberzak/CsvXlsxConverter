<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FileController 
{
    
    #[Route('/')]
     
    public function index()
    {
      return new Response('etst');
    }
}