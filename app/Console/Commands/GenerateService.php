<?php

namespace App\Console\Commands;

use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Nette\Utils\FileSystem as UtilsFileSystem;

class GenerateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'argan:make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    public Filesystem $file;
    public function __construct(Filesystem $filesystem) {
      parent::__construct();
      $this->file = $filesystem;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {

        $filePath = $this->getServicePath();
        $this->createDirectory(dirname($filePath));
        if ( !$this->file->exists($filePath) ) {
            $this->file->put($filePath,$this->getStubContent());
            $msg = "Service {$this->getClassName($this->argument('name'))} Berasil di buat ✅\n{$filePath}";
            $this->info($msg);
        } else {
            $this->warn($this->argument('name')." Sudah Ada ❌");

        }
    }
    public function getStubContent(){
        $namespaceSurfix = trim(pathinfo($this->getClassName($this->argument('name')),PATHINFO_DIRNAME),'.');
        $replaced = [
            "CLASS_NAME" => pathinfo($this->getServicePath(),PATHINFO_FILENAME),
            "NAME_SPACE" => "App\\Services".($namespaceSurfix  ? "\\".$namespaceSurfix : null),
        ];
        $content = file_get_contents($this->stubFilePath());
        foreach($replaced as $key => $value) {
            $content = str_replace('{'.$key.'}',$value,$content);
    }
        return $content;
    }
    public function getServicePath(){
        $service = $this->argument('name');
        return "App\\Services\\".$this->getClassName($service)."Service.php";
    }
    public function getClassName($name){
        return ucwords($name);
    }
    public function stubFilePath(){
        return base_path("stubs/Service.stub");
    }

    public function createDirectory($path){
        $fileSystem = new Filesystem();
        if(!$fileSystem->isDirectory($path)) {
            $fileSystem->makeDirectory($path,0777,true,true);
        }
    }
}
