<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Repository\UserTourPerformedRepository;
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

    /** @var UserTourExists */
    private $userTourExists;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    public function __construct(Security $security, UserTourExists $userTourExists, IsTourDisabled $isTourDisabled, UserTourPerformedRepository $userTourPerformedRepository)
    {
        $this->security = $security;
        $this->userTourExists = $userTourExists;
        $this->isTourDisabled = $isTourDisabled;
        $this->userTourPerformedRepository = $userTourPerformedRepository;
    }

    public function __invoke(string $tour): bool
    {
        if (!($this->userTourExists)($tour) || ($this->isTourDisabled)($tour)) {
            return false;
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            return false;
        }

        $existingEntity = $this->userTourPerformedRepository->findOneBy(
            [
                'user' => $user->getId(),
                'tour' => $tour,
            ]
        );

        return null === $existingEntity;
    }
}
