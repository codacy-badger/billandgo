<?php

namespace BillAndGoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{

   /* public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user)) { // || !$user instanceof UserInterface
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        return ($this->redirect("/bill"));
        //return $this->render('BillAndGoBundle:Default:index.html.twig');
    }*/

    /**
     * @Route("/", name="billandgo_dashboard")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user)) { // || !$user instanceof UserInterface
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $manager = $this->getDoctrine()->getManager();
        $projects = ($manager->getRepository('BillAndGoBundle:Project')->findByRefUser($user));
        $bills = ($manager->getRepository('BillAndGoBundle:Document')->findAllBill($user->getId()));
        $quotes = ($estimates = $manager->getRepository('BillAndGoBundle:Document')->findAllEstimate($user->getId()));
        $billpaidm = 0;
        $billtotalm = 0;
        $quotesacceptm = 0;
        $quotestotalm = 0;
        $now = new \DateTime();
        $now = $now->format('m-Y');

        foreach ($bills as $one) {
            if (null != $one->getAnswerDate()) {
                $n = $one->getAnswerDate()->format('m-Y');
            }
            else {
                $n = null;
            }

            if ($one->isBillPaid() && $n == $now) {
                $billpaidm++;
            }

            if ($n == $now) {
                $billtotalm++;
            }
        }


        foreach ($quotes as $one) {
            if (null != $one->getAnswerDate()) {
                $n = $one->getAnswerDate()->format('m-Y');
            }
            else {
                $n = null;
            }

            if ($one->getStatus() == "accepted" && $n == $now) {
                $quotesacceptm++;
            }

            if ($n == $now) {
                $quotestotalm++;
            }
        }
        $clients = count($manager->getRepository('BillAndGoBundle:Client')->findByUserRef($user));
        return $this->render('BillAndGoBundle:Default:dashboard.html.twig', array(
            'user' => $user,
            'project' => count($projects),
            'projects' => $projects,
            'bills' => count($bills),
            'quotes' => count($quotes),
            'clients' => $clients,
            'billpaidm' => $billpaidm,
            'billtotalm' => $billtotalm,
            'quotestotalm' => $quotestotalm,
            'quotesacceptm' => $quotesacceptm,
            'enddate' => date("t/m/Y", strtotime((new \DateTime())->format('Y-m-d')))
        ));
    }
}