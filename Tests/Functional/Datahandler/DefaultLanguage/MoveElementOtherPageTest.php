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

class MoveElementOtherPageTest extends AbstractDatahandler
{
    /**
     * @test
     */
    public function moveChildElementOutsideContainerAtTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 3,
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
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveChildElementOutsideContainerAtTopResult.csv');
    }

    /**
     * @test
     */
    public function moveChildElementOutsideContainerAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -14,
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
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveChildElementOutsideContainerAfterElementResult.csv');
    }

    /**
     * @test
     */
    public function moveChildElementToOtherColumnTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => '11-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveChildElementToOtherColumnTopResult.csv');
    }

    /**
     * @test
     */
    public function moveChildElementToOtherColumnAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -13,
                        'update' => [
                            'colPos' => '11-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveChildElementToOtherColumnAfterElementResult.csv');
    }

    /**
     * @test
     */
    public function moveElementIntoContainerAtTop(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => '11-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveElementIntoContainerAtTopResult.csv');
    }

    /**
     * @test
     */
    public function moveElementIntoContainerAfterElement(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -13,
                        'update' => [
                            'colPos' => '11-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveElementIntoContainerAfterElementResult.csv');
    }

    /**
     * @test
     */
    public function moveElementIntoContainerAfterElementWithSimpleCommandMap(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        // see test above what should be done
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => -13,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveElementIntoContainerAfterElementWithSimpleCommandMapResult.csv');
    }

    /**
     * @test
     */
    public function moveElementAfterContainerSortElementAfterLastContainerChild(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -11,
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
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveElementAfterContainerSortElementAfterLastContainerChildResult.csv');
    }

    /**
     * @test
     */
    public function moveElementAfterContainerSortElementAfterLastContainerChildSimpleCommand(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/setup.csv');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'move' => -11,
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        self::assertCSVDataSet(__DIR__ . '/Fixtures/MoveElementOtherPage/MoveElementAfterContainerSortElementAfterLastContainerChildSimpleCommandResult.csv');
    }
}
