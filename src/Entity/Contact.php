<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private ?string $firstname = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private ?string $lastname = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/[0-9]{10}/"
     * )
     */
    private ?string $phone = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $email = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private ?string $message = null;

    private ?string $property = null;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }

    /**
     * @param string|null $property
     */
    public function setProperty(?string $property): void
    {
        $this->property = $property;
    }
}
