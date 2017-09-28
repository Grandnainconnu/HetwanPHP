<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:03:54
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:09:43
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class VersionHandler extends AbstractLoginHandler
{
	public function initialize()
	{
		$this->send(LoginMessageFormatter::helloConnectMessage($this->getClient()->key));
	}

	public function handle($version)
	{
		$sameVersion = ($goodVersion = $this->getContainer()->get('configuration')->get('dofus.version')) == $version;

		if (false == $sameVersion)
		{
			$this->send(LoginMessageFormatter::wrongClientVersionMessage($goodVersion));

			return HandlerInterface::FAILED;
		}

		$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\AuthentificationHandler');
	}
}