<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpDs\Ldap\Operation\Request;

use PhpDs\Ldap\Asn1\Asn1;
use PhpDs\Ldap\Exception\BindException;
use PhpDs\Ldap\Operation\Request\BindRequest;
use PhpDs\Ldap\Operation\Request\SimpleBindRequest;
use PhpSpec\ObjectBehavior;

class SimpleBindRequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('','');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleBindRequest::class);
    }

    function it_should_extend_bind_request()
    {
        $this->shouldBeAnInstanceOf(BindRequest::class);
    }

    function it_should_default_to_ldap_v3()
    {
        $this->getVersion()->shouldBeEqualTo(3);
    }

    function it_should_set_the_username()
    {
        $this->setUsername('foo');
        $this->getUsername()->shouldBeEqualTo('foo');
    }

    function it_should_set_the_password()
    {
        $this->setPassword('bar');
        $this->getPassword()->shouldBeEqualTo('bar');
    }

    function it_should_not_allow_an_empty_username_or_password()
    {
        $this->shouldThrow(BindException::class)->duringToAsn1();

        $this->setUsername('foo');
        $this->shouldThrow(BindException::class)->duringToAsn1();

        $this->setUsername('');
        $this->setPassword('bar');
        $this->shouldThrow(BindException::class)->duringToAsn1();

        $this->setUsername('foo')->setPassword('bar');
        $this->shouldNotThrow(BindException::class)->duringToAsn1();
    }

    function it_should_generate_correct_asn1()
    {
        $this->setUsername('foo')->setPassword('bar');

        $this->toAsn1()->shouldBeLike(Asn1::application(0, Asn1::sequence(
            Asn1::integer(3),
            Asn1::ldapDn('foo'),
            Asn1::context(0, Asn1::octetString('bar'))
        )));
    }
}
