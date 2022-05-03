<?php


namespace App\Notifications;


use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class CreationCompteNotification
{
    /**
     * Propriété contenant le module d'envoi de mail
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Propriété contenant l'environnement twig
     *
     * @var Environment
     */
    private $renderer;

    /**
     * Constructeur de classe
     * @param Swift_Mailer $mailer
     * @param Environment $renderer
     */

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    /**
     * Méthode de notification (envoi de mail)
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */

    public function notify()
    {
        // On construit le mail
        $message = (new Swift_Message('New Registration'))
            // Expéditeur
            ->setFrom('trophyhunterteamleader@gmail.com')
            // Destinataire
            ->setTo('adtrophyhun@gmail.com')
            // Corps du message (créé avec twig)
            ->setBody(
                $this->renderer->render(
                    'emails/addaccount.html.twig'
                ),
                'text/html'
            );

        // On envoie le mail
        $this->mailer->send($message);
    }
}