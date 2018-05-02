<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/question")
 */
class QuestionController extends Controller
{

    private $questionData = [
        'id'   => 1,
        'text' => 'Quelle est la couleur du cheval blanc d\'Henry IV ?',
        'answers' => [
            'blanc' => 'blanc',
            'noir' => 'noir',
            'rouge' => 'rouge',
            'jaune' => 'jaune',
        ],
    ];

    /**
     * @Route("/show", name="question_show")
     */
    public function questionShowAction(Request $request)
    {
        $data = $this->questionData;

        $form = $this->createFormBuilder()
            ->add('answers', ChoiceType::class, [
                'label' => $data['text'],
                'choices' => $data['answers'],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('save', SubmitType::class)
            ->getForm()
        ;
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($participant);
            // $em->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('question/show.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
