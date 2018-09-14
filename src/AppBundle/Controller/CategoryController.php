<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category", methods={"GET"}, name="category")
     */
    public function listAction(Request $request)
    {
        $categoryData = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categoryData' => $categoryData
        ]);
    }

    /**
     * @Route("/category/{id}/edit", methods={"GET", "POST"}, name="category_edit")
     */
    public function editAction(Request $request, Category $category)
    {
        if ( ! $category) {
            throw $this->createNotFoundException(
                'No category found for id ' . $request->get('id')
            );
        }

        $frmCategory = $this->createForm(CategoryType::class, $category);

        $frmCategory->handleRequest($request);

        if ($frmCategory->isSubmitted() && $frmCategory->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Category updated successfully!');
            return $this->redirectToRoute('category');
        }

        return $this->render('category/edit.html.twig', [
            'category'    => $category,
            'frmCategory' => $frmCategory->createView(),
        ]);
    }

    /**
     * @Route("/category/create", methods={"GET", "POST"}, name="category_create")
     *
     */
    public function createAction(Request $request)
    {
        $category    = new Category();
        $frmCategory = $this->createForm(CategoryType::class, $category);

        $frmCategory->handleRequest($request);

        if ($frmCategory->isSubmitted() && $frmCategory->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Category created successfully!');
            return $this->redirectToRoute('category');
        }

        return $this->render('category/create.html.twig', [
            'frmCategory' => $frmCategory->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}/show", methods={"GET"}, name="category_detail")
     */
    public function detailAction(Request $request, Category $category)
    {
        return $this->render('category/detail.html.twig', [
            'category' => $category
        ]);
    }
}