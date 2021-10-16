<?php

namespace Avatarate\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Gd\Font;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as ImageCanvas;
use Intervention\Image\Gd\Shapes\CircleShape;
use Intervention\Image\Gd\Shapes\RectangleShape;

class AvatarBuilder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array|string
     */
    private $backgroundColor;
    /**
     * @var array|string
     */
    private $lettersColor;
    /**
     * @var string
     */
    private $shape;

    /**
     * @var int|mixed
     */
    private $size;

    /**
     * @var string
     */
    private string $saveDirectory;


    /**
     * @param string $name
     * @param string|array $backgroundColor
     * @param string|array $lettersColor
     * @param string $shape
     * @param int $size
     */
    public function __construct(
        string $name = "Mohammad Sev",
        $backgroundColor = "random",
        $lettersColor = "random",
        string $shape = "circle",
        int $size = 150
    )
    {
        $this->name = $name;
        $this->backgroundColor = $backgroundColor;
        $this->lettersColor = $lettersColor;
        $this->shape = $shape;
        $this->size = $size;

        $this->saveDirectory = config('avatarate.save_directory');
    }

    public function generate()
    {
        $canvas = $this->drawText();
        $canvas
            ->resize($this->getSize(), $this->getSize())
            ->stream('png');

        $imageName =  'avatarate-' . time() . '.png';
        $path = $this->saveDirectory . $imageName;

        $canvas->save($path);

        return [
            'status' => 'success',
            'file_name' => $canvas->filename,
            'path' => $canvas->basePath(),
        ];
    }


    public function generateBackgroundColor()
    {
        if (!ColorSelector::check($this->backgroundColor)) {
            $this->backgroundColor = ColorSelector::select();
        }

        if ($this->backgroundColor === 'random' || is_null($this->backgroundColor)) {
            $this->backgroundColor = ColorSelector::select();
        }

        return $this->backgroundColor;
    }


    private function getTextColor()
    {
        if ($this->lettersColor == 'random' || is_null($this->lettersColor)) {
            return ColorSelector::select();
        }

        if (!ColorSelector::check($this->lettersColor)) {
            return ColorSelector::select();
        }

        return $this->lettersColor;
    }


    private function getName(): string
    {
        if (strlen($this->name) < 2) {
            return GenerateLetters::generate("Mohammad Sev");
        }

        if (preg_match('/\p{Arabic}/u', $this->name)) {
            return mb_strrev(GenerateLetters::generate($this->name));
        }

        return GenerateLetters::generate($this->name);
    }


    private function getSize()
    {
        if (is_null($this->size) || ($this->size > 512) || $this->size < 50) {
            return 150;
        }
        return $this->size;
    }

    private function getShape(): ImageCanvas
    {
        if ($this->shape === 'rectangle') {
            return $this->drawRectangleShape();
        } else {
            return $this->drawCircleShape();
        }
    }


    private function initCanvas(): ImageCanvas
    {
        return Image::canvas($this->getSize() * 2 + 6, $this->getSize() * 2 + 6);
    }


    private function drawRectangleShape(): ImageCanvas
    {
        $canvas = $this->initCanvas();
        $canvas->rectangle(
            0,
            0,
            $this->getSize() * 2 + 6,
            $this->getSize() * 2 + 6,
            function (RectangleShape $draw) {
                $draw->background($this->generateBackgroundColor());
            });

        return $canvas;
    }

    private function drawCircleShape(): ImageCanvas
    {
        $canvas = $this->initCanvas();
        $canvas->circle(
            $this->getSize() * 2,
            $this->getSize() + 3,
            $this->getSize() + 3,
            function (CircleShape $draw) {
                $draw->background($this->generateBackgroundColor());
            });

        return $canvas;
    }


    private function getText(ImageCanvas $canvas): ImageCanvas
    {
        $canvas->text($this->getName(), $this->getSize(), $this->getSize(), function (Font $font) {
            $font->file(__DIR__ . '/../../files/Cairo-Light.ttf');
            $font->size($this->getSize());
            $font->color($this->getTextColor());
            $font->valign('middle');
            $font->align('center');
            $font->angle(360);
        });

        return $canvas;
    }

    private function drawText(): ImageCanvas
    {
        $canvas = $this->getShape();
        return $this->getText($canvas);
    }


}
