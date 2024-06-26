<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Action\DisableTour;
use RichId\TourBundle\Action\EnableTour;
use RichId\TourBundle\Action\PerformTour;
use RichId\TourBundle\Action\ResetPerformedTours;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\TourException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class TourController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourController extends AbstractController
{
    #[IsGranted('EDIT_ADMINISTRATION_TOUR', statusCode: 403)]
    public function enable(Request $request, EnableTour $enableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        return $this->action(
            $request,
            function (string $tourKeyname) use ($enableTour, $entityManager) {
                $enableTour($tourKeyname);
                $entityManager->flush();
            }
        );
    }

    #[IsGranted('EDIT_ADMINISTRATION_TOUR', statusCode: 403)]
    public function disable(Request $request, DisableTour $disableTour, EntityManagerInterface $entityManager): JsonResponse
    {
        return $this->action(
            $request,
            function (string $tourKeyname) use ($disableTour, $entityManager) {
                $disableTour($tourKeyname);
                $entityManager->flush();
            }
        );
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY', statusCode: 403)]
    public function perform(Request $request, PerformTour $performTour, EntityManagerInterface $entityManager): JsonResponse
    {
        return $this->action(
            $request,
            function (string $tourKeyname) use ($performTour, $entityManager) {
                $performTour($tourKeyname);
                $entityManager->flush();
            }
        );
    }

    #[IsGranted('EDIT_ADMINISTRATION_TOUR', statusCode: 403)]
    public function resetPerformedTours(Request $request, ResetPerformedTours $resetPerformedTours): JsonResponse
    {
        return $this->action(
            $request,
            function (string $tourKeyname) use ($resetPerformedTours) {
                $resetPerformedTours($tourKeyname);
            }
        );
    }

    private function action(Request $request, callable $action): JsonResponse
    {
        $tour = $request->get('tour', '');

        try {
            $action($tour);

            return new JsonResponse();
        } catch (NotFoundTourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (TourException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
