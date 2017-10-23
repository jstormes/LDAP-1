<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpDs\Ldap\Control\Ad;

use PhpDs\Ldap\Asn1\Encoder\BerEncoder;
use PhpDs\Ldap\Asn1\Type\BooleanType;
use PhpDs\Ldap\Asn1\Type\IntegerType;
use PhpDs\Ldap\Asn1\Type\OctetStringType;
use PhpDs\Ldap\Asn1\Type\SequenceType;
use PhpDs\Ldap\Control\Ad\SdFlagsControl;
use PhpDs\Ldap\Control\Control;
use PhpDs\Ldap\Protocol\Element\LdapOid;
use PhpSpec\ObjectBehavior;

class SdFlagsControlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(SdFlagsControl::DACL_SECURITY_INFORMATION);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SdFlagsControl::class);
    }

    function it_should_get_the_flags()
    {
        $this->getFlags()->shouldBeEqualTo(SdFlagsControl::DACL_SECURITY_INFORMATION);
    }

    function it_should_set_the_flags()
    {
        $this->setFlags(SdFlagsControl::SACL_SECURITY_INFORMATION)->getFlags()->shouldBeEqualTo(SdFlagsControl::SACL_SECURITY_INFORMATION);
    }

    function it_should_generate_correct_ASN1()
    {
        $encoder = new BerEncoder();

        $this->toAsn1()->shouldBeLike(new SequenceType(
            new LdapOid(Control::OID_SD_FLAGS),
            new BooleanType(false),
            new OctetStringType($encoder->encode(new SequenceType(
                new IntegerType(4)
            )))
        ));
    }
}
