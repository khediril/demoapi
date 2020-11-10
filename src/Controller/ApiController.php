<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/posts", name="posts",methods={"get"})
     */
    public function index(PostRepository $postRepository)
    {
        $posts=$postRepository->findAll();
        return $this->render('api/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/api/posts", name="api_posts",methods={"get"})
     */
    public function index2(PostRepository $postRepository,NormalizerInterface $normalizer)
    {
        $posts=$postRepository->findAll();
        //dd($posts);
        //$tab=["nom"=>"Ali","prenom"=>"mohamed"];
        $postsnormalise=$normalizer->normalize($posts,null,['groups'=>["xyz","toto"]]);
       // dd($postsnormalise);
        $tabenjson=json_encode($postsnormalise);
         
       
       
        return new Response($tabenjson,200);
    }
    /**
     * @Route("/apiv2/posts", name="api_posts_v2",methods={"get"})
     */
    public function index3(PostRepository $postRepository,SerializerInterface $serializer)
    {
       // $posts=$postRepository->findAll();
        //dd($posts);
        //$tab=["nom"=>"Ali","prenom"=>"mohamed"];
        //$postsnormalise=$normalizer->normalize($posts,null,['groups'=>["xyz","toto"]]);
       // dd($postsnormalise);
       // $tabenjson=json_encode($postsnormalise);
     
        
        
        //return new JsonResponse($posts,200,['groups'=>["xyz","toto"]]);
        return $this->json($postRepository->findAll(),210,[],['groups'=>["xyz","toto"]]);
    }
     /**
     * @Route("/api/posts", name="api_posts_add",methods={"post"})
     */
    public function addPost(Request $request,SerializerInterface $serializer,NormalizerInterface $norm)
    {
       $data=$request->getContent();
       //$normalizedData = json_decode($data);
       $dataJson=$serializer->deserialize($data,Post::class,'json');
       dd($dataJson);

       // return $this->json($data,200,[],[]);
    }
}
