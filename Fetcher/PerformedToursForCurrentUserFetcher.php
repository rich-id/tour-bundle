<?php declare(strict_types=1);

namespace RichId\TourBundle\Fetcher;

use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Repository\UserTourRepository;
use Symfony\Component\Security\Core\Security;

/**
 * Class PerformedToursForCurrentUserFetcher
 *
 * @package   RichId\TourBundle\Fetcher
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class PerformedToursForCurrentUserFetcher
{
    /** @var Security */
    private $security;

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(Security $security, UserTourRepository $userTourRepository)
    {
        $this->security = $security;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(): array
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            return [];
        }

        return $this->userTourRepository->findPerformedTourKeynamesForUser($user);
    }
}
