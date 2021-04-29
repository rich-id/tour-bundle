<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\UseCase\PerformTour;
use RichId\TourBundle\UseCase\ResetPerformedTours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TourPerformController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourPerformController extends AbstractController
{
    public const TOUR = 'tour';

    /** @IsGranted("IS_AUTHENTICATED_FULLY") */
    public function perform(Request $request, PerformTour $performTour, EntityManagerInterface $entityManager): Response
    {
        $tour = $request->get(self::TOUR, '');

        try {
            $performTour($tour);
            $entityManager->flush();

            return new Response();
        } catch (NotFoundTourException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /** @IsGranted("ROLE_RICH_ID_TOUR_ADMIN") */
    public function resetTours(Request $request, ResetPerformedTours $resetPerformedTours): Response
    {
        $tour = $request->get(self::TOUR, '');

        try {
            $resetPerformedTours($tour);

            return new Response();
        } catch (NotFoundTourException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            return new Response($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
