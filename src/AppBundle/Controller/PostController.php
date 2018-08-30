<?php
/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 8/28/18
 * Time: 22:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        $content = file_get_contents(__DIR__.'./../../../data/posts.json');
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
        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id '.$id
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
            foreach ($this->postData as $data) {
                $entityManager = $this->getDoctrine()->getManager();

                $post = new Post();
                $post->setTitle($data['title']);
                $post->setContent($data['content']);
                $post->setPicture($data['picture']);
                $post->setTag(serialize($data['tags']));

                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($post);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
            }
            die('===INSERT===');
        }

        die('--Stop--');
    }
}
