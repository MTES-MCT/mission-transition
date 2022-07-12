<?php

namespace App\Command;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    protected UserPasswordHasherInterface $encoder;
    protected AdminRepository $adminRepository;
    protected EntityManagerInterface $em;

    public function __construct(
        UserPasswordHasherInterface $encoder,
        AdminRepository $adminRepository,
        EntityManagerInterface $em
    ) {
        $this->encoder = $encoder;
        $this->adminRepository = $adminRepository;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a admin user.')
            ->setHelp('[COMMAND] {email} {password}')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    /**
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Admin Creator',
            '============',
            '',
        ]);

        $output->writeln('Email: '.$input->getArgument('email'));

        $admin = new Admin();
        $admin
            ->setEmail($input->getArgument('email'))
            ->setPassword($this->encoder->hashPassword($admin, $input->getArgument('password')))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $this->em->persist($admin);
        $this->em->flush();
        $output->writeln('Admin successfully generated!');

        return 1;
    }
}
