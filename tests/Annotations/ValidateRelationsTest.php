<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApiTests\Annotations;

use OpenApiTests\OpenApiTestCase;

/**
 * Test if the annotation class nesting parent/child relations are coherent.
 */
class ValidateRelationsTest extends OpenApiTestCase
{

    /**
     *
     * @dataProvider allAnnotationClasses
     *
     * @param string $class
     */
    public function testAncestors($class)
    {
        foreach ($class::$_parents as $parent) {
            $found = false;
            foreach (array_keys($parent::$_nested) as $nested) {
                if ($nested === $class) {
                    $found = true;
                    break;
                }
            }
            if ($found === false) {
                $this->fail($class.' not found in '.$parent."::\$_nested. Found:\n  ".implode("\n  ", array_keys($parent::$_nested)));
            }
        }
    }

    /**
     *
     * @dataProvider allAnnotationClasses
     *
     * @param string $class
     */
    public function testNested($class)
    {
        foreach (array_keys($class::$_nested) as $nested) {
            $found = false;
            foreach ($nested::$_parents as $parent) {
                if ($parent === $class) {
                    $found = true;
                    break;
                }
            }
            if ($found === false) {
                $this->fail($class.' not found in '.$nested."::\$parent. Found:\n  ".implode("\n  ", $nested::$_parents));
            }
        }
    }
}
