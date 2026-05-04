<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Crea un usuario administrador',
)]
class CreateAdminCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
        $this->em = $em;
        $this->hasher = $hasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail('facurro539@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'FPizarro314159265');
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('✅ Usuario admin creado correctamente');

        return Command::SUCCESS;
    }
}