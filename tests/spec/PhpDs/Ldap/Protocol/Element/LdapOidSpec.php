<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpDs\Ldap\Protocol\Element;

use PhpDs\Ldap\Asn1\Type\OctetStringType;
use PhpDs\Ldap\Protocol\Element\LdapOid;
use PhpSpec\ObjectBehavior;

class LdapOidSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LdapOid::class);
    }

    function it_should_be_an_instance_of_octet_string()
    {
        $this->beAnInstanceOf(OctetStringType::class);
    }
}
