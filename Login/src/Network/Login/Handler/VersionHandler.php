<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:03:54
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-20 13:39:18
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class VersionHandler extends \Hetwan\Network\Login\Handler\Base\Handler
{
	public function initialize() : void
	{
		$this->send(LoginMessageFormatter::helloConnectMessage($this->client->key));
	}

	public function handle(string $version) : bool
	{
		$sameVersion = ($goodVersion = $this->configuration->get('dofus.version')) === $version;

		if ($sameVersion === false) {
			$this->send(LoginMessageFormatter::badClientVersionMessage($goodVersion));

			return false;
		}

		$this->client->setHandler(AuthentificationHandler::class);

		return true;
	}
}