<?php

declare(strict_types=1);

namespace B13\Container\Tests\Functional\Datahandler\Localization;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Functional\Datahandler\AbstractDatahandler;
use TYPO3\CMS\Core\Database\Connection;

class LocalizeTest extends AbstractDatahandler
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->linkSiteConfigurationIntoTestInstance();
    }

    /**
     * @test
     */
    public function copyChildToLanguageFixContainerParent(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/copy_child_to_language.csv');
        $cmdmap = [
            'tt_content' => [
                72 => [
                    'copyToLanguage' => 1,
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/CopyChildToLanguageFixContainerParentResult.csv');
        $child = $this->fetchOneRecord('t3_origuid', 72);
        self::assertSame(73, $child['tx_container_parent'], 'container parent should have uid of translated container');
    }

    /**
     * @test
     */
    public function copyContainerToLanguageCopiesChildren(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/copy_container_to_language.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copyToLanguage' => 1,
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/CopyContainerToLanguageCopiesChildrenResult.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 2);
        $translatedContainerRow = $this->fetchOneRecord('t3_origuid', 1);
        self::assertSame($translatedContainerRow['uid'], $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(0, $translatedChildRow['l18n_parent']);
    }

    /**
     * @test
     */
    public function localizeContainerLocalizeChildren(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_container.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'localize' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeContainerLocalizeChildrenResult.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(1, $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(2, $translatedChildRow['l18n_parent']);
    }

    /**
     * @test
     */
    public function localizeContainerFromNonDefaultLanguageLocalizeChildren(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_container_from_non_default_language.csv');
        $cmdmap = [
            'tt_content' => [
                21 => [
                    'localize' => 2,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeContainerFromNonDefaultLanguageLocalizeChildrenResult.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 22);
        self::assertSame(1, $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(2, $translatedChildRow['l18n_parent']);
        self::assertSame(22, $translatedChildRow['l10n_source']);
    }

    /**
     * @test
     */
    public function copyToLanguageContainerFromNonDefaultLanguageLocalizeChildren(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/copy_to_language_container_from_non_default_language.csv');
        $cmdmap = [
            'tt_content' => [
                21 => [
                    'copyToLanguage' => 2,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/CopyToLanguageContainerFromNonDefaultLanguageLocalizeChildrenResult.csv');
        $translatedContainerRow = $this->fetchOneRecord('t3_origuid', 21);
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 22);
        self::assertSame($translatedContainerRow['uid'], $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(0, $translatedChildRow['l18n_parent']);
        self::assertSame(22, $translatedChildRow['l10n_source']);
    }

    /**
     * @test
     */
    public function copyToLanguageContainerFromNonDefaultLanguageLocalizeChildrenWhenCopiedFromFreeMode(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/copy_to_language_container_from_non_default_language_free_mode.csv');
        $cmdmap = [
            'tt_content' => [
                51 => [
                    'copyToLanguage' => 2,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/CopyToLanguageContainerFromNonDefaultLanguageLocalizeChildrenWhenCopiedFromFreeModeResult.csv');
        $translatedContainerRow = $this->fetchOneRecord('t3_origuid', 51);
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 52);
        self::assertSame($translatedContainerRow['uid'], $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(0, $translatedChildRow['l18n_parent']);
        self::assertSame(52, $translatedChildRow['l10n_source']);
    }

    /**
     * @test
     */
    public function localizeChildFailedIfContainerIsInFreeMode(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_child_failed_if_container_is_in_free_mode.csv');
        $cmdmap = [
            'tt_content' => [
                72 => [
                    'localize' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeChildFailedIfContainerIsInFreeModeResult.csv');
        $queryBuilder = $this->getQueryBuilder();
        $row = $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    't3_origuid',
                    $queryBuilder->createNamedParameter(72, Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchAssociative();
        self::assertFalse($row);
        self::assertNotEmpty($this->dataHandler->errorLog, 'dataHander error log is empty');
    }

    /**
     * @test
     */
    public function localizeChildFailedIfContainerIsNotTranslated(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_child_failed_if_container_is_not_translated.csv');
        $cmdmap = [
            'tt_content' => [
                72 => [
                    'localize' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeChildFailedIfContainerIsNotTranslatedResult.csv');
        $queryBuilder = $this->getQueryBuilder();
        $row = $queryBuilder->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    't3_origuid',
                    $queryBuilder->createNamedParameter(72, Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchAssociative();
        self::assertFalse($row, 'child should not be translated');
        self::assertNotEmpty($this->dataHandler->errorLog, 'dataHander error log should be empty');
    }

    /**
     * @test
     */
    public function localizeChildKeepsRelationsIfContainerIsInConnectedMode(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_child_keeps_relation_if_container_is_in_connected_mode.csv');
        $cmdmap = [
            'tt_content' => [
                82 => [
                    'localize' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeChildKeepsRelationsIfContainerIsInConnectedModeResult.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 82);
        self::assertSame(81, $translatedChildRow['tx_container_parent']);
        self::assertSame(200, $translatedChildRow['colPos']);
        self::assertSame(1, $translatedChildRow['pid']);
        self::assertSame(82, $translatedChildRow['l18n_parent']);
    }

    /**
     * @return array
     */
    public function localizeTwoContainerKeepsParentIndependedOnOrderDataProvider(): array
    {
        return [
            ['cmdmap' => [
                'tt_content' => [
                    91 => ['localize' => 1],
                    1 => ['localize' => 1],
                ],
            ], 'Dataset1'],
            ['cmdmap' => [
                'tt_content' => [
                    1 => ['localize' => 1],
                    91 => ['localize' => 1],
                ],
            ], 'Dataset2'],
        ];
    }

    /**
     * @test
     * @dataProvider localizeTwoContainerKeepsParentIndependedOnOrderDataProvider
     */
    public function localizeTwoContainerKeepsParentIndependedOnOrder(array $cmdmap, string $dataset): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_container_keeps_parent_indepented_on_order.csv');
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__ . $dataset);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeTwoContainerKeepsParentIndependedOnOrder' . $dataset . 'Result.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(1, $translatedChildRow['tx_container_parent']);
        $secondChildRow = $this->fetchOneRecord('t3_origuid', 92);
        self::assertSame(91, $secondChildRow['tx_container_parent']);
    }

    /**
     * @return array
     */
    public function localizeWithCopyTwoContainerChangeParentIndependedOnOrderDataProvider(): array
    {
        return [
            ['cmdmap' => [
                'tt_content' => [
                    91 => ['copyToLanguage' => 1],
                    1 => ['copyToLanguage' => 1],
                ],
            ], 'Dataset1'],
            ['cmdmap' => [
                'tt_content' => [
                    1 => ['copyToLanguage' => 1],
                    91 => ['copyToLanguage' => 1],
                ],
            ], 'Dataset2'],
        ];
    }

    /**
     * @test
     * @dataProvider localizeWithCopyTwoContainerChangeParentIndependedOnOrderDataProvider
     */
    public function localizeWithCopyTwoContainerChangeParentIndependedOnOrder(array $cmdmap, string $dataset): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_container_keeps_parent_indepented_on_order.csv');
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__ . $dataset);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeWithCopyTwoContainerChangeParentIndependedOnOrder' . $dataset . 'Result.csv');
        $translatedChildRow = $this->fetchOneRecord('t3_origuid', 2);
        $translatedContainer = $this->fetchOneRecord('t3_origuid', 1);
        self::assertSame($translatedContainer['uid'], $translatedChildRow['tx_container_parent']);
        $secondChildRow = $this->fetchOneRecord('t3_origuid', 92);
        $secondContainer = $this->fetchOneRecord('t3_origuid', 91);
        self::assertSame($secondContainer['uid'], $secondChildRow['tx_container_parent']);
    }

    /**
     * @test
     */
    public function localizeElementAfterAlreadyLocalizedContainerIsSortedAfterContainer(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Localize/localize_element_after_already_localized_container.csv');
        $cmdmap = [
            'tt_content' => [3 => ['localize' => 1]],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $this->writeCsv(__DIR__, '/Fixtures/Localize/', __METHOD__);
        self::assertCSVDataSet(__DIR__ . '/Fixtures/Localize/LocalizeElementAfterAlreadyLocalizedContainerIsSortedAfterContainerResult.csv');
        $translatedRow = $this->fetchOneRecord('t3_origuid', 3);
        self::assertTrue($translatedRow['sorting'] > 512);
    }
}
