<?php

namespace Killtw\Repository\Commands;

use Illuminate\Console\Command;
use Killtw\Repository\Generators\PresenterGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PresenterCommand
 *
 * @package Killtw\Repository\Commands
 */
class PresenterCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:presenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new presenter.';

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
        (new PresenterGenerator([
            'name' => $this->argument('name'),
            'transformer' => $this->option('transformer') ?: $this->argument('name')
        ]))->run();
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
            ['transformer', null, InputOption::VALUE_OPTIONAL, 'Transformer for this presenter.', null],
        ];
    }
}
