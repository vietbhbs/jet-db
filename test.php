<?php
class A {
    protected static string $name= 'viet';
}

class B extends A {
    public static function test(){
        echo A::$name;
    }
}

B::test();
