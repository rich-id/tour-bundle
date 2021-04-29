<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\UseCase\DisabledTour;
use RichId\TourBundle\UseCase\EnabledTour;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function delete(Request $request, EnabledTour $enabledTour, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $enabledTour($tour);
            $entityManager->flush();

            return new Response();
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function post(Request $request, DisabledTour $disabledTour, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        $tour = $request->get('tour', '');

        try {
            $disabledTour($tour);
            $entityManager->flush();

            return new Response();
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
