<?php

namespace Esign\InlineEditing;

use App\Models\Dictionary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 * Class InlineEditing
 */
class InlineEditing
{
    public const MULTILANG = true;

    protected static $instance = null;
    protected array $database = [];
    protected bool $editMode = false;

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public static function getInstance(): static
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
            self::$instance->readDatabase();
        }

        return self::$instance;
    }

    public static function string(string $term, array $replacements = []): string
    {
        return self::getInstance()->translate($term, 'text', $replacements);
    }

    protected function translate(string $term, string $type, array $replacements = []): string
    {
        $lang = app()->getLocale();

        $row = $this->firstOrCreateRow($term, $type);

        $container = ($type == 'richtext') ? 'div' : 'span';
        $attributes = [];

        if (self::MULTILANG) {
            $value = (empty($row->{"value_$lang"})) ? $term : $row->{"value_$lang"};
        } else {
            $value = (empty($row->{"value"})) ? $term : $row->{"value"};
        }

        if (! $this->editMode) {
            foreach ($replacements as $search => $replacement) {
                $value = str_replace($search, $replacement, $value);
            }
        }

        $classes[] = ($type == 'richtext') ? 'rich-editable' : 'editable';
        $attributes['data-tid'] = $row->id;
        $attributes['data-tlang'] = $lang;
        $attributes['data-ttype'] = $type;

        $classesString = join(' ', $classes);

        $attributesString = join(' ', array_map(function ($k, $v) {
            return "$k=\"$v\"";
        }, array_keys($attributes), array_values($attributes)));

        return "<$container class=\"$classesString\" $attributesString>$value</$container>";
    }

    protected function firstOrCreateRow(string $term, string $type): object | null
    {
        if (! isset($this->database[$term])) {
            $new = [
                'term' => $term,
                'type' => $type,
            ];
            $id = DB::table(config('inline-edit.database'))->insertGetId($new);

            return $this->database[$term] = DB::table(config('inline-edit.database'))->where('id', $id)->first();
        } else {
            return $this->database[$term];
        }
    }

    protected function readDatabase(): void
    {
        $result = DB::table(config('inline-edit.database'))->get();
        foreach ($result as $row) {
            $this->database[$row->term] = $row;
        }
    }

    public static function updateBatch(array $update): bool
    {
        $lang = $update['tlang'];
        $value = $update['text'];
        if (self::MULTILANG) {
            DB::table(config('inline-edit.database')) ->where('id', $update['tid']) ->update(["value_$lang" => $value]);
        } else {
            DB::table(config('inline-edit.database')) ->where('id', $update['tid']) ->update(["value" => $value]);
        }


        return true;
    }
}
