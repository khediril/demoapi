<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     */
    public function index(PostRepository $postRepository)
    {
        $posts=$postRepository->findAll();
        return $this->render('api/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/api/posts", name="api_posts")
     */
    public function index2(PostRepository $postRepository,NormalizerInterface $normalizer)
    {
        $posts=$postRepository->findAll();
        //$tab=["nom"=>"Ali","prenom"=>"mohamed"];
        $postsnormalise=$normalizer->normalize($posts,null,['groups'=>["xyz","toto"]]);
        #dd($postsnormalise);
        $tabenjson=json_encode($postsnormalise);
        # dd($tabenjson);
       
       
        return new Response($tabenjson,200);
    }
}
