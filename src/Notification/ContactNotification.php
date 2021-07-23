<?php
namespace App\Notification;
use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactNotification
{
    private MailerInterface $mailer;

    private Environment $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function notify(Contact $contact)
    {
       $message = (new Email('Agence :' .$contact->getProperty()->getTitle()))
             ->from('noreply@agence.fr')
             ->to('contact@agence.fr')
             ->replyTo($contact->getEmail())
             ->setBody($this->renderer->render('emails/contact.html.twig',[
                 'contact' => $contact
             ]), 'text/html');
       $this->mailer->send($message);
    }
}