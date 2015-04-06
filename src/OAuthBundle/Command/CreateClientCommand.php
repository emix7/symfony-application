<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Command;

use OAuthBundle\Service\ClientService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends Command
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * {@inheritdoc}
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        parent::__construct();

        $this->clientService = $clientService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('oauth:client:create')
            ->setDescription('Creates a new OAuth client')
            ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets the redirect uri for the client. Use this option multiple times to set multiple redirect URIs.', null)
            ->addOption('grant-type', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets the allowed grant type for the client. Use this option multiple times to set multiple grant types.', null)
            ->setHelp('The <info>%command.name%</info> command creates a new OAuth client.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->clientService->create($input->getOption('redirect-uri'), $input->getOption('grant-type'));
        $output->writeln(sprintf("Client ID: <info>%s</info>\nClient secret: <info>%s</info>", $client->getPublicId(), $client->getSecret()));
    }
}
