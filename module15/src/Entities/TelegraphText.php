<?php

namespace App\Entities;

class TelegraphText
{
    private string $title;
    private string $text;
    private string $author;
    private string $published;
    private string $slug;
    public const PATH = './test-search';

    public function __construct(string $author, string $slug)
    {
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date("m.d.y");
    }

    private function storeText(): void
    {
        $data = [
            'title' => $this->title,
            'text' => $this->text,
            'author' => $this->author,
            'published' => $this->published,
        ];
        $dataSerialize = serialize($data);
        file_put_contents(self::PATH . "/{$this->slug}", $dataSerialize);
    }

    private function loadText(): ?string
    {
        $filename = self::PATH . "/{$this->slug}";
        if (file_exists($filename)) {
            $data = unserialize(file_get_contents($filename, true));
            $this->title = $data['title'];
            $this->text = $data['text'];
            $this->author = $data['author'];
            $this->published = $data['published'];
            return $this->text;
        }
        return null;
    }

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function setAuthor(string $value): void
    {
        if (strlen($value) > 120) {
            echo 'Строка содержит более 120 символов' . PHP_EOL;
            return;
        }
        $this->author = $value;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setSlug(string $value): void
    {
        if (!preg_match('/^[A-Za-z0-9-_\'".]+$/', $value)) {
            echo 'Формат строки не соттветствует допустимому' . PHP_EOL;
            return;
        }
        $this->slug = $value;
    }

    public function checklengthText() {

            if (strlen($this->text) < 5) {
                throw new TelegraphException('Format is not valid');
        }
            return 'Format is ok';
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setPublished(string $value): void
    {
        $now = new DateTime();

        $date = DateTime::createFromFormat('Y-m-d', $value);

        if ($date < $now) {
            echo 'Дата не соттветствует допустимой' . PHP_EOL;
            return;
        }
        $this->published = $value;
    }

    public function getPublished(): string
    {
        return $this->published;
    }

    public function __set($name, $value)
    {
        if ($name === 'author') {
            $this->setAuthor($value);
        }

        if ($name === 'slug') {
            $this->setSlug($value);
        }

        if ($name === 'title') {
            $this->storeText();
        }

        if ($name === 'published') {
            $this->setPublished($value);
        }

        if ($name === 'text') {
            $this->storeText();
        }
    }

    public function __get($name)
    {
        if ($name === 'author') {
            return $this->getAuthor();
        }

        if ($name === 'slug') {
            return $this->getSlug();
        }

        if ($name === 'title') {
            return $this->getTitle();
        }

        if ($name === 'published') {
            return $this->getPublished();
        }

        if ($name === 'text') {
            return $this->loadText();
        }
    }

}
