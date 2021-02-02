<?php

namespace App\Command;

use App\Service\MessageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SpamVladCommand extends Command
{
    protected static $defaultName = 'spam-vlad';

    private $messageService;

    public function __construct(string $name = null, MessageService $messageService)
    {
        parent::__construct($name);
        $this->messageService = $messageService;

    }

    protected function configure()
    {
        $this->setDescription('This command send a tweet included a promo code to Vlad');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $promoTweets = $this->messageService->search(['PROMO20',],['exclude_replies' => true,]);

        try {
            $this->messageService->sendMessage($promoTweets->statuses[rand(0,4)]->full_text);
            $io->success('You have spammed Vlad');
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }

        return 0;
    }
}
