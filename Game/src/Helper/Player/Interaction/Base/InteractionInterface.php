<?php

namespace Hetwan\Helper\Player\Interaction\Base;


interface InteractionInterface
{
    public function begin() : void;
    public function end() : void;
    public function getType() : int;
}