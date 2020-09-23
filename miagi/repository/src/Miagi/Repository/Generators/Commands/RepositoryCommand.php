<?php
namespace Miagi\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Miagi\Repository\Generators\FileAlreadyExistsException;
use Miagi\Repository\Generators\RepositoryEloquentGenerator;
use Miagi\Repository\Generators\RepositoryInterfaceGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RepositoryCommand
 * @package Miagi\Repository\Generators\Commands
 */
class RepositoryCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * @var Collection
     */
    protected $generators = null;


    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle(){
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        $this->generators = new Collection();

        $this->generators->push(new RepositoryInterfaceGenerator([
            'name'  => $this->argument('name'),
        ]));

        foreach ($this->generators as $generator) {
            $generator->run();
        }

        try {
            (new RepositoryEloquentGenerator([
                'name'      => $this->argument('name'),
            ]))->run();
            $this->info("Repository created successfully.");
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null
            ],
        ];
    }
}
