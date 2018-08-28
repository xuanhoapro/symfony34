<?php
/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 8/28/18
 * Time: 22:05
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends Controller
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
     * @Route("/posts", methods={"GET"}, name="posts")
     */
    public function listAction(Request $request)
    {
        return $this->render('posts/list.html.twig', [
            'postData' => $this->postData
        ]);
    }

    /**
     * @Route("/posts/{id}/show", methods={"GET"}, name="posts_detail")
     */
    public function detailAction(Request $request, $id)
    {
        $postData = $this->postData;
        $key = array_search($id, array_column($postData, '_id'));
        if ($key===false) {
            return $this->redirectToRoute('posts');
        }

        return $this->render('posts/detail.html.twig', [
            'post' => $postData[$key]
        ]);
    }
}
