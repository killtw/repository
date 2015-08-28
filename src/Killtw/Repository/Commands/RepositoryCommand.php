<?php

namespace Killtw\Repository\Commands;

use Illuminate\Console\Command;
use Killtw\Repository\Generators\PresenterGenerator;
use Killtw\Repository\Generators\RepositoryGenerator;
use Killtw\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RepositoryCommand
 *
 * @package App\Console\Commands
 */
class RepositoryCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = [
            'name' => $this->argument('name'),
            'model' => $this->option('model') ?: $this->argument('name'),
            'presenter' => '',
            'presenterClass' => null
        ];
        if ($this->option('present')) {
            $transformer = new TransformerGenerator($options);
            $options['transformer'] = $transformer->getRootNamespace() . $this->argument('name') . 'Transformer';
            $presenter = new PresenterGenerator($options);
            $options['presenter'] = 'use ' . $presenter->getRootNamespace() . $this->argument('name') . 'Presenter;';
            $options['presenterClass'] = $this->argument('name') . 'Presenter::class';
            $transformer->run();
            $this->info('Transformer created successfully.');
            $presenter->run();
            $this->info('Presenter created successfully.');
        }
        (new RepositoryGenerator($options))->run();
        $this->info('Repository created successfully.');
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of model.', null],
        ];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'Model of this repository.', null],
            ['present', null, InputOption::VALUE_NONE, '', null],
        ];
    }
}
