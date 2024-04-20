<?php

declare(strict_types=1);

namespace B13\Container\Tests\Functional\Datahandler\DefaultLanguage;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Functional\Datahandler\AbstractDatahandler;
use TYPO3\CMS\Core\Utility\StringUtility;

class NewElementTest extends AbstractDatahandler
{
    /**
     * @test
     */
    public function newElementAfterContainerSortElementAfterLastChild(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/NewElement/setup.csv');
        $newId = StringUtility::getUniqueId('NEW');
        $datamap = [
            'tt_content' => [
                $newId => [
                    'pid' => -1,
                ],
            ],
        ];
        $this->dataHandler->start($datamap, [], $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();

        $newRecord = $this->fetchOneRecord('uid', 3);
        $lastChildInContainer = $this->fetchOneRecord('uid', 2);
        self::assertTrue($newRecord['sorting'] > $lastChildInContainer['sorting'], 'new element is not sorted after last child in container');
    }

    /**
     * @test
     */
    public function newElementAfterNestedContainerSortElementAfterLastChild(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/NewElement/nested_container.csv');
        $newId = StringUtility::getUniqueId('NEW');
        $datamap = [
            'tt_content' => [
                $newId => [
                    'pid' => -3,
                    'colPos' => 201,
                    'tx_container_parent' => 2,
                ],
            ],
        ];
        $this->dataHandler->start($datamap, [], $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();

        $newRecord = $this->fetchOneRecord('uid', 5);
        $lastChildInContainer = $this->fetchOneRecord('uid', 4);
        self::assertTrue($newRecord['sorting'] > $lastChildInContainer['sorting'], 'new element is not sorted after last child in container');
    }
}
