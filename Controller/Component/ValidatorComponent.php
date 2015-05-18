<?php
App::uses('CakeLog', 'Log');

/**
 * ValidatorComponent
 *
 * @uses     Component
 *
 * @author Pedro Ventura
 * @copyright 2015 Pedro Ventura
 * @license MIT
 * @link https://github.com/elpeter/kickbox-cakephp
 */
class ValidatorComponent extends Component {

/**
 * $mesage
 *
 * @var mixed
 *
 * @access public
 */
	public $message = false;

/**
 * $didYouMean
 *
 * @var mixed
 *
 * @access public
 */
	public $didYouMean = false;

/**
 * verify
 * 
 * @param mixed $email Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
	public function verify($email) {
		if (!defined('KICKBOXAPIKEY')) {
			$this->__log('API KEY NOT SETUP!');
			return false;
		}
		if (class_exists('Kickbox\Client')) {
			$client = new Kickbox\Client(KICKBOXAPIKEY);
			$kickbox = $client->kickbox();
			try {
				$this->__log('checking email: ' . $email);
				$response = $kickbox->verify($email);
				$this->__log('response: ' . print_r($response->body, true));
				return $this->__process($response);
			}
			catch (Exception $e) {
				$this->__log("Code: " . $e->getCode() . " Message: " . $e->getMessage());
			}
		} else {
			$this->__log('file autoload.php is missing or cannot be loaded');
			return false;
		}
	}

/**
 * __process
 * 
 * @param mixed $res Description.
 *
 * @access private
 *
 * @return mixed Value.
 */
	private function __process($res) {
		if (!empty($res->body['success']) && ($res->body['success'])) {
			if (!empty($res->body['result'])) {
				//result string - The verification result: deliverable, undeliverable, risky, unknown
				if ($res->body['result'] == 'deliverable') {
					if (!empty($res->body['message'])) {
						$this->message = $res->body['message'];
					}
					if (!empty($res->body['did_you_mean'])) {
						$this->didYouMean = $res->body['did_you_mean'];
					}
					$this->__log('Email verification OK.');
					return true;
				}
			}
		}
		$this->__log('Email verification NOT passed. Check the log file kickbox.log for more details');
		return false;
	}
/**
 * log
 * 
 * @param mixed $message Description.
 *
 * @access private
 *
 * @return mixed Value.
 */
	private function __log($message) {
		if (Configure::read('KickboxEmail.log')) {
			CakeLog::write('kickbox', $message);
		}
	}
}
