<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {

        $this->encoder = $encoder;
    }


    protected function loadData(ObjectManager $manager)
    {

        $this->createMany(10, 'user_admin', function ($num) {
            $admin = new User();
            $admin
                ->setEmail(sprintf('admin%d@kritik.fr', $num))
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->encoder->encodePassword( $admin, 'admin' . $num));

            //Retourne l'entité
            return $admin;

        });

        $this->createMany(40,'user_user', function ($num){
            $user = new User();
            $user
                ->setEmail(sprintf('user%d@mail.org', $num))
                ->setPassword($this->encoder->encodePassword( $user, 'user' . $num));

            return $user;

        });

        //Enregistrer les entités en base de données
        $manager->flush();
    }
}