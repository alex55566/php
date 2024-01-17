<?php

class TelegraphText {
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
        file_put_contents(self::PATH."/{$this->slug}",  $dataSerialize );
    }

    private function loadText(): ?string
    {
        $filename = self::PATH."/{$this->slug}";
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
            echo 'Строка содержит более 120 символов' .PHP_EOL;
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
            echo 'Формат строки не соттветствует допустимому' .PHP_EOL;
            return;
        }
        $this->slug = $value;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setPublished(string $value): void
    {
        $now = new DateTime();

        $date = DateTime::createFromFormat('Y-m-d', $value);

        if ($date < $now) {
            echo 'Дата не соттветствует допустимой' .PHP_EOL;
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
        if($name === 'author') {
            $this->setAuthor($value);
        }

        if($name === 'slug') {
            $this->setSlug($value);
        }

        if($name === 'published') {
            $this->setPublished($value);
        }

        if($name === 'text') {
            $this->storeText();
        }
    }

    public function __get($name)
    {
        if($name === 'author') {
            return $this->getAuthor();
        }

        if($name === 'slug') {
            return $this->getSlug();
        }

        if($name === 'published') {
            return $this->getPublished();
        }

        if($name === 'text') {
            return $this->loadText();
        }
    }

}

$telegraph = new TelegraphText('Alex', 'test.txt');
$telegraph->editText('Text', 'TextContent');

$telegraph->author = "AlexNew";
echo $telegraph->author. PHP_EOL;

$telegraph->slug = "test.txt";
echo $telegraph->slug. PHP_EOL;

$telegraph->published = ('2024-01-17');
echo $telegraph->published. PHP_EOL;

$telegraph->text = '';
echo $telegraph->text. PHP_EOL;

//$telegraph->storeText();
//
//var_dump($telegraph->loadText());

//$telegraphNew = new TelegraphText('Alex', 'test.txt');
//$telegraphNew->editText('TextNew', 'TextContentNew');
//$telegraphNew->storeText();
//
//var_dump($telegraphNew->loadText());

abstract class Storage {

    abstract public function create(object $payload): string;

    abstract public function read(string $slug): ?TelegraphText;

    abstract public function update(string $slug, object $payload): void;

    abstract public function delete(string $slug): void;

    abstract public function list(): array;
}

class FileStorage extends Storage {
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
        file_put_contents(self::PATH . "/" . $newSlug, $dataSerialize);
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
        $directory = self::PATH . "/" ;
        $slugs = scandir($directory);

        foreach ($slugs as $slug) {
            if(str_contains($slug, "test.txt")) {

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

//$fileStorage = new FileStorage();
//var_dump($fileStorage->create($telegraph));
//var_dump($fileStorage->read('test.txt_01.09.24_2'));
//var_dump($fileStorage->update('test.txt_01.09.24_2', $telegraphNew  ));
//var_dump($fileStorage->read('test.txt_01.09.24_2'));
//var_dump($fileStorage->delete('test.txt_01.09.24_2'));
//var_dump($fileStorage->read('test.txt_01.09.24_2'));
//var_dump($fileStorage->list());

interface IRender
{
    public function render(TelegraphText $telegraphText): ?string;
}

abstract class View implements IRender
{
    protected array $variables = [];
    protected string $templateName;

    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    public function loadTemplateContent(): ?string
    {
        $filePath = sprintf('templates/%s', $this->templateName);
        if (file_exists($filePath)) {
            return file_get_contents($filePath);

        }
        return null;
    }

    public function addVariablesToTemplate(array $variables): void
    {
        $this->variables = $variables;
    }
}

class Swig extends View
{
    public function render(TelegraphText $telegraphText): ?string
    {
        $content = $this->loadTemplateContent();

        if (!is_null($content)) {
            foreach ($this->variables as $key) {
                $content = str_replace('{{ ' .$key. ' }}', $telegraphText->$key, $content);
            }

            return $content;
        }

        return null;
    }
}

class Spl extends View
{
    public function render(TelegraphText $telegraphText): ?string
    {
        $content = $this->loadTemplateContent();

        if (!is_null($content))  {
            foreach ($this->variables as $key) {
                $content = str_replace('$$' .$key. '$$', $telegraphText->$key, $content);
            }

            return $content;
        }

        return null;
    }
}

//$telegraphText = new TelegraphText('Vasa', 'Some slug');
//$telegraphText->editText('Some title', 'Some text');
//
//$swig = new Swig('telegraph_text-swig.txt');
//$swig->addVariablesToTemplate(['slug', 'text']);
//
//$spl = new Spl('telegraph_text-spl.txt');
//$spl->addVariablesToTemplate(['slug', 'title', 'text']);
//
//$templateEngines = [$swig, $spl];
//foreach($templateEngines as $engine) {
//    if ($engine instanceof IRender) {
//        echo $engine->render($telegraphText) . PHP_EOL;
//    } else {
//        echo 'Template engine does not support render interface'. PHP_EOL;
//    }
//}
