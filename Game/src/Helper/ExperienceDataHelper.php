<?php

namespace Hetwan\Helper;

use Hetwan\Entity\Game\ExperienceDataEntity;

final class ExperienceDataHelper
{
    /**
     * @Inject
     * @var \Hetwan\Core\EntityManager
     */
    private $entityManager;

    public function getWithLevel(int $level) : ?array
    {
        return $this->entityManager->get()
                                   ->getRepository(ExperienceDataEntity::class)
                                   ->getExperienceData($level);
    }
}
