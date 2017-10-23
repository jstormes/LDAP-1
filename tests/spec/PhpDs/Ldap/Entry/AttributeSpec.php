<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpDs\Ldap\Entry;

use PhpDs\Ldap\Entry\Attribute;
use PhpSpec\ObjectBehavior;

class AttributeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('cn', 'foo', 'bar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Attribute::class);
    }

    function it_should_implement_countable()
    {
        $this->shouldImplement('\Countable');
    }

    function it_should_implement_iterator_aggregate()
    {
        $this->shouldImplement('\IteratorAggregate');
    }

    function it_should_get_the_name()
    {
        $this->getName()->shouldBeEqualTo('cn');
    }

    function it_should_get_the_values()
    {
        $this->getValues()->shouldBeEqualTo(['foo', 'bar']);
    }

    function it_should_have_a_string_representation()
    {
        $this->__toString()->shouldBeEqualTo('foo, bar');
    }

    function it_should_get_a_count_of_values()
    {
        $this->count()->shouldBeEqualTo(2);
    }

    function it_should_add_values()
    {
        $this->add('foobar', 'meh');

        $this->getValues()->shouldBeEqualTo(['foo','bar','foobar', 'meh']);
    }

    function it_should_remove_values()
    {
        $this->remove('bar');

        $this->getValues()->shouldBeEqualTo(['foo']);
    }

    function it_should_set_values()
    {
        $this->set('foo')->getValues()->shouldBeEqualTo(['foo']);
    }

    function it_should_reset_values()
    {
        $this->reset()->getValues()->shouldBeEqualTo([]);
    }

    function it_should_check_if_a_value_exists()
    {
        $this->has('foo')->shouldBeEqualTo(true);
        $this->has('bleh')->shouldBeEqualTo(false);
    }

    function it_should_check_if_it_equals_another_attribute()
    {
        $this->equals(new Attribute('cn'))->shouldBeEqualTo(true);
        $this->equals(new Attribute('CN'))->shouldBeEqualTo(true);
        $this->equals(new Attribute('foo'))->shouldBeEqualTo(false);
    }
}
