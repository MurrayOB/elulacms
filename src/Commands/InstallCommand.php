<?php

namespace Murrayobrien\Elulacms\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Murrayobrien\Elulacms\ElulacmsServiceProvider;

class InstallCommand extends Command{
    protected $name = 'elulacms:install';
    
    protected $description = 'Install Elulacms';

    protected $composer;

    public function __construct(Composer $composer){
        parent::__construct(); 
        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());
    }

    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }
        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    public function handle(Filesystem $filesystem)
    {
        // Publish assets
        //php artisan vendor:publish --tag=public --force
        $this->info('Publishing assets and config files');
        $this->call('vendor:publish', ['--provider' => ElulacmsServiceProvider::class, '--tag' => 'public', '--force' => true]);

        //Migrations
        $this->info('Migrating database tables');
        $this->call('migrate', ['--force' => true]);

        //Dumping AutoLoads
        $this->info('Dumping autoload files');
        $this->composer->dumpAutoloads();

        //Messages
        $this->info('Elulacms successfully installed, yeehaw!');
    }
}