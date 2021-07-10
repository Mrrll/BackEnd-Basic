<?php
namespace App\Models;
// TODO: Archivo Modelo Usuarios ...
// *: Importamos las classes necesarias ...
use Doctrine\ORM\Mapping as ORM;
/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_EF687F2E7927C74", columns={"email"})})
 * @ORM\Entity
 */
class Usuarios
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    public function create(array $datos)
    {
        $this->name = $datos['name'];
        $this->email = $datos['email'];
        $this->password = password_hash($datos['password'],PASSWORD_DEFAULT);
        $this->setCreatedAt();
    }
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
    }
    public function setUpdateAt()
    {
        $this->updatedAt = new \DateTime('now');
    }
}
