<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageService;

/**
 *
 * @author guillaume
 * @Route("/message", name="message_")
 *
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param MessageService $message
     */
    public function search(MessageService $message)
    {
        $message->search(['PROMO10',],['exclude_replies' => true,]);

    }

    /**
     * @Route("/show/{id}", name="show")
     * @param MessageService $message
     */
    public function showById(MessageService $message, $id)
    {
        $message->getOneById($id);
    }

    /**
     * @Route("/retweets/{id}", name="retweets")
     * @param MessageService $message
     */
    public function showRetweets(MessageService $message, $id)
    {
        $message->getRetweetsById($id);
    }

    /**
     * @Route("/send", name="send")
     * @param MessageService $message
     */
    public function send(MessageService $message)
    {
        $promoTweets = $message->search(['PROMO10',],['exclude_replies' => true,]);

        $message->sendMessage($promoTweets->statuses[rand(0,5)]->full_text);

        dd('ok');
    }
}
