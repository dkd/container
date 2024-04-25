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

class ContainerTest extends AbstractDatahandler
{
    /**
     * @test
     */
    public function moveContainerIntoItSelfsNestedAfterElement(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_into_itselfs_nested.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsNestedAfterElement.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => -3,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsNestedAfterElementResult.csv');
        $row = $this->fetchOneRecord('uid', 1);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertNotEmpty($this->dataHandler->errorLog, 'dataHander error log is empty');
    }

    /**
     * @test
     */
    public function moveContainerIntoItSelfsNestedAtTop(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_into_itselfs_nested.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsNestedAtTop.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 2,
                        'update' => [
                            'colPos' => '2-202',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsNestedAtTopResult.csv');
        $row = $this->fetchOneRecord('uid', 1);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertNotEmpty($this->dataHandler->errorLog, 'dataHander error log is empty');
    }

    /**
     * @test
     */
    public function moveContainerIntoItSelfsAtTop(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_into_itselfs_nested.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsAtTop.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 2,
                        'update' => [
                            'colPos' => '1-202',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerIntoItSelfsAtTopResult.csv');
        $row = $this->fetchOneRecord('uid', 1);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertNotEmpty($this->dataHandler->errorLog, 'dataHander error log is empty');
    }

    /**
     * @test
     */
    public function deleteContainerDeleteChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/delete_container.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/DeleteContainerDeleteChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'delete' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/DeleteContainerDeleteChildrenResult.csv');
        $row = $this->fetchOneRecord('uid', 1);
        self::assertSame(1, $row['deleted']);
        $row = $this->fetchOneRecord('uid', 2);
        self::assertSame(1, $row['deleted']);
    }

    /**
     * @test
     */
    public function moveContainerAfterElementMovesChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_after_element.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerAfterElementMovesChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
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
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerAfterElementMovesChildrenResult.csv');
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(1, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function moveContainerToOtherPageAtTopMovesChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_other_page_on_top.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerToOtherPageAtTopMovesChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
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
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerToOtherPageAtTopMovesChildrenResult.csv');
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerToOtherPageAtTopCopiesChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/copy_container_other_page_on_top.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerToOtherPageAtTopCopiesChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerToOtherPageAtTopCopiesChildrenResult.csv');
        $copiedRecord = $this->fetchOneRecord('t3_origuid', 1);
        $child = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame($copiedRecord['uid'], $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        self::assertTrue($child['sorting'] > $copiedRecord['sorting'], 'copied child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerToOtherPageAfterElementCopiesChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/copy_container_other_page_after_element.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerToOtherPageAfterElementCopiesChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -14,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerToOtherPageAfterElementCopiesChildrenResult.csv');
        $copiedRecord = $this->fetchOneRecord('t3_origuid', 1);
        $child = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame($copiedRecord['uid'], $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertTrue($child['sorting'] > $copiedRecord['sorting'], 'copied child is sorted before container');
        $targetElement = $this->fetchOneRecord('uid', 14);
        self::assertTrue($child['sorting'] > $targetElement['sorting'], 'copied child is sorted before target element');
    }

    /**
     * @test
     */
    public function moveContainerToOtherPageAfterElementMovesChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_container_other_page_after_element.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerToOtherPageAfterElementMovesChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
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
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerToOtherPageAfterElementMovesChildrenResult.csv');
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerKeepsSortingOfChildren(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/copy_container_keeps_sorting.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerKeepsSortingOfChildren.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerKeepsSortingOfChildrenResult.csv');
        $child = $this->fetchOneRecord('t3_origuid', 2);
        $secondChild = $this->fetchOneRecord('t3_origuid', 5);
        self::assertTrue($child['sorting'] < $secondChild['sorting']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'copied child is sorted before container');
    }

    /**
     * @test
     */
    public function moveContainerOtherPageOnTop(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_or_copy_container_other_page.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerOtherPageOnTop.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => 3,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerOtherPageOnTopResult.csv');
        $container = $this->fetchOneRecord('uid', 1);
        $col1First = $this->fetchOneRecord('uid', 2);
        $col1Second = $this->fetchOneRecord('uid', 3);
        $col12First = $this->fetchOneRecord('uid', 4);
        $outside = $this->fetchOneRecord('uid', 10);
        // pid 3 for container and all children
        self::assertSame(3, $container['pid']);
        self::assertSame(3, $col1First['pid']);
        self::assertSame(3, $col1Second['pid']);
        self::assertSame(3, $col12First['pid']);
        // all children are still in container
        self::assertSame($container['uid'], $col1First['tx_container_parent']);
        self::assertSame($container['uid'], $col1Second['tx_container_parent']);
        self::assertSame($container['uid'], $col12First['tx_container_parent']);
        // all children keeps colPos
        self::assertSame(200, $col1First['colPos']);
        self::assertSame(200, $col1Second['colPos']);
        self::assertSame(201, $col12First['colPos']);
        // sorting 1,2,3,4,10
        self::assertTrue($container['sorting'] < $col1First['sorting']);
        self::assertTrue($col1First['sorting'] < $col1Second['sorting']);
        self::assertTrue($col1Second['sorting'] < $col12First['sorting']);
        self::assertTrue($col12First['sorting'] < $outside['sorting']);
    }

    /**
     * @test
     */
    public function moveContainerOtherPageAfterElement(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_or_copy_container_other_page.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerOtherPageAfterElement.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => -10,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/MoveContainerOtherPageAfterElementResult.csv');
        $container = $this->fetchOneRecord('uid', 1);
        $col1First = $this->fetchOneRecord('uid', 2);
        $col1Second = $this->fetchOneRecord('uid', 3);
        $col12First = $this->fetchOneRecord('uid', 4);
        $outside = $this->fetchOneRecord('uid', 10);
        // pid 3 for container and all children
        self::assertSame(3, $container['pid']);
        self::assertSame(3, $col1First['pid']);
        self::assertSame(3, $col1Second['pid']);
        self::assertSame(3, $col12First['pid']);
        // all children are still in container
        self::assertSame($container['uid'], $col1First['tx_container_parent']);
        self::assertSame($container['uid'], $col1Second['tx_container_parent']);
        self::assertSame($container['uid'], $col12First['tx_container_parent']);
        // all children keeps colPos
        self::assertSame(200, $col1First['colPos']);
        self::assertSame(200, $col1Second['colPos']);
        self::assertSame(201, $col12First['colPos']);
        // sorting 10,1,2,3,4
        self::assertTrue($outside['sorting'] < $container['sorting']);
        self::assertTrue($container['sorting'] < $col1First['sorting']);
        self::assertTrue($col1First['sorting'] < $col1Second['sorting']);
        self::assertTrue($col1Second['sorting'] < $col12First['sorting']);
    }

    /**
     * @test
     */
    public function copyContainerOtherPageOnTop(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_or_copy_container_other_page.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerOtherPageOnTop.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerOtherPageOnTopResult.csv');
        $container = $this->fetchOneRecord('t3_origuid', 1);
        $col1First = $this->fetchOneRecord('t3_origuid', 2);
        $col1Second = $this->fetchOneRecord('t3_origuid', 3);
        $col12First = $this->fetchOneRecord('t3_origuid', 4);
        $outside = $this->fetchOneRecord('uid', 10);
        // pid 3 for container and all children
        self::assertSame(3, $container['pid']);
        self::assertSame(3, $col1First['pid']);
        self::assertSame(3, $col1Second['pid']);
        self::assertSame(3, $col12First['pid']);
        // container parent $container['uid'] for all children
        self::assertSame($container['uid'], $col1First['tx_container_parent']);
        self::assertSame($container['uid'], $col1Second['tx_container_parent']);
        self::assertSame($container['uid'], $col12First['tx_container_parent']);
        // all children keeps colPos
        self::assertSame(200, $col1First['colPos']);
        self::assertSame(200, $col1Second['colPos']);
        self::assertSame(201, $col12First['colPos']);
        // sorting 1,2,3,4,10
        self::assertTrue($container['sorting'] < $col1First['sorting']);
        self::assertTrue($col1First['sorting'] < $col1Second['sorting']);
        self::assertTrue($col1Second['sorting'] < $col12First['sorting']);
        self::assertTrue($col12First['sorting'] < $outside['sorting']);
    }

    /**
     * @test
     */
    public function copyContainerOtherPageAfterElement(): void
    {
        //$this->importCSVDataSet(__DIR__ . '/Fixtures/Container/move_or_copy_container_other_page.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerOtherPageAfterElement.csv');
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__, false);
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -10,
                        'update' => [],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Container/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Container/CopyContainerOtherPageAfterElementResult.csv');
        $container = $this->fetchOneRecord('t3_origuid', 1);
        $col1First = $this->fetchOneRecord('t3_origuid', 2);
        $col1Second = $this->fetchOneRecord('t3_origuid', 3);
        $col12First = $this->fetchOneRecord('t3_origuid', 4);
        $outside = $this->fetchOneRecord('uid', 10);
        // pid 3 for container and all children
        self::assertSame(3, $container['pid']);
        self::assertSame(3, $col1First['pid']);
        self::assertSame(3, $col1Second['pid']);
        self::assertSame(3, $col12First['pid']);
        // container parent $container['uid'] for all children
        self::assertSame($container['uid'], $col1First['tx_container_parent']);
        self::assertSame($container['uid'], $col1Second['tx_container_parent']);
        self::assertSame($container['uid'], $col12First['tx_container_parent']);
        // all children keeps colPos
        self::assertSame(200, $col1First['colPos']);
        self::assertSame(200, $col1Second['colPos']);
        self::assertSame(201, $col12First['colPos']);
        // sorting 10,1,2,3,4
        self::assertTrue($outside['sorting'] < $container['sorting']);
        self::assertTrue($container['sorting'] < $col1First['sorting']);
        self::assertTrue($col1First['sorting'] < $col1Second['sorting']);
        self::assertTrue($col1Second['sorting'] < $col12First['sorting']);
    }
}
