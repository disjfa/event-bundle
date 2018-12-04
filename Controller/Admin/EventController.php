<?php

namespace Disjfa\EventBundle\Controller\Admin;

use Disjfa\EventBundle\Entity\Event;
use Disjfa\EventBundle\Form\Type\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin/event")
 */
class EventController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * EventController constructor.
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @return Response
     * @Route("/", name="disjfa_event_admin_event_index")
     */
    public function indexAction()
    {
        return $this->render('@DisjfaEvent/Admin/Event/index.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     * @Route("/create", name="disjfa_event_admin_event_create")
     */
    public function createAction(Request $request)
    {
        $event = new Event($this->getUser());

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($event);
            $this->entityManager->flush($event);

            $this->addFlash('success', $this->translator->trans('message.event_saved', [], 'disjfa-event'));
            return $this->redirectToRoute('disjfa_event_admin_event_index');
        }

        return $this->render('@DisjfaEvent/Admin/Event/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
