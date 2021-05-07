<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AdministrationController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class AdministrationController extends AbstractController
{
    public function tours(ParameterBagInterface $parameterBag): Response
    {
        if (!$this->isGranted('ROLE_RICH_ID_TOUR_ADMIN')) {
            throw new AccessDeniedException();
        }

        return $this->render(
            '@RichIdTour/administration/tours.html.twig',
            [
                'tours' => $parameterBag->get('rich_id_tour.user_tours'),
            ]
        );
    }
}
