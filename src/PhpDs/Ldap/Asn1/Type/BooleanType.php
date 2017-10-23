<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDs\Ldap\Asn1\Type;

/**
 * Represents an ASN1 boolean type.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class BooleanType extends AbstractType
{
    protected $tagNumber = self::TAG_TYPE_BOOLEAN;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        parent::__construct($value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setValue(bool $value)
    {
        $this->value = $value;

        return $this;
    }
}
