<?php namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Theme;
use Input;
use App\Pirate;
use Eloquent;
use DB;
use Session;
use PHPExcel_IOFactory;

use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pirates = Pirate::all();
		return view('welcome')->with('pirates', $pirates);
	}

	public function upload(){
		$time1 = microtime(true);
		
		//get user input from form
		$extension = Input::file('file')->getClientOriginalExtension();
		$fileName = 'pirate.'.$extension;
		Input::file('file')->move(storage_path('excel/exports'), $fileName); //put the file under storage folder

		$objPHPExcel = PHPExcel_IOFactory::load(storage_path('excel/exports/'). $fileName); //get the uploaded file, this part will took a lot of time based on how large the data is (30k row & 8 col ~100 seconds)
		$sheet = $objPHPExcel->getSheet(0); //get the first sheet, modify this part to get another sheet
		$highestRow = $sheet->getHighestRow(); //get the highest row in the sheet
		$highestColumn = $sheet->getHighestColumn(); //get the highest column in the sheet

		$pirates = []; //create an array of Pirate
		Pirate::truncate(); //empty the table
		//iterating each row
		for ($row = 2; $row <= $highestRow; $row++) {
		    //  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
				NULL, TRUE, FALSE);
			foreach($rowData as $key){
				//uncomment row below to see row's data
				//var_dump($key);
				//assigning each row data into array
				$pirates[] = [
					'name' => $key[0], //means the 1st column of current $row
					'bounty' => $key[1]
				];
			}
			//we insert each 5000 data to database, because bulk insert has a limit each insertion
			if ($row % 5000 == 0){
				Pirate::insert($pirates);
				$pirates = []; //empty the array
			}
		}
		Pirate::insert($pirates); //after iteration, if there are datas left, we insert it again

		$time2 = microtime(true);
		echo "sampai masukin ke db: ". round(($time2-$time1), 2). "<br>"; 
		echo "memory sekarang " . memory_get_usage()/1000000 . " MB <br>";
		//uncommment this part if you want to read the execution tima and memory usage
		//die();
		return redirect('/');
	}

}
