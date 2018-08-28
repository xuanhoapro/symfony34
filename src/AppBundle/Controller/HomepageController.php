<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profiles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('homepage/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/form", name="form")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request)
    {
        $profile    = new Profiles();
        $frmProfile = $this->createFormBuilder($profile)
                           ->add('fullname', TextType::class)
                           ->add('age', TextType::class)
                           ->add('dob', DateType::class)
                           ->add('description', TextareaType::class)
                           ->add('save', SubmitType::class, array('label' => 'Submit'))
                           ->getForm();

        return $this->render('homepage/form.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'frmProfile' => $frmProfile->createView(),
        ]);
    }
}
