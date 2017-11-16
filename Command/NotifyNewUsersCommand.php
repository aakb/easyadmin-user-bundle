<?php

namespace Itk\Bundle\EasyAdminUserBundle\Command;

use Itk\Bundle\EasyAdminUserBundle\Entity\User;
use Itk\Bundle\EasyAdminUserBundle\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class NotifyNewUsersCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('admin-user:notify-new-users')
            ->addArgument('usernames', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Usernames to notify')
            ->setDescription('Notify new users (who have not yet logged in) about their account.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        if (!$userManager instanceof UserManager) {
            return;
        }

        $helper = $this->getHelper('question');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $users = $em->getRepository(User::class)->findBy(['lastLogin' => null]);
        $usernames = $input->getArgument('usernames');
        foreach ($users as $user) {
            if ($usernames && !in_array($user->getUsername(), $usernames, true)) {
                continue;
            }
            $question = new ConfirmationQuestion(sprintf('Notify user %s? ', $user->getEmail()), false);
            if (!$input->isInteractive() || $helper->ask($input, $output, $question)) {
                $output->writeln(sprintf('User %s notified.', $user->getEmail()));
                $userManager->notifyUserCreated($user, true);
            }
        }
    }
}
