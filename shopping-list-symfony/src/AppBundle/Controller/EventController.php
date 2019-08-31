<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Event controller.
 *
 * @Route("event")
 * @Security("has_role('ROLE_USER')")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $event = new Event();
        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Event $event */
            $event = $form->getData();
            foreach($event->getUsers() as $selectedUser){
                $selectedUser->addUserEvent($event);
                $em->persist($selectedUser);
            }
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="event_show", requirements={"id"="\d+"} )
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Event $event, UserInterface $user)
    {
        $deleteForm = $this->createDeleteForm($event);
        $ok = 0;
       foreach ($event->getUsers() as $usr){
           if($user->getUsername() === $usr->getUsername()){
               $ok = 1;
           }
       }

        if( $ok == 1) {
            return $this->render('event/show.html.twig', array(
                'event' => $event,
                'user' => $user,
                'delete_form' => $deleteForm->createView(),
            ));
        }
        else {
            throw $this->createAccessDeniedException("You don't belong to this event");
        }
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        $ok = 0;
        foreach ($event->getUsers() as $usr){
            if($user->getUsername() === $usr->getUsername()){
                $ok = 1;
            }
        }

        if( $ok == 1) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                /** @var Event $event */
                $event = $editForm->getData();
                foreach ($event->getUsers() as $selectedUser) {
                    $selectedUser->addUserEvent($event);
                    $em->persist($selectedUser);
                }
                $em->persist($event);
                $em->flush();

                return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
            }
        }
        else{
            throw $this->createAccessDeniedException("You can't edit an event where you don't belong");
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
