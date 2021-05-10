<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Action\DisableTour;
use RichId\TourBundle\Action\EnableTour;
use RichId\TourBundle\Action\PerformTour;
use RichId\TourBundle\Action\ResetPerformedTours;
use RichId\TourBundle\Exception\TourException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class TourController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourController extends AbstractController
{
    public function enable(Request $request, EnableTour $enableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $enableTour($tour);
            $entityManager->flush();

            return new JsonResponse();
        } catch (TourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function disable(Request $request, DisableTour $disableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $disableTour($tour);
            $entityManager->flush();

            return new JsonResponse();
        } catch (TourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function perform(Request $request, PerformTour $performTour, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $performTour($tour);
            $entityManager->flush();

            return new JsonResponse();
        } catch (TourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function resetPerformedTours(Request $request, ResetPerformedTours $resetPerformedTours): JsonResponse
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $resetPerformedTours($tour);

            return new JsonResponse();
        } catch (TourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
