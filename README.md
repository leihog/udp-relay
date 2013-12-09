
UDP Relay
=========

An UDP client for passing messages through a relay
like the UdpRelay plugin for the Minion IRC bot.


The relayed message takes the form

	<key> <channel> :<msg>

where key is optional. Note that because the parts are seperated by a single
space character, spaces are not allowd in the key or channel.

The idea is that Channel would uniquely identify a destination for the passed
message, while the key would be an optional password to ensure that the message
originates from an authorized source.

Note that everything is sent in plain text so do not use for any sensitive data.

Personally I use it to relay git events to an IRC channel.

Example Usage
=============

	$relay = new \Gomitech\UdpRelay(['host' => 'relay.deathstar.gov']);
	$relay->setChannel("AA-23");
	$relay->send("Why aren't you at your post? TK-421, do you copy?");

	$cfg = array(
		'host' => 'relay.coolstartup.com',
		'port' => '1138',
		'key'  => 'secret',
	);
	$relay = new {Gomitech\UdpRelay($cfg);
	$relay->setChannel('#dev');
	$relay->send("Foo just pushed 2 commit(s) to Bar");


