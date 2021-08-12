<?php
namespace App\Models;
// TODO: Archivo Modelo Usuarios ...
// *: Importamos las classes necesarias ...
use Doctrine\ORM\Mapping as ORM;
/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_EF687F2E7927C74", columns={"email"})})
 * @ORM\Entity
 */
class User
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
    /**
     * @var \DateTime
     * @ORM\Column(name="email_verified_at", type="datetime", nullable=true)
     */
    private $emailVerifiedAt;
    /**
     * @var string
     *
     * @ORM\Column(name="remember_me", type="string", length=255, nullable=true)
     */
    private $remember_me;
    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->setDateTimeAt();
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDateTimeAt()
    {
        $this->updatedAt = new \DateTime('now');
        $this->createdAt = new \DateTime('now');
    }
    public function setUpdateAt()
    {
        $this->updatedAt = new \DateTime('now');
    }
    public function setEmailVerifiedAt()
    {
        $this->emailVerifiedAt = new \DateTime('now');
    }
    public function getEmailVerifiedAt(): string
    {
        if ($this->emailVerifiedAt != null) {
            return $this->emailVerifiedAt->format('d-m-Y H:i:s');
        }
        return false;
    }
    public function getRemember() : string
    {
        return $this->remember_me;
    }
    public function setRemember(string $remeber) : void
    {
       $this->remember_me = $remeber;
    }
}
