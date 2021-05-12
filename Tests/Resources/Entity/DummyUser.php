<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Resources\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\TourBundle\Entity\UserTourInterface;

/**
 * Class DummyUser
 *
 * @package    RichId\TourBundle\Tests\Resources\Entity
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @ORM\Entity()
 * @ORM\Table(name="app_user")
 */
class DummyUser implements UserTourInterface
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
