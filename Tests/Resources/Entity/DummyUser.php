<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\TourBundle\Entity\UserTourInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DummyUser
 *
 * @package   RichId\TourBundle\Tests\Resources\Entity
 * @author    Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright 2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @ORM\Entity()
 * @ORM\Table(name="app_user")
 */
class DummyUser implements UserInterface, UserTourInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return ['ROLE_RICH_ID_TOUR_ADMIN'];
    }

    public function getPassword(): string
    {
        return '';
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function supportsClass($class): bool
    {
        return DummyUser::class === $class;
    }
}
