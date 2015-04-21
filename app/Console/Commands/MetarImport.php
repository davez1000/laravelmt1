<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Metar;

class MetarImport extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'metarimport';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Imports sample METARS to storage.';

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
	 * @return mixed
	 */
	public function fire()
	{
		$amount = $this->argument('amount');
		$type = $this->argument('type');
		if (!is_numeric($amount)) {
			$this->error('The amount specified is not a number! Remember what numbers are?');
		}
		else {
			for ($i = 0; $i < $amount; $i++) {
				$icao = Metar::randomIcao();
				$item = Metar::fetch($icao, $type, TRUE);
				$item = trim($item);
				$check = Metar::where('raw', '=', $item)->first();
				if (!$check) {
					preg_match('/^(?:\S+?\s+){2}(\S+).+$/', $item, $matches);
					$m = new Metar;
					$m->icao = $matches[1];
					$m->raw = $item;
					$m->save();
				}
			}
			$this->info($amount . ' items of type ' . $type . ' have now been imported!');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['amount', InputArgument::OPTIONAL, 'Specify how many you would like to import.', 5],
			['type', InputArgument::OPTIONAL, 'Specify the type, METAR or TAF.', 'metar'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
