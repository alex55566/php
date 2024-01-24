<?php

namespace App\Entities;

class FileStorage extends Storage
{
    public const PATH = './test-search';

    public function create(object $payload): string
    {
        $slug = $payload->slug;
        $date = date("m.d.y");
        $newSlug = $slug . '_' . $date;

        $counter = 1;
        while (file_exists(self::PATH . "/" . $newSlug)) {
            $newSlug = $slug . '_' . $date . "_" . $counter;
            $counter++;
        }

        $payload->slug = $newSlug;

        $dataSerialize = serialize($payload);

        $filename = self::PATH . "/" . $newSlug;

        file_put_contents(self::PATH . "/" . $newSlug, $dataSerialize);
        if (!file_exists($filename)) {
            var_dump('я не существую');
        }
        return $newSlug;
    }

    public function read(string $slug): ?TelegraphText
    {
        $filename = self::PATH . "/" . $slug;

        if (file_exists($filename)) {
            $data = unserialize(file_get_contents($filename));

            $telegraphText = new TelegraphText($data->author, $slug);
            $telegraphText->title = $data->title;
            $telegraphText->text = $data->text;
            $telegraphText->published = $data->published;

            return $telegraphText;
        }
        return null;
    }

    public function update(string $slug, object $payload): void
    {
        $filename = self::PATH . "/" . $slug;

        if (file_exists($filename)) {

            $dataSerialize = serialize($payload);
            file_put_contents(self::PATH . "/" . $slug, $dataSerialize);
        }
    }

    public function delete(string $slug): void
    {
        $filename = self::PATH . "/" . $slug;
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function list(): array
    {
        $fileList = [];
        $directory = self::PATH . "/";
        $slugs = scandir($directory);

        foreach ($slugs as $slug) {
            if (str_contains($slug, "test.txt")) {

                $filename = self::PATH . "/" . $slug;

                if (file_exists($filename)) {
                    $data = unserialize(file_get_contents($filename));
                    $fileList[] = $data;
                }
            }
        }
        return $fileList;
    }
}