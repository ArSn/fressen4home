<?php
/**
 * This is the ..... [Description]
 *
 * @category App
 * @package Commands
 *
 * @author Claudia Hüttenrauch <claudia.huettenrauch@fashion4home.de>
 *
 * @copyright (c) 2014 by fashion4home GmbH <www.fashionforhome.de>
 * @license GPL-3.0
 * @license http://opensource.org/licenses/GPL-3.0 GNU GENERAL PUBLIC LICENSE
 *
 * @version 1.0.0
 *
 * Date: 17.06.2014
 * Time: 22:04
 */

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportStoreCommand extends AbstractImportCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import store data from a csv';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $file = $this->argument('file');

        if (file_exists($file) === false || is_readable($file) === false) {
            $this->error('"' . $file . '" does not exist or is not readable.');
            return;
        }

        $this->info('Importing stores from "' . $file . '"...');

        $header = $this->readLine();
        while (($line = $this->readLine()) !== FALSE) {
            $store = $this->getNewObject($this->mergeData($header, $line));

            $create = true;
            if ($this->storeExists($store)) {
                $create = $this->confirm('A store named "' . $store->name . '" already exists. Do you which to create it anyways? [yes|no]');
            }

            if ($create) {
                $store->save();
                $this->comment(' - "' . $store->name . '" ID: ' . $store->getKey());
            }
        }

        $this->info('Importing stores completed.');
    }

    private function storeExists($store)
    {
        return Store::where('name', '=', $store->name)->get()->count() > 0;
    }

    private function getNewObject(array $data)
    {
        return new Store($data);
    }

}
