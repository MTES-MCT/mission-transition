<?php

namespace App\Command;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    protected UserPasswordEncoderInterface $encoder;
    protected AdminRepository $adminRepository;
    protected EntityManagerInterface $em;


    public function __construct(
        UserPasswordEncoderInterface $encoder,
        AdminRepository $adminRepository,
        EntityManagerInterface $em
    ){
        $this->encoder = $encoder;
        $this->adminRepository = $adminRepository;
        $this->em = $em;
        parent::__construct();
    }

    public function encodePassword($user, string $plainPassword)
    {
        return $this->encoder->encodePassword($user, $plainPassword);
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
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
            ->setPassword($this->encoder->encodePassword($admin, $input->getArgument('password')))
            ->setIsSuperAdmin(true)
        ;

        $this->em->persist($admin);
        $this->em->flush();
        $output->writeln('Admin successfully generated!');
        return 1;
    }
}
