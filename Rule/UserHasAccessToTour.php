<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Repository\UserTourRepository;
use Symfony\Bundle\SecurityBundle\Security;

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

    /** @var TourIsDisabled */
    private $tourIsDisabled;

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(Security $security, TourExists $tourExists, TourIsDisabled $tourIsDisabled, UserTourRepository $userTourRepository)
    {
        $this->security = $security;
        $this->tourExists = $tourExists;
        $this->tourIsDisabled = $tourIsDisabled;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(string $tourKeyname): bool
    {
        if (!($this->tourExists)($tourKeyname) || ($this->tourIsDisabled)($tourKeyname)) {
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
