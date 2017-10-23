<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDs\Ldap\Asn1;

use PhpDs\Ldap\Asn1\Type\AbstractType;
use PhpDs\Ldap\Asn1\Type\BooleanType;
use PhpDs\Ldap\Asn1\Type\EnumeratedType;
use PhpDs\Ldap\Asn1\Type\IntegerType;
use PhpDs\Ldap\Asn1\Type\NullType;
use PhpDs\Ldap\Asn1\Type\OctetStringType;
use PhpDs\Ldap\Asn1\Type\SequenceOfType;
use PhpDs\Ldap\Asn1\Type\SequenceType;
use PhpDs\Ldap\Asn1\Type\SetOfType;
use PhpDs\Ldap\Asn1\Type\SetType;
use PhpDs\Ldap\Protocol\Element\LdapDn;
use PhpDs\Ldap\Protocol\Element\LdapOid;
use PhpDs\Ldap\Protocol\Element\LdapString;

/**
 * Used to construct various ASN1 structures.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class Asn1
{
    /**
     * @param AbstractType[] ...$types
     * @return SequenceType
     */
    public static function sequence(AbstractType ...$types) : SequenceType
    {
        return new SequenceType(...$types);
    }

    /**
     * @param AbstractType[] ...$types
     * @return SequenceOfType
     */
    public static function sequenceOf(AbstractType ...$types) : SequenceOfType
    {
        return new SequenceOfType(...$types);
    }

    /**
     * @param int $int
     * @return IntegerType
     */
    public static function integer(int $int) : IntegerType
    {
        return new IntegerType($int);
    }

    /**
     * @param bool $bool
     * @return BooleanType
     */
    public static function boolean(bool $bool) : BooleanType
    {
        return new BooleanType($bool);
    }

    /**
     * @param int $enum
     * @return EnumeratedType
     */
    public static function enumerated(int $enum) : EnumeratedType
    {
        return new EnumeratedType($enum);
    }

    /**
     * @return NullType
     */
    public static function null()
    {
        return new NullType();
    }

    /**
     * @param string $string
     * @return OctetStringType
     */
    public static function octetString(string $string)
    {
        return new OctetStringType($string);
    }

    /**
     * @param AbstractType[] ...$types
     * @return SetType
     */
    public static function set(AbstractType ...$types)
    {
        return new SetType(...$types);
    }

    /**
     * @param AbstractType[] ...$types
     * @return SetOfType
     */
    public static function setOf(AbstractType ...$types)
    {
        return new SetOfType(...$types);
    }

    /**
     * @param string $dn
     * @return LdapDn
     */
    public static function ldapDn(string $dn)
    {
        return new LdapDn($dn);
    }

    /**
     * @param string $oid
     * @return LdapOid
     */
    public static function ldapOid(string $oid)
    {
        return new LdapOid($oid);
    }

    /**
     * @param string $ldapString
     * @return LdapString
     */
    public static function ldapString(string $ldapString)
    {
        return new LdapString($ldapString);
    }

    /**
     * @param $tagNumber
     * @param AbstractType $type
     * @return AbstractType
     */
    public static function context(int $tagNumber, AbstractType $type)
    {
        return $type->setTagClass(AbstractType::TAG_CLASS_CONTEXT_SPECIFIC)->setTagNumber($tagNumber);
    }

    /**
     * @param $tagNumber
     * @param AbstractType $type
     * @return AbstractType
     */
    public static function application(int $tagNumber, AbstractType $type)
    {
        return $type->setTagClass(AbstractType::TAG_CLASS_APPLICATION)->setTagNumber($tagNumber);
    }

    /**
     * @param int $tagNumber
     * @param AbstractType $type
     * @return AbstractType
     */
    public static function universal(int $tagNumber, AbstractType $type)
    {
        return $type->setTagClass(AbstractType::TAG_CLASS_UNIVERSAL)->setTagNumber($tagNumber);
    }

    /**
     * @param int $tagNumber
     * @param AbstractType $type
     * @return AbstractType
     */
    public static function private(int $tagNumber, AbstractType $type)
    {
        return $type->setTagClass(AbstractType::TAG_CLASS_PRIVATE)->setTagNumber($tagNumber);
    }
}
