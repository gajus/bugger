<?php
require __DIR__ . '/../vendor/autoload.php';
echo "<h1>Test of Bugger</h1>";

$a = array('a' => 'b');
$f = 1;


class ExampleClassOne
{
    public $object;
    public function __construct($object, $a, $b, $c, $d)
    {
        $this->object = $object;
        $this->execute();
    }

    public function execute()
    {
        $this->object->execute();
    }
}

class ExampleClassTwo
{
    public $someProperty = array(
        '1' => 'some value 1',
        '2' => '<div>some value 2</div>',
        '4' => 'some value 3',
    );

    public $x = 42;

    public $y = "some string";

    public function execute()
    {
        trace($this);
        return 'result';
    }
}

function someFunction()
{
    $a = new ExampleClassTwo();
    $b = new ExampleClassOne(
        $a, '<abc>def</abc>', 1419400800, 'int(1419400800)', array(2)
    );
}

someFunction();
