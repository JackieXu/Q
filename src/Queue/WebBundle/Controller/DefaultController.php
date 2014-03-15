<?php

namespace Queue\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default Controller
 *
 * Handles the root route. Currently redirects calls to either the login page or the queue index.
 */
class DefaultController extends Controller
{
    /**
     * Method that handles the / route.
     */
    public function indexAction()
    {
        // Check if user is logged in
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            // Redirect to list of queues
            return $this->redirect($this->generateUrl('queues'));

        }

        // Redirect to login
        return $this->redirect($this->generateUrl('login'));
    }
}
