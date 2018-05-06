<?php
// Setup system and load controller
define('T',microtime(TRUE));
define('M',memory_get_usage());
define('AJAX',strtolower(getenv('HTTP_X_REQUESTED_WITH'))==='xmlhttprequest');
define('URI', '/');

// Basic functions
function __autoload($c){require __DIR__.strtolower(str_replace('_','/',"/classes/$c.php"));}
function config($k){static$c;$c=$c?$c:require __DIR__.'/config.php';return$c[$k];}
function post($k,$d=NULL){return isset($_POST[$k])?$_POST[$k]:$d;}
function get($k,$d=NULL){return isset($_GET[k])?$_GET[$k]:$d;}
function utf8($s,$f='UTF-8'){return @iconv($f,$f,$s);}
function dump($d){$s='<pre>';foreach(func_get_args() as$a)$s.=print_r($a,TRUE);return$s.'</pre>';}

// Parse URI
$url=explode('/',preg_replace('#[^\w\-/\.]#i','',trim(substr($_SERVER['REQUEST_URI'],strlen(URI)),'/')))+array('','');

// Load response object
$response = new Response;

// Lets get going!
try
{
	if(config('debug_mode')) $response->addMessage('Loading: '. $url[0].'/'.$url[1]);
	
	if(!is_file(__DIR__.'/classes/model/'.strtolower($url[0]).'.php'))
	{
		throw new Exception('Invalid Request');
	}
	
	// Load model
	$model = 'Model_'.$url[0];
	$model = new $model;

	// Load reflection
	$modelReflector = new ReflectionClass($model);

	// Does the method exist?
	if( ! $modelReflector->hasMethod($url[1]))
	{
		throw new Exception('Invalid Request');
	}
	
	// Get method
	$method = $modelReflector->getMethod($url[1]);

	// Is the method public?
	if( ! $method->isPublic())
	{
		throw new Exception('Invalid Request');
	}
	
	// Does this method require input?
	if($method->getParameters())
	{
		$params = array();
		foreach($method->getParameters() as $param)
		{
			$name = $param->getName();
			$value = post($name);
			
			if($class = $param->getClass())
			{
				$class = $class->getName();
				$class = new $class($name, $value);
				if( ! $class->validate())
				{
					$response->addValidationError($name, $class->error());
					continue;
				}
				$value = $class;
			}
			// Ignore optional parameters that are empty - use default value
			elseif($param->isOptional() && empty($value))
			{
				$params[$name] = $param->getDefaultValue();
				continue;
			}
			else // If its not a class (or optional) then...
			{
				if(is_int($param->getDefaultValue())) // An integer?
				{
					if( ! ctype_digit($value))
					{
						$response->addValidationError($name, '%s is not numeric');
						continue;
					}
				}
				elseif(is_string($param->getDefaultValue())) // A string?
				{
					if( ! is_string($value))
					{
						$response->addValidationError($name, $name. '%s is not a string');
						continue;
					}
				}
				else // An array?
				{
					if( ! is_array($value))
					{
						$response->addValidationError($name, '%s is not an array');
						continue;
					}
				}
			}
			
			// Save!
			$params[$name] = $value;
		}
		
		// Errors!
		if($response->validation) throw new Exception('Error with form submission');
		
		// Now we can call the method!
		$response->addData(call_user_func_array(array($model,$url[1]),$params));
	}
	else
	{
		// No params required!
		$response->addData($model->$url[1]);
	}
}
catch (Exception $e)
{
	// If we didn't already send a header
	headers_sent() or header('HTTP/1.1 500 Internal Server Error');
	
	// Log error
	error_log($e->getMessage(). ' in file '. $e->getFile(). ':'. $e->getLine());
	
	// Alert user
	$response->addError($e->getMessage());
}

if(config('debug_mode'))
{
	$response->addMessage((microtime(TRUE)-T).' seconds and '. (memory_get_usage()-M).' bytes');
}

print $response;
