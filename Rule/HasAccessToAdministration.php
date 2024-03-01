<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\RichIdTourBundle;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class HasAccessToAdministration
{
    /** @var Security */
    protected $security;

    /** @var ParameterBagInterface */
    protected $parameterBag;

    public function __construct(Security $security, ParameterBagInterface $parameterBag)
    {
        $this->security = $security;
        $this->parameterBag = $parameterBag;
    }

    public function __invoke(): bool
    {
        $role = $this->parameterBag->get('rich_id_tour.admistration_role') ?? RichIdTourBundle::ROLE_RICH_ID_TOUR_ADMIN;

        return $this->security->isGranted($role);
    }
}
