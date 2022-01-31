<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;

class repositoryCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create respository with interference';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    /** =================================== Get stub files ========================================= */
    public function getStubRepo()
    {
        return __DIR__ . '/../../../stubs/repo.stub';
    }

    public function getStubInterface()
    {
        return __DIR__ . '/../../../stubs/interface.stub';
    }

    /*==================================== Buffer stubs ===============================*/

    public function bufferRepoStub($interface)
    {
        $class =  $this->argument('name') . 'Repo';
        /* read the content of the file and add it to repo */
        $file = file_get_contents("stubs/repo.stub",'r');
        $text = str_replace('{{class}}',$class,$file);

        /* check if the user need to create interface*/
        if($interface)
        {
            $useStmt = "use App\\Respatory\\$class" . "interface;";
            $text = str_replace('{{interface}}',$useStmt,$text);
            $text = str_replace('{{interface_imp}}','implements '.$class.'Interface',$text);            

        } else {
            $text = str_replace('{{interface_imp}}','',$text);
            $text = str_replace('{{interface}}','',$text);
        }

        return $text;
    }

    public function bufferRepoInterface()
    {
        $class =  $this->argument('name') . 'RepoInterface';
        $file = file_get_contents("stubs/interface.stub",'r');

        $text = str_replace('{{class}}',$class,$file);


        return $text;
    }

    /** ======================================== Error Handlers ========================================== */

    public function checkDuplication($name)
    {
        if(file_exists("app\Respatory\\$name"))
        {
            return true;
        } else {
            return false;
        }

    }

    public function handle()
    {
        /**============================================= Check if Respatoy folder exist ============================================== */
        if(!file_exists('app\Respatory'))
        {
            mkdir('app\Respatory');
        }

        $name = $this->argument('name');

        /** ======================== Check if the user want to create interface to this repo   ========================== */

        $interface = $this->confirm('Do you want this repo to be assosiated with interface');
        $name = $this->argument('name').'Repo.php';
        $interfaceClass = $this->argument('name').'RepoInterface.php';

        if(!$this->checkDuplication($name))
        {
            touch("app\Respatory\\$name");
            $text = $this->bufferRepoStub($interface);

            file_put_contents("app\Respatory\\$name",$text);

            if($interface)
            {
                touch("app\Respatory\\$interfaceClass");
                $text = $this->bufferRepoInterface();
                file_put_contents("app\Respatory\\$interfaceClass",$text);

                return [
                    $this->info($name . ' has been created'),
                    $this->info($name . ' interface has been created'),
                ];
            } 

            return $this->info($name . ' has been created');

        } else {
            $this->error('This Repo is already existed');
        }
        
        
    }
}
