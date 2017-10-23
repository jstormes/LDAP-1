<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpDs\Ldap\Search\Filter;

use PhpDs\Ldap\Asn1\Asn1;
use PhpDs\Ldap\Search\Filter\NotFilter;
use PhpDs\Ldap\Search\Filters;
use PhpSpec\ObjectBehavior;

class NotFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Filters::equal('foo', 'bar'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NotFilter::class);
    }

    function it_should_set_the_filter()
    {
        $this->set(Filters::gte('foobar', 'foo'));
        $this->get()->shouldBeLike(Filters::gte('foobar', 'foo'));
    }

    function it_should_generate_correct_asn1()
    {
        $this->toAsn1()->shouldBeLike(Asn1::context(2, Filters::equal('foo', 'bar')->toAsn1()));
    }
}
