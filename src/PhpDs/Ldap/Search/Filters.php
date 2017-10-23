<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDs\Ldap\Search;

use PhpDs\Ldap\Search\Filter\AndFilter;
use PhpDs\Ldap\Search\Filter\ApproximateFilter;
use PhpDs\Ldap\Search\Filter\EqualityFilter;
use PhpDs\Ldap\Search\Filter\FilterInterface;
use PhpDs\Ldap\Search\Filter\GreaterThanOrEqualFilter;
use PhpDs\Ldap\Search\Filter\LessThanOrEqualFilter;
use PhpDs\Ldap\Search\Filter\MatchingRuleFilter;
use PhpDs\Ldap\Search\Filter\NotFilter;
use PhpDs\Ldap\Search\Filter\OrFilter;
use PhpDs\Ldap\Search\Filter\PresentFilter;
use PhpDs\Ldap\Search\Filter\SubstringFilter;

/**
 * Provides some simple factory methods for building filters.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class Filters
{
    /**
     * Create a logical 'and' filter, containing other filters.
     *
     * @param FilterInterface[] ...$filters
     * @return AndFilter
     */
    public static function and(FilterInterface ...$filters) : AndFilter
    {
        return new AndFilter(...$filters);
    }

    /**
     * Create a logical 'or' filter, containing other filters.
     *
     * @param FilterInterface[] ...$filters
     * @return OrFilter
     */
    public static function or(FilterInterface ...$filters) : OrFilter
    {
        return new OrFilter(...$filters);
    }

    /**
     * Create a simple equality value check filter.
     *
     * @param string $attribute
     * @param string $value
     * @return EqualityFilter
     */
    public static function equal(string $attribute, string $value) : EqualityFilter
    {
        return new EqualityFilter($attribute, $value);
    }

    /**
     * Create a filter to check for the negation of another filter.
     *
     * @param FilterInterface $filter
     * @return NotFilter
     */
    public static function not(FilterInterface $filter) : NotFilter
    {
        return new NotFilter($filter);
    }

    /**
     * A greater-than-or-equal-to check filter.
     *
     * @param string $attribute
     * @param string $value
     * @return GreaterThanOrEqualFilter
     */
    public static function greaterThanOrEqual(string $attribute, string $value) : GreaterThanOrEqualFilter
    {
        return new GreaterThanOrEqualFilter($attribute, $value);
    }

    /**
     * An alias of greaterThanOrEqual.
     *
     * @param string $attribute
     * @param string $value
     * @return GreaterThanOrEqualFilter
     */
    public static function gte(string $attribute, string $value) : GreaterThanOrEqualFilter
    {
        return self::greaterThanOrEqual($attribute, $value);
    }

    /**
     * A less-than-or-equal-to check filter.
     *
     * @param string $attribute
     * @param string $value
     * @return LessThanOrEqualFilter
     */
    public static function lessThanOrEqual(string $attribute, string $value) : LessThanOrEqualFilter
    {
        return new LessThanOrEqualFilter($attribute, $value);
    }

    /**
     * An alias of lessThanOrEqual.
     *
     * @param string $attribute
     * @param string $value
     * @return LessThanOrEqualFilter
     */
    public static function lte(string $attribute, string $value) : LessThanOrEqualFilter
    {
        return self::lessThanOrEqual($attribute, $value);
    }

    /**
     * Check if any attribute value is present.
     *
     * @param string $attribute
     * @return PresentFilter
     */
    public static function present(string $attribute) : PresentFilter
    {
        return new PresentFilter($attribute);
    }

    /**
     * Create a substring filter (starts with, ends with, contains).
     *
     * @param string $attribute
     * @param null|string $startsWith
     * @param null|string $endsWith
     * @param string[] ...$contains
     * @return SubstringFilter
     */
    public static function substring(string $attribute, ?string $startsWith, ?string $endsWith, string ...$contains) : SubstringFilter
    {
        return new SubstringFilter($attribute, $startsWith, $endsWith, ...$contains);
    }

    /**
     * Creates a substring filter to specifically check if an attribute value contains a value.
     *
     * @param string $attribute
     * @param string[] ...$values
     * @return SubstringFilter
     */
    public static function contains(string $attribute, string ...$values) : SubstringFilter
    {
        return new SubstringFilter($attribute, null, null, ...$values);
    }

    /**
     * Check if an attribute value ends with a specific value.
     *
     * @param string $attribute
     * @param string $value
     * @return SubstringFilter
     */
    public static function endsWith(string $attribute, string $value) : SubstringFilter
    {
        return new SubstringFilter($attribute, null, $value);
    }

    /**
     * Check if an attribute value starts with a specific value.
     *
     * @param string $attribute
     * @param string $value
     * @return SubstringFilter
     */
    public static function startsWith(string $attribute, string $value) : SubstringFilter
    {
        return new SubstringFilter($attribute, $value);
    }

    /**
     * Create an extensible matching rule.
     *
     * @param null|string $attribute
     * @param string $value
     * @param null|string $rule
     * @param bool $matchDn
     * @return MatchingRuleFilter
     */
    public static function extensible(?string $attribute, string $value, ?string $rule, bool $matchDn = false) : MatchingRuleFilter
    {
        return new MatchingRuleFilter($rule, $attribute, $value, $matchDn);
    }

    /**
     * Create an approximate equality check (directory specific implementation).
     *
     * @param string $attribute
     * @param string $value
     * @return ApproximateFilter
     */
    public static function approximate(string $attribute, string $value) : ApproximateFilter
    {
        return new ApproximateFilter($attribute, $value);
    }
}
