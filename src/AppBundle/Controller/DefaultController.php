<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Incident;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/list/{year}", name="list")
     */
    public function listAction(Request $request, int $year = null): Response
    {
        if (!$year) {
            $dateTime = new \DateTime();
            $year = $dateTime->format('Y');
        }

        $incidentList = $this->getIncidentList($year);

        $counter = count($incidentList);
        $counterString = sprintf('%03d', $counter);

        return $this->render(
            'AppBundle:Default:list.html.twig',
            [
                'year' => $year,
                'counter' => $counterString,
                'incidentList' => $incidentList
            ]
        );
    }

    /**
     * @Route("/map/{year}", name="map")
     */
    public function mapAction(Request $request, int $year = null): Response
    {
        if (!$year) {
            $dateTime = new \DateTime();
            $year = $dateTime->format('Y');
        }

        $incidentList = $this->getIncidentList($year);

        return $this->render(
            'AppBundle:Map:map.html.twig',
            [
                'year' => $year,
                'incidentList' => $incidentList
            ]
        );
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faqAction(Request $request): Response
    {
        return $this->render('AppBundle:Default:faq.html.twig');
    }

    /**
     * @Route("/{year}", name="index")
     */
    public function indexAction(Request $request, int $year = null): Response
    {
        if (!$year) {
            $dateTime = new \DateTime();
            $year = $dateTime->format('Y');
        }

        $incidentList = $this->getIncidentList($year);

        $counter = count($incidentList);
        $counterString = sprintf('%03d', $counter);

        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'year' => $year,
                'counter' => $counterString,
                'incidentList' => $incidentList
            ]
        );
    }

    protected function getIncidentList(int $year): array
    {
        $entityList = $this->getDoctrine()->getRepository('AppBundle:Incident')->findBy([], ['dateTime' => 'DESC']);

        return $entityList;
    }
}
