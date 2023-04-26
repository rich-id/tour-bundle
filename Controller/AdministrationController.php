<?php declare(strict_types=1);

namespace RichId\TourBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdministrationController.
 *
 * @package   RichId\TourBundle\Controller
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class AdministrationController extends AbstractController
{
    /** @IsGranted("EDIT_ADMINISTRATION_TOUR") */
    public function tours(): Response
    {
        return $this->render('@RichIdTour/administration/tours.html.twig');
    }
}
