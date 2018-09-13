<?php

namespace Hetwan\Helper\Console\Command\Base;


interface CommandInterface
{
    public function execute(array $arguments, int $playerId);
}