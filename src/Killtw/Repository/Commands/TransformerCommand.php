<?php

namespace Killtw\Repository\Commands;

use Illuminate\Console\Command;
use Killtw\Repository\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TransformerCommand
 *
 * @package Killtw\Repository\Commands
 */
class TransformerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer.';

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
        (new TransformerGenerator([
            'name' => $this->argument('name'),
            'model' => $this->option('model') ?: $this->argument('name')
        ]))->run();
        $this->info('Transformer created successfully.');
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
        ];
    }
}
