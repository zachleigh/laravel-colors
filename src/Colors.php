<?php

namespace LaravelColors;

class Colors
{
    /**
     * Colors read from sass file.
     *
     * @var array
     */
    protected $colors = [];

    /**
     * Default colors.
     *
     * @var array
     */
    protected $default = [
        ['name' => 'red', 'hex' => '#f44336'],
        ['name' => 'orange', 'hex' => '#ff9800'],
        ['name' => 'yellow', 'hex' => '#ffeb3b'],
        ['name' => 'green', 'hex' => '#4caf50'],
        ['name' => 'blue', 'hex' => '#2196f3'],
        ['name' => 'purple', 'hex' => '#673ab7']
    ];

    /**
     * Read colors file line by line.
     *
     * @return  array
     */
    public function readColorsFile()
    {
        $colorsFilePath = config('laravel-colors.sass_file');

        if ($colorsFilePath === 'none') {
            return $this->default;
        }

        $realPath = realpath(__DIR__.'/../../../..'.$colorsFilePath);

        if ($realPath === false) {
            $realPath = realpath($colorsFilePath);
        }

        try {
            $handle = fopen($realPath, 'r');
        } catch (\Exception $e) {
            abort(404, "Problem reading file {$colorsFilePath}. Check sass file path in laravel-colors config file.");
        }

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->parseLine($line);
            }
        } else {
            abort(500, "Problem reading file {$colorsFilePath}.");
        }

        fclose($handle);

        return $this->colors;
    }

    /**
     * Parse single line of colors file, set colors on object.
     *
     * @param string $line
     */
    protected function parseLine($line)
    {
        if ($this->isVariable($line) && $this->containsColor($line)) {
            $colorName = $this->getColorName($line);

            $colorValues = $this->getColorValues($line);

            $this->colors[] = [
                'name' => $colorName,
                'hex' => $colorValues['hex'],
                'rgb' => $colorValues['rgb']
            ];
        }
    }

    /**
     * Line starts with $ sign.
     *
     * @param string $line
     *
     * @return bool
     */
    protected function isVariable($line)
    {
        return substr($line, 0, 1) === '$';
    }

    /**
     * Line contains a color value.
     *
     * @return bool
     */
    protected function containsColor($line)
    {
        $value = $this->getValue($line);

        if ($this->isHex($value) || $this->isRGB($value)) {
            return true;
        }

        return false;
    }

    /**
     * Get the value of a sass variable.
     *
     * @param string $line
     *
     * @return string
     */
    protected function getValue($line)
    {
        $pos = strpos($line, ':');

        return trim(substr($line, $pos + 1));
    }

    /**
     * Value is a hex color.
     *
     * @param string $value
     *
     * @return bool
     */
    protected function isHex($value)
    {
        return (bool) preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $value);
    }

    /**
     * Value is an rgb color.
     *
     * @param string $value
     *
     * @return bool
     */
    protected function isRGB($value)
    {
        return strpos($value, 'rgb(') !== false;
    }

    /**
     * Get the variable name from the line.
     *
     * @param  string $line
     *
     * @return string
     */
    protected function getColorName($line)
    {
        $pos = strpos($line, ':');

        $name = trim(substr($line, 0, $pos));

        return str_replace('$', '', $name);
    }

    /**
     * Get colors values from line.
     *
     * @param  string $line
     *
     * @return array
     */
    protected function getColorValues($line)
    {
        $value = $this->getValue($line);

        if ($this->isHex($value)) {
            $hex = $value;

            $rgb = $this->hexToRGB($value);
        } else if ($this->isRGB($value)) {
            $hex = $this->rgbToHex($value);

            $rgb = $value;
        }

        return [
            'hex' => $hex,
            'rgb' => $rgb
        ];
    }

    /**
     * Convert hex colors to rgb value string.
     *
     * @param  string $hex
     *
     * @return string
     */
    protected function hexToRGB($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) === 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));

            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));

            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));

            $g = hexdec(substr($hex, 2, 2));

            $b = hexdec(substr($hex, 4, 2));
        }

        $rgb = array($r, $g, $b);

        return 'rgb('.implode(",", $rgb).')';
    }

    /**
     * Convert rgb color to hex strings.
     *
     * @param  string $rgb
     *
     * @return string
     */
    protected function rgbToHex($rgb)
    {
        $rgb = str_replace('rgb(', '', str_replace(')', '', $rgb));

        $rgb = explode(',', $rgb);

        $hex = "#";

        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);

        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);

        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex;
    }
}
