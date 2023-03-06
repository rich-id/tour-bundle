<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use RichId\TourBundle\Rule\HasAccessToAdministration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function tours(HasAccessToAdministration $hasAccessToAdministration): Response
    {
        if (!($hasAccessToAdministration)()) {
            throw new AccessDeniedException();
        }

        return $this->render('@RichIdTour/administration/tours.html.twig');
    }
}
