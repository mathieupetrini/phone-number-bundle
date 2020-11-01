<?php

/*
 * This file is part of the Symfony2 PhoneNumberBundle.
 *
 * (c) University of Cambridge
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Misd\PhoneNumberBundle\Tests\Twig\Extension;

use Misd\PhoneNumberBundle\Templating\Helper\PhoneNumberHelper;
use Misd\PhoneNumberBundle\Twig\Extension\PhoneNumberHelperExtension;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Phone number helper Twig extension test.
 */
class PhoneNumberHelperExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberHelper
     */
    private $helper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|PhoneNumberHelperExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->helper = $this->getMockBuilder('Misd\PhoneNumberBundle\Templating\Helper\PhoneNumberHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->extension = new PhoneNumberHelperExtension($this->helper);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(TwigExtension::class, $this->extension);
    }

    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();

        $this->assertCount(2, $functions);
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertSame('phone_number_format', $functions[0]->getName());

        $callable = $functions[0]->getCallable();

        $this->assertSame($this->helper, $callable[0]);
        $this->assertSame('format', $callable[1]);

        $this->assertInstanceOf(TwigFunction::class, $functions[1]);
        $this->assertSame('phone_number_is_type', $functions[1]->getName());

        $callable = $functions[1]->getCallable();

        $this->assertSame($this->helper, $callable[0]);
        $this->assertSame('isType', $callable[1]);
    }

    public function testGetFilters()
    {
        $filters = $this->extension->getFilters();

        $this->assertCount(1, $filters);
        $this->assertInstanceOf(TwigFilter::class, $filters[0]);
        $this->assertSame('phone_number_format', $filters[0]->getName());

        $callable = $filters[0]->getCallable();

        $this->assertSame($this->helper, $callable[0]);
        $this->assertSame('format', $callable[1]);
    }

    public function testGetTests()
    {
        $tests = $this->extension->getTests();

        $this->assertCount(1, $tests);
        $this->assertInstanceOf(TwigTest::class, $tests[0]);
        $this->assertSame('phone_number_of_type', $tests[0]->getName());

        $callable = $tests[0]->getCallable();

        $this->assertSame($this->helper, $callable[0]);
        $this->assertSame('isType', $callable[1]);
    }

    public function testGetName()
    {
        $this->assertTrue(is_string($this->extension->getName()));
    }
}
