<?php

namespace Queue\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Queue\DataBundle\Entity\Entry;

/**
 * Queue Controller
 */
class QueueController extends Controller
{
    public function indexAction()
    {
        // Get list of all queues
        $queues = $this->getDoctrine()->getManager()->getRepository('QueueDataBundle:Queue')->findAll();

        // Render
        return $this->render('QueueWebBundle:Queue:index.html.twig', array(
            'queues' => $queues
        ));
    }

    public function viewAction($queueId)
    {
        // Get user
        $user = $this->getUser();

        // Get entity manager 
        $em = $this->getDoctrine()->getManager();

        // Get queue
        $queue = $em->getRepository('QueueDataBundle:Queue')->findOneById($queueId);

        // Get entries
        $entries = $em->getRepository('QueueDataBundle:Entry')->findActiveByQueue($queue);

        // If it doesn't exist, throw an exception
        if (!$queue) {
            throw $this->createNotFoundException('Queue not found, gg.');
        }

        return $this->render('QueueWebBundle:Queue:view.html.twig', array(
            'queue' => $queue,
            'entries' => $entries,
            'inQueue' => in_array($user, $queue->getUsers()->toArray())
        ));
    }

    public function joinAction($queueId)
    {
        // Get user
        $user = $this->getUser();

        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Get queue
        $queue = $em->getRepository('QueueDataBundle:Queue')->findOneById($queueId);

        // If it doesn't exist, throw an exception
        if (!$queue) {
            throw $this->createNotFoundException('Queue not found, gg.');
        }

        // Add user into queue
        $queue->addUser($user);

        // Save and flush
        $em->persist($queue);
        $em->flush();

        // Add message to session
        $this->get('session')->getFlashBag()->add(
            'notice',
            sprintf('Succesvol lid geworden van %s', $queue->getName())
        );

        // Redirect
        return $this->redirect($this->generateUrl('queues'));
    }

    public function addEntryAction($queueId)
    {
        // Get user
        $user = $this->getUser();

        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Get queue repository
        $queueRepository = $em->getRepository('QueueDataBundle:Queue');

        // Get queue
        $queue = $queueRepository->findOneById($queueId);

        // If it doesn't exist, throw an exception
        if (!$queue) {
            throw $this->createNotFoundException('Queue not found, gg.');
        }

        // Check whether user has active entry in queue
        if ($queueRepository->hasActiveEntry($user, $queue)) {

            // Add flash message
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Error: gebruiker zit al in de wachtrij.'
            );

            return $this->redirect($this->generateUrl('queue', array(
                'queueId' => $queueId
            )));

        }

        // Create new entry and set values
        $entry = new Entry();
        $entry->setUser($user);
        $entry->setQueue($queue);

        // Save entry and flush
        $em->persist($entry);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'notice',
            'Succesvol toegevoegd aan de wachtrij.'
        );

        return $this->redirect($this->generateUrl('queue', array(
            'queueId' => $queueId
        )));
    }

    public function completeEntryAction($queueId, $entryId)
    {
        // Get user
        $user = $this->getUser();

        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Get queue repository
        $queueRepository = $em->getRepository('QueueDataBundle:Queue');

        // Get queue
        $queue = $queueRepository->findOneById($queueId);

        // Get entry repository
        $entryRepository = $em->getRepository('QueueDataBundle:Entry');

        // Get entry
        $entry = $entryRepository->findOneById($entryId);

        // If it doesn't exist, throw an exception
        if (!$queue) {
            throw $this->createNotFoundException('Queue not found, gg.');
        }

        // If entry isn't owned by user, throw an exception
        if ($entry->getUser()->getUsername() !== $user->getUsername()) {
            throw $this->createNotFoundException('Ongeldige entry, gg.');
        }

        // Set is completed
        $entry->setIsCompleted(true);

        // Save and flush
        $em->persist($entry);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'notice',
            'Succesvol uit de wachtrij verwijderd.'
        );

        return $this->redirect($this->generateUrl('queue', array(
            'queueId' => $queueId
        )));
    }

    public function refreshAction($queueId)
    {
        // Get queue repository
        $queueRepository = $this->getDoctrine()->getManager()->getRepository('QueueDataBundle:Queue');

        // Get queue
        $queue = $queueRepository->findOneById($queueId);

        // Remove first in queue
        $queueRepository->removeFirstInQueue($queue);

        return new Response('Refreshed queue');
    }
}