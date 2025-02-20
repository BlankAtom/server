<?php

declare(strict_types=1);

/**
 * @copyright Copyright (c) 2023 Marcel Klehr <mklehr@gmx.net>
 *
 * @author Marcel Klehr <mklehr@gmx.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */


namespace OCP\TextProcessing;

use OCP\Common\Exception\NotFoundException;
use OCP\PreConditionNotMetException;
use RuntimeException;

/**
 * API surface for apps interacting with and making use of LanguageModel providers
 * without known which providers are installed
 * @since 27.1.0
 */
interface IManager {
	/**
	 * @since 27.1.0
	 */
	public function hasProviders(): bool;

	/**
	 * @return class-string<ITaskType>[]
	 * @since 27.1.0
	 */
	public function getAvailableTaskTypes(): array;

	/**
	 * @param Task $task The task to run
	 * @throws PreConditionNotMetException If no or not the requested provider was registered but this method was still called
	 * @throws RuntimeException If something else failed
	 * @since 27.1.0
	 */
	public function runTask(Task $task): string;

	/**
	 * Will schedule an LLM inference process in the background. The result will become available
	 * with the \OCP\LanguageModel\Events\TaskSuccessfulEvent
	 * If inference fails a \OCP\LanguageModel\Events\TaskFailedEvent will be dispatched instead
	 *
	 * @param Task $task The task to schedule
	 * @throws PreConditionNotMetException If no or not the requested provider was registered but this method was still called
	 * @since 27.1.0
	 */
	public function scheduleTask(Task $task) : void;

	/**
	 * @param int $id The id of the task
	 * @return Task
	 * @throws RuntimeException If the query failed
	 * @throws NotFoundException If the task could not be found
	 * @since 27.1.0
	 */
	public function getTask(int $id): Task;
}
