<?php
  
namespace App\Http\Controllers\Auth;

//session_start();

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Log;
use App\Models\PromoPhrase;
use App\Models\BenefitPhrase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
  
class GeneratePhrasesController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function createPromos(Request $request)
    {

        Log::debug("execute....");

        $subject = $request->subject;

        Log::debug("create prompt....");
        $prompt = $this->writePromoPrompt($subject);

        $data = array();

        for ($i = 0; $i < 5; $i++) {
            $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
            $data[$i]['subject'] = $subject;
            $data[$i]['phrase'] = $phrase;
            sleep(3);
        }

        session(['promos' => $data]); 

        $url = session('url');
        if (!isset($url)) {
            $url = '';
        }
        
        return view('results', ['data' => $data, 'subject' => $subject, 'url' => $url]);
    } 

    public function primePromos(Request $request)
    {

        Log::debug("execute api....");

        $subject = $request->subject;

        Log::debug("create prompt....");
        $prompt = $this->writePromoPrompt($subject);

        $data = array();

        Log::debug("call open ai....");
        for ($i = 0; $i < 1; $i++) {
            $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
            $data[$i]['subject'] = $subject;
            $data[$i]['phrase'] = $phrase;
            sleep(1);
        }

        Log::debug("got the data....");
        session(['promos' => $data]); 
        
        return json_encode($data);
    } 

    public function createBenefits(Request $request)
    {

        Log::debug("execute....");

        $subject = $request->subject;

        Log::debug("create prompt....");
        $prompt = $this->writeBenefitPrompt($subject);

        $data = array();

        for ($i = 0; $i < 5; $i++) {
            $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
            $data[$i]['subject'] = $subject;
            $data[$i]['phrase'] = $phrase;
            sleep(3);
        }
        
        session(['benefits' => $data]);

        $url = session('url');
        if (!isset($url)) {
            $url = '';
        }

        return view('results', ['data' => $data, 'subject' => $subject, 'url' => $url]);
    } 

    public function primeBenefits(Request $request)
    {

        Log::debug("execute....");

        $subject = $request->subject;

        Log::debug("create prompt....");
        $prompt = $this->writeBenefitPrompt($subject);

        $data = array();

        for ($i = 0; $i < 5; $i++) {
            $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
            $data[$i]['subject'] = $subject;
            $data[$i]['phrase'] = $phrase;
            sleep(3);
        }
        
        session(['benefits' => $data]);

        $url = session('url');
        if (!isset($url)) {
            $url = '';
        }

        return json_encode($data);
    } 

    public function createPhrases(Request $request)
    {

        $subject = $request->subject;

        Log::debug("execute....");
       
        $promos = session('promos');
        $benefits = session('benefits');
        $url = session('url');

        $error = '';

        try {
            if (!isset($promos)) {  
                $prompt = $this->writePromoPrompt($subject);     
                for ($i = 0; $i < 3; $i++) {
                    $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
                    $promos[$i]['subject'] = $subject;
                    $promos[$i]['phrase'] = $phrase;
                    sleep(1);
                }
            }
    
            if (!isset($benefits)) { 
                $prompt = $this->writeBenefitPrompt($subject);       
                for ($i = 0; $i < 3; $i++) {
                    $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
                    $benefits[$i]['subject'] = $subject;
                    $benefits[$i]['phrase'] = $phrase;
                    sleep(1);
                }
            }

            session(['promos' => $promos]);
            session(['benefits' => $benefits]);

        } catch(Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            $error = $e->getMessage();
        }

        $phrase = $promos[rand(0, count($promos)-1)]['phrase'] . ' ' . $benefits[rand(0, count($benefits)-1)]['phrase'];
        //$phrase = $promos[1];

        return view('phrase', ['phrase' => $phrase, 'subject' => $subject, 'error' => $error, 'url' => $url]);
    } 

    public function getPhrase(Request $request)
    {

        $subject = $request->subject;

        Log::debug("execute....");
       
        $promos = session('promos');
        $benefits = session('benefits');
        $url = session('url');

        $error = '';

        try {
            if (!isset($promos)) {  
                $prompt = $this->writePromoPrompt($subject);     
                for ($i = 0; $i < 3; $i++) {
                    $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
                    $promos[$i]['subject'] = $subject;
                    $promos[$i]['phrase'] = $phrase;
                    sleep(1);
                }
            }
    
            if (!isset($benefits)) { 
                $prompt = $this->writeBenefitPrompt($subject);       
                for ($i = 0; $i < 3; $i++) {
                    $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
                    $benefits[$i]['subject'] = $subject;
                    $benefits[$i]['phrase'] = $phrase;
                    sleep(1);
                }
            }

            session(['promos' => $promos]);
            session(['benefits' => $benefits]);

        } catch(Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            $error = $e->getMessage();
        }

        $phrase = $promos[rand(0, count($promos)-1)]['phrase'] . ' ' . $benefits[rand(0, count($benefits)-1)]['phrase'];
        //$phrase = $promos[1];

        return json_encode($phrase);
    } 

    function writePromoPrompt($subject) {
        $prompt = 'Write a promotional phrase about a ' . $subject . ' in a catchy and unique way.  Include emojis.';
        return $prompt;
    }

    function writeBenefitPrompt($subject) {
        $prompt = 'Write about a benefit from a ' . $subject . ' in a catchy and unique way.  Include emojis.'; 
        return $prompt;
    }

    function setUpPage(Request $request) {
        $subject = $request->subject;
        $page = $request->page;
        $url = $request->url;

        if (!isset($subject)) {
            $subject = 'casino';
        }

        if (!isset($page)) {
            $page = 'home';
        }

        if (!isset($url)) {
            $url = 'https://enter.casino.com';
        }

        session(['promos' => null]);
        session(['benefits' => null]);
        session(['url' => $url]);

        return view('home', ['subject' => $subject, 'url' => $url, 'message' => 'Values updated successfully.']);
    }
    
    function directory(Request $request) {

        // Start the session
        session_start();
    
        $dir = $_SERVER['DOCUMENT_ROOT'] . '\\html\\';
        $files = scandir($dir);
        //print_r($files);

        $_SESSION['files'] = $files;

        $data = $this->paginate($files);

        //return view('directory', ['files' => $files]);
        return view('directory', compact('data'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
             ]);
    }

    function search(Request $request) {

        // Start the session
        session_start();

        $files = $_SESSION['files'];
        $value = $_POST['search-value'];

        $i = 0;
        $results = array();

        foreach($files as $file) {
            $haystack = $file; 
            $needle   = $value;

            if (strpos($haystack, $needle) !== false) {
                $results[$i] = $file;
                $i++;
            }
        }

        $data = $this->paginate($results);

        //return view('directory', ['files' => $files]);
        return view('directory', compact('data'));
    }

    // Method to call OpenAI to get descriptions
	function openApi($user, $request, $temperature, $tokens, $length, $top, $keyword) {

		$response = '';
		$value = '';

		Log::debug('open api request: ' . $request);

		$client = new Client();

		//'Authorization' => 'Bearer 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'
						
		try {
			$response = $client->request('POST', 'https://api.openai.com/v1/engines/text-davinci-003/completions', [
			'headers' => [
				'Authorization' => 'Bearer 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'
			],
			'json' => [
				'prompt' => $request,
				'temperature' => doubleval($temperature),
				'max_tokens' => intval($tokens),
				'top_p' => doubleval($top)
			]
			]);
		} catch (GuzzleException $e) {
			Log::error('error ' . $e->getMessage());
		}

		$text = $keyword;
		
		if ($response) {
			$data = json_decode($response->getBody(), true);
			$text = $data['choices'][0]['text'];
			Log::debug('open api text ' . $text);	

			Log::debug('status ' . $response->getStatusCode());
			Log::debug('content ' . $response->getBody()->getContents());
				
			//$value = $this->data_stringify($data);

		} else {
			Log::error('error ' . 'openAI failed to fetch data');
		}
	
		return $text;
	}
}