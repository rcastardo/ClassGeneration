<?php

/*
 * This file is part of the ClassGeneration package.
 *
 * (c) Antonio Spinelli <tonicospinelli@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassGeneration\Test;

use ClassGeneration\PhpClass;
use ClassGeneration\Constant;
use ClassGeneration\ConstantCollection;
use ClassGeneration\DocBlock\Tag;
use ClassGeneration\DocBlock;
use ClassGeneration\InterfaceCollection;
use ClassGeneration\Method;
use ClassGeneration\MethodCollection;
use ClassGeneration\NamespaceClass;
use ClassGeneration\Property;
use ClassGeneration\PropertyCollection;
use ClassGeneration\UseClass;
use ClassGeneration\UseCollection;

class PhpClassTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatingInstanceOfPhpClassInterface()
    {
        $code = new PhpClass();
        $this->assertInstanceOf('\ClassGeneration\PhpClassInterface', $code);
    }

    public function testSetAndGetName()
    {
        $code = new PhpClass();
        $code->setName('Test');
        $this->assertEquals('Test', $code->getName());
    }

    public function testSetAndGetNamespace()
    {
        $code = new PhpClass();
        $code->setNamespace(new NamespaceClass(array('path' => 'PhpClass')));
        $this->assertEquals('PhpClass', $code->getNamespace()->getPath());
    }

    public function testGetFullName()
    {
        $code = new PhpClass();
        $code->setName('Test');
        $code->setNamespace(new NamespaceClass('Code'));
        $this->assertEquals('Code\Test', $code->getFullName());
    }

    public function testSetAndGetAndAddConstants()
    {
        $code = new PhpClass();
        $code->setConstantCollection(
            new ConstantCollection(
                array(
                    new Constant(array('name' => 'test1', 'value' => 1))
                )
            )
        );

        $this->assertInstanceOf('\ClassGeneration\ConstantCollection', $code->getConstantCollection());
        $this->assertInstanceOf('\ClassGeneration\Constant', $code->getConstantCollection()->current());
        $this->assertCount(1, $code->getConstantCollection());
        $this->assertEquals('test1', $code->getConstantCollection()->current()->getName());

        $code->addConstant(new Constant(array('name' => 'test2', 'value' => 1)));
        $this->assertCount(2, $code->getConstantCollection());
        $this->assertEquals('test2', $code->getConstantCollection()->last()->getName());
    }

    public function testSetAndGetAndAddProperties()
    {
        $code = new PhpClass();
        $code->setPropertyCollection(
            new PropertyCollection(
                array(
                    new Property(array('name' => 'test1', 'value' => 1))
                )
            )
        );

        $this->assertInstanceOf('\ClassGeneration\PropertyCollection', $code->getPropertyCollection());
        $this->assertInstanceOf('\ClassGeneration\Property', $code->getPropertyCollection()->current());
        $this->assertCount(1, $code->getPropertyCollection());
        $this->assertEquals('test1', $code->getPropertyCollection()->current()->getName());

        $code->addProperty(new Property(array('name' => 'test2', 'value' => 1)));
        $this->assertCount(2, $code->getPropertyCollection());
        $this->assertEquals('test2', $code->getPropertyCollection()->last()->getName());
    }

    public function testSetAndGetPropertiesAndGenerateMethodsGettersAndSetters()
    {
        $code = new PhpClass();
        $code->setPropertyCollection(
            new PropertyCollection(array(new Property(array('name' => 'test1', 'value' => 1))))
        );

        $code->generateGettersAndSettersFromProperties();

        $this->assertCount(1, $code->getPropertyCollection());
        $this->assertEquals('test1', $code->getPropertyCollection()->current()->getName());

        $this->assertCount(2, $code->getMethodCollection());
        $this->assertEquals('getTest1', $code->getMethodCollection()->current()->getName());
        $this->assertEquals('setTest1', $code->getMethodCollection()->last()->getName());
    }

    public function testGetProperty()
    {
        $code = new PhpClass();
        $code->setPropertyCollection(
            new PropertyCollection(
                array(
                    new Property(array('name' => 'test', 'value' => 1))
                )
            )
        );

        $this->assertInstanceOf('\ClassGeneration\PropertyCollection', $code->getProperty('test'));
        $this->assertCount(1, $code->getProperty('test'));
        $this->assertEquals('test', $code->getProperty('test')->current()->getName());
    }

    public function testSetAndGetAndAddMethods()
    {
        $code = new PhpClass();
        $code->setMethodCollection(
            new MethodCollection(
                array(
                    new Method(array('name' => 'test1'))
                )
            )
        );

        $this->assertInstanceOf('\ClassGeneration\MethodCollection', $code->getMethodCollection());
        $this->assertInstanceOf('\ClassGeneration\Method', $code->getMethodCollection()->current());
        $this->assertCount(1, $code->getMethodCollection());
        $this->assertEquals('test1', $code->getMethodCollection()->current()->getName());

        $code->addMethod(new Method(array('name' => 'test2')));
        $this->assertCount(2, $code->getMethodCollection());
        $this->assertEquals('test2', $code->getMethodCollection()->last()->getName());
    }

    public function testSetAndGetExtends()
    {
        $code = new PhpClass();
        $code->setExtends('\SplHeap');
        $this->assertEquals('\SplHeap', $code->getExtends());
    }

    public function testSetAndGetAndAddInterfaces()
    {
        $code = new PhpClass();
        $code->setInterfaceCollection(new InterfaceCollection(array('\Traversable')));

        $this->assertInstanceOf('\ClassGeneration\InterfaceCollection', $code->getInterfaceCollection());
        $this->assertCount(1, $code->getInterfaceCollection());
        $this->assertEquals('\Traversable', $code->getInterfaceCollection()->current());

        $code->addInterface('\Countable');
        $this->assertCount(2, $code->getInterfaceCollection());
        $this->assertEquals('\Countable', $code->getInterfaceCollection()->last());

        $code->getInterfaceCollection()->removeElement('\Countable');
        $this->assertCount(1, $code->getInterfaceCollection());
        $code->addInterface('\Countable');
        $this->assertEquals('\Countable', $code->getInterfaceCollection()->last());
    }

    public function testSetAndIsTrait()
    {
        $code = new PhpClass();
        $code->setIsTrait();
        $this->assertTrue($code->isTrait());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetAndIsInterface()
    {
        $code = new PhpClass();
        $code->setIsInterface();
        $this->assertTrue($code->isInterface());
        $code->setIsAbstract();
    }

    public function testSetAndGetDescription()
    {
        $code = new PhpClass();
        $code->setDescription('Class test');
        $this->assertEquals('Class test', $code->getDocBlock()->getDescription());
    }

    public function testSetAndGetAndAddUse()
    {
        $code = new PhpClass();
        $code->setUseCollection(
            new UseCollection(array(new UseClass(array('className' => 'ClassGeneration\PhpClass'))))
        );

        $this->assertInstanceOf('\ClassGeneration\UseCollection', $code->getUseCollection());
        $this->assertCount(1, $code->getUseCollection());
        $this->assertEquals(
            'ClassGeneration\PhpClass',
            $code->getUseCollection()->current()->getClassName()
        );

        $code->addUse(
            new UseClass(
                array(
                    'className' => 'ClassGeneration\PropertyCollection',
                    'alias'     => 'Properties'
                )
            )
        );
        $this->assertCount(2, $code->getUseCollection());
        $this->assertEquals(
            'use ClassGeneration\PropertyCollection as Properties;' . PHP_EOL,
            $code->getUseCollection()->last()->toString()
        );
    }

    public function testParseClassToString()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->addInterface('\ArrayAccess')
            ->addMethod(new Method())
            ->addProperty(new Property());
        $expected = '<?php' . PHP_EOL
            . '' . PHP_EOL
            . '/**' . PHP_EOL
            . ' * Class description' . PHP_EOL
            . ' */' . PHP_EOL
            . 'class Test implements \ArrayAccess' . PHP_EOL
            . '{' . PHP_EOL . PHP_EOL
            . '    public $property1;' . PHP_EOL
            . '' . PHP_EOL
            . '    /**'
            . '' . PHP_EOL
            . '     * '
            . '' . PHP_EOL
            . '     * @param mixed $offset'
            . '' . PHP_EOL
            . '     */'
            . '' . PHP_EOL
            . '    public function offsetExists($offset)'
            . '' . PHP_EOL
            . '    {'
            . '' . PHP_EOL
            . '        //TODO: implements the offsetExists method'
            . '' . PHP_EOL
            . '    }' . PHP_EOL
            . '' . PHP_EOL
            . '    /**'
            . '' . PHP_EOL
            . '     * '
            . '' . PHP_EOL
            . '     * @param mixed $offset'
            . '' . PHP_EOL
            . '     */'
            . '' . PHP_EOL
            . '    public function offsetGet($offset)'
            . '' . PHP_EOL
            . '    {'
            . '' . PHP_EOL
            . '        //TODO: implements the offsetGet method'
            . '' . PHP_EOL
            . '    }' . PHP_EOL
            . '' . PHP_EOL
            . '    /**'
            . '' . PHP_EOL
            . '     * '
            . '' . PHP_EOL
            . '     * @param mixed $offset'
            . '' . PHP_EOL
            . '     * @param mixed $value'
            . '' . PHP_EOL
            . '     */'
            . '' . PHP_EOL
            . '    public function offsetSet($offset, $value)'
            . '' . PHP_EOL
            . '    {'
            . '' . PHP_EOL
            . '        //TODO: implements the offsetSet method'
            . '' . PHP_EOL
            . '    }' . PHP_EOL
            . '' . PHP_EOL
            . '    /**'
            . '' . PHP_EOL
            . '     * '
            . '' . PHP_EOL
            . '     * @param mixed $offset'
            . '' . PHP_EOL
            . '     */'
            . '' . PHP_EOL
            . '    public function offsetUnset($offset)'
            . '' . PHP_EOL
            . '    {'
            . '' . PHP_EOL
            . '        //TODO: implements the offsetUnset method'
            . '' . PHP_EOL
            . '    }' . PHP_EOL
            . '' . PHP_EOL
            . '    public function method5()'
            . '' . PHP_EOL
            . '    {'
            . '' . PHP_EOL
            . '        //TODO: implements the method5 method'
            . '' . PHP_EOL
            . '    }' . PHP_EOL
            . '}' . PHP_EOL;
        $this->assertEquals($expected, $code->toString());
    }

    public function testParseInterfaceToString()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->setExtends('\Testable')
            ->setIsInterface()
            ->addMethod(new Method(array('isInterface' => true)));
        $expected = '<?php' . PHP_EOL
            . '' . PHP_EOL
            . '/**' . PHP_EOL
            . ' * Class description' . PHP_EOL
            . ' */' . PHP_EOL
            . 'interface Test extends \Testable' . PHP_EOL
            . '{' . PHP_EOL
            . '' . PHP_EOL
            . '    public function method1();' . PHP_EOL
            . '}' . PHP_EOL;
        $this->assertEquals($expected, $code->toString());
    }

    public function testParseAbstractClassToString()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->setIsAbstract()
            ->addInterface('\Testable')
            ->addMethod(new Method(array('isAbstract' => true)));
        $expected = '<?php' . PHP_EOL
            . '' . PHP_EOL
            . '/**' . PHP_EOL
            . ' * Class description' . PHP_EOL
            . ' */' . PHP_EOL
            . 'abstract class Test implements \Testable' . PHP_EOL
            . '{' . PHP_EOL
            . '' . PHP_EOL
            . '    abstract public function method1();' . PHP_EOL
            . '}' . PHP_EOL;
        $this->assertEquals($expected, $code->toString());
    }

    public function testParseFinalClassToString()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->setIsFinal()
            ->addMethod(new Method(array('isFinal' => true)));
        $expected = '<?php' . PHP_EOL
            . '' . PHP_EOL
            . '/**' . PHP_EOL
            . ' * Class description' . PHP_EOL
            . ' */' . PHP_EOL
            . 'final class Test' . PHP_EOL
            . '{' . PHP_EOL
            . '' . PHP_EOL
            . '    final public function method1()' . PHP_EOL
            . '    {' . PHP_EOL
            . '        //TODO: implements the method1 method' . PHP_EOL
            . '    }' . PHP_EOL
            . '}' . PHP_EOL;
        $this->assertEquals($expected, $code->toString());
    }

    public function testParseTraitToString()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->setIsTrait()
            ->addMethod(new Method());
        $expected = '<?php' . PHP_EOL
            . '' . PHP_EOL
            . '/**' . PHP_EOL
            . ' * Class description' . PHP_EOL
            . ' */' . PHP_EOL
            . 'trait Test' . PHP_EOL
            . '{' . PHP_EOL
            . '' . PHP_EOL
            . '    public function method1()' . PHP_EOL
            . '    {' . PHP_EOL
            . '        //TODO: implements the method1 method' . PHP_EOL
            . '    }' . PHP_EOL
            . '}' . PHP_EOL;
        $this->assertEquals($expected, $code->toString());
    }

    public function testEvaluate()
    {
        $code = new PhpClass();
        $code->setName('Test')
            ->setDescription('Class description')
            ->setExtends('\ArrayIterator')
            ->addMethod(new Method())
            ->addProperty(new Property());
        $code->evaluate();
        $this->assertTrue(class_exists('\Test'));
    }

    public function testSetAndGetDocBlock()
    {
        $code = new PhpClass();
        $code->setDescription('first test');
        $this->assertEquals('first test', $code->getDocBlock()->getDescription());
        $code->setDocBlock(new DocBlock(array('description' => 'second test')));
        $this->assertEquals('second test', $code->getDocBlock()->getDescription());
    }

    public function testSetOptions()
    {
        $code = new PhpClass();
        $code->setOptions(array('description' => 'first test'));
        $this->assertEquals('first test', $code->getDocBlock()->getDescription());
    }

    public function testSetAndGetTabulation()
    {
        $code = new PhpClass();
        $code->setTabulation(0);
        $this->assertEquals(0, $code->getTabulation());
    }

    public function testGetTabulationFormatted()
    {
        $code = new PhpClass();
        $code->setTabulation(4);
        $this->assertEquals('    ', $code->getTabulationFormatted());
    }

    public function testSetAndIsFinal()
    {
        $code = new PhpClass();
        $code->setIsFinal();
        $this->assertTrue($code->isFinal());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetAndIsAbstract()
    {
        $code = new PhpClass();
        $code->setIsAbstract();
        $this->assertTrue($code->isAbstract());
        $code->setIsInterface();
    }
}
