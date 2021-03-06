<?php

namespace Differ\tests;

use PHPUnit\Framework\TestCase;

use function Differ\Diff\getDiff;
use function Differ\Diff\genDiff;

class DiffTest extends TestCase
{
    public function testGetDiff()
    {
        $before = [
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22'
        ];
        $after = [
            'timeout' => 20,
            'verbose' => true,
            'host' => 'hexlet.io'
        ];
        $expected = [
            '  host: hexlet.io',
            '+ timeout: 20',
            '- timeout: 50',
            '- proxy: 123.234.53.22',
            '+ verbose: true'
        ];
        $actual = getDiff($before, $after);
        $this->assertEquals($expected, $actual);
    }

    public function testGetDiffWithEmptyValue()
    {
        $before = [
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22'
        ];
        $after = [];
        $expected = [
            '- host: hexlet.io',
            '- timeout: 50',
            '- proxy: 123.234.53.22'
        ];
        $actual = getDiff($before, $after);
        $this->assertEquals($expected, $actual);
    }

    public function testGetDiffWithBooleanValue()
    {
        $before = [
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22'
        ];
        $after = [
            'timeout' => 0,
            'verbose' => true,
            'host' => 'hexlet.io',
            'result' => false
        ];
        $expected = [
            '  host: hexlet.io',
            '+ timeout: 0',
            '- timeout: 50',
            '- proxy: 123.234.53.22',
            '+ verbose: true',
            '+ result: false'
        ];
        $actual = getDiff($before, $after);
        $this->assertEquals($expected, $actual);
    }
    public function testGenDiffWithAbsolutePaths()
    {
        $pathFirst = '/home/nikolay/php-project-lvl2/tests/before.json';
        $pathSecond = '/home/nikolay/php-project-lvl2/tests/after.json';
        $expected = "  host: hexlet.io\n+ timeout: 20\n- timeout: 50\n- proxy: 123.234.53.22\n+ verbose: true\n";
        $actual = genDiff($pathFirst, $pathSecond);
        $this->assertEquals($expected, $actual);
    }

    public function testGenDiffWithRelativePaths()
    {
        $pathFirst = 'tests/before.json';
        $pathSecond = 'tests/after.json';
        $expected = "  host: hexlet.io\n+ timeout: 20\n- timeout: 50\n- proxy: 123.234.53.22\n+ verbose: true\n";
        $actual = genDiff($pathFirst, $pathSecond);
        $this->assertEquals($expected, $actual);
    }
}
