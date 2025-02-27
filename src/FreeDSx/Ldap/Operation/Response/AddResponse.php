<?php
/**
 * This file is part of the FreeDSx LDAP package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FreeDSx\Ldap\Operation\Response;

use FreeDSx\Ldap\Operation\LdapResult;

/**
 * RFC 4511 Section 4.7
 *
 * AddResponse ::= [APPLICATION 9] LDAPResult
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class AddResponse extends LdapResult
{
    /**
     * @var int
     */
    protected $tagNumber = 9;
}
