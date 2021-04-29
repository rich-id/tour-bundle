<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\UseCase\PerformTour;
use RichId\TourBundle\UseCase\ResetPerformedTours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class TourPerformController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourPerformController extends AbstractController
{
    public function perform(Request $request, PerformTour $performTour, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');


        try {
            $performTour($tour);
            $entityManager->flush();

            return new Response();
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function resetTours(Request $request, ResetPerformedTours $resetPerformedTours): Response
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $resetPerformedTours($tour);

            return new Response();
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
