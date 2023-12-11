<?php

declare(strict_types=1);

namespace Kuvardin\TelegramBotsApi\Types;

use Kuvardin\TelegramBotsApi\Type;

/**
 * This object represents a general file (as opposed to <a
 * href="https://core.telegram.org/bots/api#photosize">photos</a>, <a
 * href="https://core.telegram.org/bots/api#voice">voice messages</a> and <a
 * href="https://core.telegram.org/bots/api#audio">audio files</a>).
 *
 * @package Kuvardin\TelegramBotsApi
 * @author Maxim Kuvardin <maxim@kuvard.in>
 */
class Document extends FileAbstract
{
    /**
     * @deprecated Deprecated in v6.6. Use ->thumbnail instead
     */
    public ?PhotoSize $thumb = null;

    /**
     * @param string $file_id Identifier for this file, which can be used to download or reuse the file
     * @param string $file_unique_id Unique identifier for this file, which is supposed to be the same over time and
     *     for different bots. Can't be used to download or reuse the file.
     * @param PhotoSize|null $thumbnail Document thumbnail as defined by sender
     * @param string|null $file_name Original filename as defined by sender
     * @param string|null $mime_type MIME type of the file as defined by sender
     * @param int|null $file_size File size in bytes. It can be bigger than 2^31 and some programming languages may
     *     have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed
     *     64-bit integer or double-precision float type are safe for storing this value.
     */
    public function __construct(
        string $file_id,
        string $file_unique_id,
        public ?PhotoSize $thumbnail = null,
        public ?string $file_name = null,
        public ?string $mime_type = null,
        ?int $file_size = null,
    )
    {
        $this->file_id = $file_id;
        $this->file_unique_id = $file_unique_id;
        $this->file_size = $file_size;
        $this->thumb = $this->thumbnail;
    }

    public static function makeByArray(array $data): self
    {
        return new self(
            file_id: $data['file_id'],
            file_unique_id: $data['file_unique_id'],
            thumbnail: isset($data['thumbnail'])
                ? PhotoSize::makeByArray($data['thumbnail'])
                : null,
            file_name: $data['file_name'] ?? null,
            mime_type: $data['mime_type'] ?? null,
            file_size: $data['file_size'] ?? null,
        );
    }

    public function getRequestData(): array
    {
        return [
            'file_id' => $this->file_id,
            'file_unique_id' => $this->file_unique_id,
            'thumbnail' => $this->thumbnail,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'file_size' => $this->file_size,
        ];
    }
}
