<?php

namespace AppBundle\Command;

use AppBundle\Core\EntityExpressionLanguage\ExpressionLanguage;
use AppBundle\Core\EntityExpressionLanguage\Resolvers\Entities\DefaultEntityResolver;
use AppBundle\Entity\Client\Client;
use AppBundle\Entity\Client\Position;
use AppBundle\Entity\Person;
use Assert\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LexerTestCommand extends ContainerAwareCommand
{

    /**
     * Configures the current command.
     *
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('t:t')
            ->setDescription('Import clients from OrientExpress');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $defaultEntityResolver = new DefaultEntityResolver();
        $person = new Person();
        $person->setFirstName("John");
        $person->setLastName("Doe");
        $client = new Position();
        $client->setPerson($person);


        $defaultEntityResolver->registerEntities([
            'client' => $client,
            'client.priority' => 4,
            'person.name' => 'Hero.name',
        ]);

        $string = 'client.person.firstName == "John" && client.person.lastName == "Doe"';
        $lang = new ExpressionLanguage($defaultEntityResolver);
        $result = $lang->execute($string);
        var_export($result);
        echo PHP_EOL;
    }

}