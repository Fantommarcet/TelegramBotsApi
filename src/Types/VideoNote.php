<?php

declare(strict_types=1);

namespace Kuvardin\TelegramBotsApi\Types;

/**
 * This object represents a <a href="https://telegram.org/blog/video-messages-and-telescope">video message</a>
 * (available in Telegram apps as of <a href="https://telegram.org/blog/video-messages-and-telescope">v.4.0</a>).
 *
 * @package Kuvardin\TelegramBotsApi
 * @author Maxim Kuvardin <maxim@kuvard.in>
 */
class VideoNote extends FileAbstract
{
    /**
     * @deprecated Deprecated in v6.6. Use ->thumbnail instead
     */
    public ?PhotoSize $thumb = null;

    /**
     * @param string $file_id Identifier for this file, which can be used to download or reuse the file
     * @param string $file_unique_id Unique identifier for this file, which is supposed to be the same over time and
     *     for different bots. Can't be used to download or reuse the file.
     * @param int $length Video width and height (diameter of the video message) as defined by sender
     * @param int $duration Duration of the video in seconds as defined by sender
     * @param PhotoSize|null $thumbnail Video thumbnail
     * @param int|null $file_size File size in bytes
     */
    public function __construct(
        string $file_id,
        string $file_unique_id,
        public int $length,
        public int $duration,
        public ?PhotoSize $thumbnail = null,
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
            length: $data['length'],
            duration: $data['duration'],
            thumbnail: isset($data['thumbnail'])
                ? PhotoSize::makeByArray($data['thumbnail'])
                : null,
            file_size: $data['file_size'] ?? null,
        );
    }

    public function getRequestData(): array
    {
        return [
            'file_id' => $this->file_id,
            'file_unique_id' => $this->file_unique_id,
            'length' => $this->length,
            'duration' => $this->duration,
            'thumbnail' => $this->thumbnail,
            'file_size' => $this->file_size,
        ];
    }
}
