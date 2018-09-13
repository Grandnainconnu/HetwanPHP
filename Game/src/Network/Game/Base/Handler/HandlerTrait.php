<?php

namespace Hetwan\Network\Game\Base\Handler;


trait HandlerTrait
{
    protected function getAccount() : ?\Hetwan\Entity\Login\AccountEntity
    {
        return $this->client->getAccount();
    }

    protected function getPlayer() : ?\Hetwan\Entity\Game\PlayerEntity
    {
        return $this->client->getPlayer();
    }
}