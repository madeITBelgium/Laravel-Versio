<?php

use Illuminate\Validation\Factory;
use MadeITBelgium\Versio\Validation\ValidatorExtensions;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    /*
    public function testValidatorDomainavaibleTrue()
    {
        $validator = new MadeITBelgium\Versio\Validation\Validator();
        $this->assertTrue($validator->isDomainAvailable('test' . time() . '.be'));
    }*/

    public function testValidatorUserFalse()
    {
        $validator = new MadeITBelgium\Versio\Validation\Validator();
        $this->assertFalse($validator->isDomainAvailable('madeit.be'));
    }

    public function testValidUser()
    {
        $domainname = 'test' . time() . '.be';
        
        $validator = Mockery::mock('MadeITBelgium\Versio\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\Versio\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isDomainAvailable')->once()->with($domainname)->andReturn(true);
        $factory = new Factory($translator, $container);
        $factory->extend('user', 'MadeITBelgium\Versio\Validation\ValidatorExtensions@validatedomainvailable', ':attribute is not available.');
        $validator = $factory->make(['foo' => $domainname], ['foo' => 'user']);
        $this->assertTrue($validator->passes());
    }

    public function testValidUserFails()
    {
        $domainname = 'madeit.be';
        
        $validator = Mockery::mock('MadeITBelgium\Versio\Validation\Validator');
        $extensions = new ValidatorExtensions($validator);
        $container = Mockery::mock('Illuminate\Container\Container');
        $translator = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $container->shouldReceive('make')->once()->with('MadeITBelgium\Versio\Validation\ValidatorExtensions')->andReturn($extensions);
        $validator->shouldReceive('isDomainAvailable')->once()->with($domainname)->andReturn(false);
        $translator->shouldReceive('trans')->once()->with('validation.custom')->andReturn('validation.custom');
        $translator->shouldReceive('trans')->once()->with('validation.custom.foo.user')->andReturn('validation.custom.foo.user');
        $translator->shouldReceive('trans')->once()->with('validation.user')->andReturn('validation.user');
        $translator->shouldReceive('trans')->once()->with('validation.attributes')->andReturn('validation.attributes');
        $translator->shouldReceive('trans')->once()->with('validation.attributes.foo')->andReturn('validation.attributes.foo');
        $factory = new Factory($translator, $container);
        $factory->extend('user', 'MadeITBelgium\Versio\Validation\ValidatorExtensions@validatedomainvailable', ':attribute is not available.');
        $validator = $factory->make(['foo' => $domainname], ['foo' => 'user']);
        $this->assertTrue($validator->fails());
        $messages = $validator->messages();
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $messages);
        $this->assertEquals('foo is not available.', $messages->first('foo'));
    }
}
