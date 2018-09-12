<?php
/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 8/28/18
 * Time: 22:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    private $postData;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $content        = file_get_contents(__DIR__ . './../../../data/posts.json');
        $this->postData = json_decode($content, true);
    }

    /**
     * @Route("/post", methods={"GET"}, name="post")
     */
    public function listAction(Request $request)
    {
        $postData = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('post/list.html.twig', [
            'postData' => $postData
        ]);
    }

    /**
     * @Route("/post/{id}/show", methods={"GET"}, name="post_detail")
     */
    public function detailAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        if ( ! $post) {
            throw $this->createNotFoundException(
                'No post found for id ' . $id
            );
        }

        return $this->render('post/detail.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/post/add", methods={"GET"}, name="post_add")
     */
    public function insertAction()
    {
        $postData = $this->getDoctrine()->getRepository(Post::class)->findAll();
        if (empty($postData)) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($this->postData as $data) {
                $post = new Post();
                $post->setTitle($data['title']);
                $post->setContent($data['content']);
                $post->setPicture($data['picture']);
                $post->setTag(($data['tags']));

                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($post);
            }
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return new Response('OK');

    }

    /**
     * @Route("/post/{id}/edit", methods={"GET", "POST"}, name="post_edit")
     */
    public function editAction(Request $request, Post $post)
    {
        if ( ! $post) {
            throw $this->createNotFoundException(
                'No post found for id ' . $request->get('id')
            );
        }

        $frmPost = $this->createForm(PostType::class, $post);

        $frmPost->handleRequest($request);

        if ($frmPost->isSubmitted() && $frmPost->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Post updated successfully!');
            return $this->redirectToRoute('post');
        }

        return $this->render('post/edit.html.twig', [
            'post'    => $post,
            'frmPost' => $frmPost->createView(),
        ]);
    }

    /**
     * @Route("/post/create", methods={"GET", "POST"}, name="post_create")
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $post    = new Post();
        $frmPost = $this->createForm(PostType::class, $post);

        $frmPost->handleRequest($request);

        if ($frmPost->isSubmitted() && $frmPost->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post created successfully!');
            return $this->redirectToRoute('post');
        }

        return $this->render('post/create.html.twig', [
            'frmPost' => $frmPost->createView(),
        ]);
    }
}
