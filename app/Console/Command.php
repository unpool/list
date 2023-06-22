<?php

namespace App\Console;

use Illuminate\Console\Command as LaravelCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class Command extends LaravelCommand {

    protected $files;

    /**
     * AdminOfficerCommand constructor.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files) {

        parent::__construct();

        $this->files = $files;
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function getStub($name) {

        try {

            return $this->files->get(__DIR__ . "/Stubs/$name.stub");

        } catch (FileNotFoundException $e) {

            throw new FileNotFoundException();
        }
    }

    protected function makeDir($directory, $path = '') {

        $this->files->makeDirectory("{$directory}/$path", 0755, true, true);
    }

    protected function alreadyExists($file) {

        return $this->files->exists($file);
    }
}
