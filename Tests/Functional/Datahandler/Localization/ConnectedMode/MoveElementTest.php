<?php

declare(strict_types=1);

namespace B13\Container\Tests\Functional\Datahandler\Localization\ConnectedMode;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Functional\Datahandler\AbstractDatahandler;

class MoveElementTest extends AbstractDatahandler
{
    /**
     * @test
     */
    public function moveChildElementOutsideContainerAtTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveChildElementOutsideContainerAtTopResult.csv');
        $row = $this->fetchOneRecord('uid', 22);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function moveChildElementOutsideContainerAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -4,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveChildElementOutsideContainerAfterElementResult.csv');
        $row = $this->fetchOneRecord('uid', 22);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function moveChildElementToOtherColumnTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveChildElementToOtherColumnTopResult.csv');
        $row = $this->fetchOneRecord('uid', 22);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function moveChildElementToOtherColumnAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -3,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveChildElementToOtherColumnAfterElementResult.csv');
        $row = $this->fetchOneRecord('uid', 22);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function moveElementIntoContainerAtTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveElementIntoContainerAtTopResult.csv');
        $row = $this->fetchOneRecord('uid', 24);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function moveElementIntoContainerAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElement/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -3,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/MoveElement/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElement/MoveElementIntoContainerAfterElementResult.csv');
        $row = $this->fetchOneRecord('uid', 24);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(1, (int)$row['sys_language_uid']);
    }
}
