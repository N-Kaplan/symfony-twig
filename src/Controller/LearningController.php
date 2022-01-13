<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;

class LearningController extends AbstractController
{
    //requestStack saves session variables
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'homepage')]
    public function showMyName(Request $request, SessionInterface $session): Response {

        $user = new User;
        
        if ($session->get('name')) {
            $user->setName($session->get('name'));
        } else {
            $user->setName("Unknown");
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $session->set('name', $user->getName());
            return $this->changeMyName($user);
        }

        return $this->renderForm('learning/homepage.html.twig', [
            'form' => $form,
            'name' => $session->get('name'),
        ]);
    }


    #[Route('/change-my-name', name: 'changeMyName', methods: 'POST')]
    public function changeMyName($user): Response
    {
        $session = $this->requestStack->getSession();
        $session->set('name', $user->getName());

        return $this->redirectToRoute('homepage');
    }




//    #[Route('/', name: 'homepage')]
//    public function showMyName(Request $request): Response
//    {
//        $user = new User();
//        $user->setName('Unknown');
//        $form = $this->createFormBuilder($user)
//            ->add('name', TextType::class)
//            ->add('save', SubmitType::class, ['label' => 'Submit'])
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        return $this->renderForm('learning/homepage.html.twig', [
//            'name' => $user->getName(),
//            'form' => $form
//        ]);
//    }


//    #[Route('/', name: 'homepage')]
//    #[Route('/change-my-name', name: 'changeMyName', methods: 'POST')]
//    public function showMyName(Request $request): Response
//    {
//        $user = new User();
//        $session = $this->requestStack->getSession();
//
//        $name = $session->get('name', 'Unknown');
//        $user->setName($name);
//
//        $form = $this->createFormBuilder($user)
//            ->setAction($this->generateUrl('changeMyName'))
//            ->setMethod('POST')
//            ->add('name', TextType::class)
//            ->add('save', SubmitType::class, ['label' => 'Submit'])
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
//            $session->set('name', $user->getName());
//
//            return $this->redirectToRoute('homepage');
//        }
//
//        return $this->renderForm('learning/homepage.html.twig', [
//            'name' => $user->getName(),
//            'form' => $form
//        ]);
//    }
//
////     https://symfony.com/doc/current/routing.html#creating-routes-as-attributes-or-annotations
//    #[Route('/change-my-name', name: 'changeMyName', methods: 'POST')]
//    public function changeMyName(): Response
//    {
//        $request = $this->requestStack->getCurrentRequest();
////        $request->set('name', $user->getName());
//
//        var_dump($request->request);
//        // stores an attribute in the session for later reuse
////        $session->set('name', $user->getName());
//
//        return $this->redirectToRoute('homepage');
//    }


    #[Route('/about-me', name: 'about-me')]
    public function aboutMe(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();

        $name = $session->get('name');

        $aboutMe = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In feugiat at odio a commodo. Sed et elit sed leo varius pulvinar. Duis vitae nisl massa. Vivamus id mi eget mi efficitur hendrerit. Sed quis luctus lectus. Sed et pretium risus. Nulla porttitor, est vel iaculis eleifend, est lacus porttitor sapien, vitae fringilla est elit in odio. Suspendisse vel interdum ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam non augue laoreet magna tincidunt blandit quis a nisl. Praesent sit amet scelerisque nunc. Etiam vestibulum augue vel dui volutpat volutpat. Suspendisse interdum sem id augue elementum, ut ultricies risus aliquet. Nunc vitae sagittis quam. ";

        if (!$name) {
            $resp = $this->forward('App\Controller\LearningController::changeMyName');
        } else {
            $resp = $this->render('learning/about-me.html.twig', [
                'name' => $name,
                'about' => $aboutMe
            ]);
        }

        return $resp;
    }

}
