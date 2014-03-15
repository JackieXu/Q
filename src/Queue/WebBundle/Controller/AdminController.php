<?php

namespace Queue\WebBundle\Controller;

use Queue\DataBundle\Entity\Queue;
use Queue\DataBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminController extends Controller
{
    public function indexAction()
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Get all users
        $users = $em->getRepository('QueueDataBundle:User')->findAll();
        
        // Get all queues
        $queues = $em->getRepository('QueueDataBundle:Queue')->findAll();

        return $this->render('QueueWebBundle:Admin:index.html.twig', array(
            'users' => $users,
            'queues' => $queues
        ));
    }

    public function addUserAction()
    {
        // Get request
        $request = $this->getRequest();

        // Check if post request
        if ($request->getMethod() === 'POST') {

            // Get entity manager
            $em = $this->getDoctrine()->getManager();

            // Get username
            $username = $request->get('username');

            // Get password
            $password = $request->get('password');

            // Create new user
            $user = new User();

            // Get password encoder
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);

            // Set user value
            $user->setUsername($username);
            $user->setPasswordHash($encoder->encodePassword($password, $user->getPasswordSalt()));
            $user->setRoles('ROLE_USER');

            // Save user and flush
            $em->persist($user);
            $em->flush();

            // Add flash message
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Succesvol gebruiker toegevoegd'
            );

        }

        return $this->render('QueueWebBundle:Admin:user_form.html.twig');
    }

    public function addQueueAction()
    {
        // Get request
        $request = $this->getRequest();

        // Check if POST request
        if ($request->getMethod() === 'POST') {

            // Get entity manager
            $em = $this->getDoctrine()->getManager();

            // Get name
            $name = $request->get('name');

            // Get message
            $message = $request->get('message');

            // Create new queue with received values
            $queue = new Queue();
            $queue->setName($name);
            $queue->setMessage($message);

            // Save queue and flush
            $em->persist($queue);
            $em->flush();

            // Add flash message
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Succesvol queue toegevoegd'
            );

        }

        return $this->render('QueueWebBundle:Admin:queue_form.html.twig');
    }
}