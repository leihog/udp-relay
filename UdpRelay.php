<?php

namespace Gomitech;

Class UdpRelay
{
	protected $host = '127.0.0.1';
	protected $port = 9999;
	protected $channel = null;
	protected $key = null;

	public function __construct($config = [])
	{
		foreach($config as $key => $value) {
			$method = "set{$key}";
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}

	protected function ensureNoSpace($str)
	{
		if (strstr($str, " ") !== false) {
			throw new \Exception("'{$str}' contains whitespace, while non is allowed.");
		}
	}

	public function setHost($host)
	{
		$this->host = $host;
	}

	public function setPort($port)
	{
		if (!is_numeric($port)) {
			throw new \Exception("Port must be numeric.");
		}
	}

	public function setChannel($channel)
	{
		$this->ensureNoSpace($channel);
		$this->channel = $channel;
	}

	public function setKey($key)
	{
		$this->ensureNoSpace($key);
		$this->key = $key;
	}

	public function send($msg)
	{
		$required = ['host', 'port', 'channel'];
		foreach($required as $key) {
			if (empty($this->$key)) {
				throw new \Exception("Required {$key} is missing.");
			}
		}

		$msg = $this->channel ." :". $msg;
		if (!empty($this->key)) {
			$msg = $this->key ." ". $msg;
		}

		$socket = stream_socket_client("udp://{$this->host}:{$this->port}", $code, $error);
		if (!$socket) {
			error_log("UdpRelay: $error ($code)");
			return false;
		}

		stream_set_timeout($socket, 1);
		return (bool)stream_socket_sendto($socket, $msg);
	}
}
