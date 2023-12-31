<?php

namespace Bitrix\Disk\Volume;

use Bitrix\Main;
use Bitrix\Disk\Volume;


interface IVolumeIndicator
{
	/**
	 * Runs measure test to get volumes of selecting objects.
	 * @param array $collectData List types data to collect.
	 * @return static
	 */
	public function measure(array $collectData = []): self;

	/**
	 * Returns measure process stages list.
	 * @return string[]
	 */
	public function getMeasureStages();

	/**
	 * Gets stage id.
	 * @return string|null
	 */
	public function getStage(): ?string;

	/**
	 * Sets current stage id.
	 * @param string|null $stageId Stage id.
	 * @return static
	 */
	public function setStage(?string $stageId): self;

	/**
	 * Recalculates percent from total file size per row selected by filter.
	 * @param string|Volume\IVolumeIndicator $totalSizeIndicator Use this indicator as total volume.
	 * @param string|Volume\IVolumeIndicator $excludeSizeIndicator Exclude indicator's volume from total volume.
	 * @return static
	 */
	public function recalculatePercent($totalSizeIndicator, $excludeSizeIndicator): self;

	/**
	 * Loads file list corresponding to indicator's filter.
	 * @param array $additionalFilter Additional parameters to filter file list.
	 * @return Main\DB\Result
	 */
	public function getCorrespondingFileList(array $additionalFilter = []): Main\DB\Result;

	/**
	 * Loads folder list corresponding to indicator's filter.
	 * @param array $additionalFilter Additional parameters to filter file list.
	 * @return Main\DB\Result
	 */
	public function getCorrespondingFolderList(array $additionalFilter = []): Main\DB\Result;

	/**
	 * Loads file version list corresponding to indicator's filter.
	 * @param array $additionalFilter Additional parameters to filter file list.
	 * @return Main\DB\Result
	 */
	public function getCorrespondingUnnecessaryVersionList(array $additionalFilter = []): Main\DB\Result;

	/**
	 * Preforms data preparation.
	 * @return static
	 */
	public function prepareData(): self;

	/**
	 * @return string The fully qualified name of this class.
	 */
	public static function className(): string;

	/**
	 * @return string The short indicator name of this class.
	 */
	public static function getIndicatorId(): string;

	/**
	 * Deletes objects selecting by filter.
	 * @return static
	 */
	public function purify(): self;

	/**
	 * Returns calculation result set.
	 * @param array $collectedData List types of collected data to return.
	 * @return Main\DB\Result
	 */
	public function getMeasurementResult(array $collectedData = []): Main\DB\Result;

	/**
	 * Unset calculated values.
	 * @return static
	 */
	public function resetMeasurementResult(): self;

	/**
	 * Tells true if total result is available.
	 * @return boolean
	 */
	public function isResultAvailable(): bool;

	/**
	 * Returns total volume size of objects selecting by filter.
	 * @return integer
	 */
	public function getTotalSize();

	/**
	 * Returns total amount of objects selecting by filter.
	 * @return integer
	 */
	public function getTotalCount();

	/**
	 * Returns total volume size of objects on disk.
	 * @return integer
	 */
	public function getDiskSize();

	/**
	 * Returns total amount of objects on disk.
	 * @return integer
	 */
	public function getDiskCount();

	/**
	 * Returns total amount of objects selecting by filter.
	 * @return integer
	 */
	public function getTotalVersion();

	/**
	 * Returns total amount of attached objects selecting by filter.
	 * @return integer
	 */
	public function getTotalAttached();

	/**
	 * Returns total volume size of preview files.
	 * @return double
	 */
	public function getPreviewSize();

	/**
	 * Returns total amount of preview files.
	 * @return double
	 */
	public function getPreviewCount();

	/**
	 * Returns total amount of external links to objects selecting by filter.
	 * @return integer
	 */
	public function getTotalLink();

	/**
	 * Returns total number sharing of objects selecting by filter.
	 * @return integer
	 */
	public function getTotalSharing();

	/**
	 * Returns total amount of files without links and attached object.
	 * @return integer
	 */
	public function getUnnecessaryVersionSize();

	/**
	 * Returns total count of files without links and attached object.
	 * @return integer
	 */
	public function getUnnecessaryVersionCount();

	/**
	 * Returns total amount of objects selecting by filter.
	 * @return integer[]
	 */
	public function loadTotals();

	/**
	 * Finds entity object by filter.
	 * @param string[] $filter Array filter set to find entity object.
	 * @return Volume\Fragment
	 */
	public static function getFragment(array $filter): Volume\Fragment;

	/**
	 * Returns title of the entity object.
	 * @param Volume\Fragment $fragment Entity object.
	 * @return string|null
	 */
	public static function getTitle(Volume\Fragment $fragment): ?string;

	/**
	 * Returns last update time of the entity object.
	 * @param Volume\Fragment $fragment Entity object.
	 * @return Main\Type\DateTime|null
	 */
	public static function getUpdateTime(Volume\Fragment $fragment): ?Main\Type\DateTime;

	/**
	 * Sets filter parameters.
	 * @param string $key Parameter name to filter.
	 * @param string $value Parameter value.
	 * @return static
	 */
	public function addFilter($key, $value): self;

	/**
	 * Gets filter parameters.
	 * @param string[] $defaultFilter Default filter set.
	 * @return array
	 */
	public function getFilter(array $defaultFilter = []): array;

	/**
	 * Gets filter parameter by key.
	 *
	 * @param string $key Parameter name to filter.
	 * @param string $acceptedListModificators List of accepted filter modificator. Defaults are '=<>!@%'.
	 *
	 * @return mixed|null
	 */
	public function getFilterValue($key, $acceptedListModificators = '=<>!@%');

	/**
	 * Clear filter parameters.
	 * @param string $key Parameter name to unset.
	 * @return static
	 */
	public function unsetFilter($key = ''): self;

	/**
	 * Restores filter state from saved $measurement result.
	 * @param int|array $measurementResult The id of result row or row from table.
	 * @return static
	 */
	public function restoreFilter($measurementResult): self;

	/**
	 * Sets filter id.
	 * @param int $filterId Stored filter id.
	 * @return static
	 */
	public function setFilterId($filterId): self;

	/**
	 * Gets stored filter id.
	 * @return int
	 */
	public function getFilterId();

	/**
	 * Sets select field.
	 * @param string $alias Parameter alias.
	 * @param string $statement Parameter value.
	 * @return static
	 */
	public function addSelect($alias, $statement): self;

	/**
	 * Gets select fields.
	 * @return array
	 */
	public function getSelect(): array;

	/**
	 * Sets sort order parameters.
	 * @param string[] $order Sort order parameters and directions.
	 * @return static
	 */
	public function setOrder($order): self;

	/**
	 * Gets sort order parameters
	 * @return array
	 */
	public function getOrder(): array;

	/**
	 * Sets limit result rows count.
	 * @param int $limit Limit value.
	 * @return static
	 */
	public function setLimit($limit): self;

	/**
	 * Gets limit result rows count.
	 * @return int
	 */
	public function getLimit();

	/**
	 * Sets offset in result.
	 * @param int $offset Offset value.
	 * @return static
	 */
	public function setOffset($offset): self;

	/**
	 * Gets offset in result.
	 * @return int
	 */
	public function getOffset();

	/**
	 * Gets owner id.
	 * @return int
	 */
	public function getOwner();

	/**
	 * Sets owner id.
	 * @param int $ownerId User id.
	 * @return static
	 */
	public function setOwner($ownerId): self;
}
