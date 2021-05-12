<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Repository\UserTourRepository;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserHasAccessToTour
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserHasAccessToTour
{
    /** @var Security */
    private $security;

    /** @var TourExists */
    private $tourExists;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(Security $security, TourExists $tourExists, IsTourDisabled $isTourDisabled, UserTourRepository $userTourRepository)
    {
        $this->security = $security;
        $this->tourExists = $tourExists;
        $this->isTourDisabled = $isTourDisabled;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(string $tourKeyname): bool
    {
        if (!($this->tourExists)($tourKeyname) || ($this->isTourDisabled)($tourKeyname)) {
            return false;
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            return false;
        }

        $userTour = $this->userTourRepository->findOneByUserAndTour($user, $tourKeyname);

        return $userTour === null;
    }
}
