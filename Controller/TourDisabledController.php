<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Action\DisableTour;
use RichId\TourBundle\Action\EnableTour;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class TourDisabledController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourDisabledController extends AbstractController
{
    public function delete(Request $request, EnableTour $enableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $enableTour($tour);
            $entityManager->flush();

            return new JsonResponse();
        } catch (\Throwable $throwable) {
            return new JsonResponse($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function post(Request $request, DisableTour $disableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $disableTour($tour);
            $entityManager->flush();

            return new JsonResponse();
        } catch (\Throwable $throwable) {
            return new JsonResponse($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
