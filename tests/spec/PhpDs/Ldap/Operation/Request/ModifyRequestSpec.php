<?php

namespace spec\PhpDs\Ldap\Operation\Request;

use PhpDs\Ldap\Asn1\Asn1;
use PhpDs\Ldap\Entry\Change;
use PhpDs\Ldap\Entry\Dn;
use PhpDs\Ldap\Operation\Request\ModifyRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModifyRequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            'cn=foo,dc=foo,dc=bar',
            Change::replace('foo', 'bar'), Change::add('sn', 'bleep', 'blorp')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ModifyRequest::class);
    }

    function it_should_set_the_dn()
    {
        $this->getDn()->shouldBeLike(new Dn('cn=foo,dc=foo,dc=bar'));

        $this->setDn(new Dn('foo'))->getDn()->shouldBeLike(new Dn('foo'));
    }

    function it_should_set_the_changes()
    {
        $this->getChanges()->shouldBeLike([
            Change::replace('foo', 'bar'),
            Change::add('sn', 'bleep', 'blorp')
        ]);

        $this->setChanges(Change::delete('foo', 'bar'))->getChanges()->shouldBeLike([
            Change::delete('foo', 'bar')
        ]);
    }

    function it_should_generate_correct_asn1()
    {
        $this->toAsn1()->shouldBeLike(Asn1::application(6, Asn1::sequence(
            Asn1::ldapDn('cn=foo,dc=foo,dc=bar'),
            Asn1::sequenceOf(
                Asn1::sequence(
                    Asn1::enumerated(2),
                    Asn1::sequence(
                        Asn1::octetString('foo'),
                        Asn1::setOf(
                            Asn1::octetString('bar')
                        )
                    )
                ),
                Asn1::sequence(
                    Asn1::enumerated(0),
                    Asn1::sequence(
                        Asn1::octetString('sn'),
                        Asn1::setOf(
                            Asn1::octetString('bleep'),
                            Asn1::octetString('blorp')
                        )
                    )
                )
            )
        )));
    }
}
