<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDs\Ldap;

use PhpDs\Ldap\Control\Control;
use PhpDs\Ldap\Control\ControlBag;
use PhpDs\Ldap\Control\Sorting\SortingControl;
use PhpDs\Ldap\Control\Sorting\SortKey;
use PhpDs\Ldap\Operation\Request\ExtendedRequest;
use PhpDs\Ldap\Operation\Request\RequestInterface;
use PhpDs\Ldap\Operation\Request\SearchRequest;
use PhpDs\Ldap\Protocol\ClientProtocolHandler;
use PhpDs\Ldap\Protocol\LdapMessageResponse;
use PhpDs\Ldap\Search\Paging;
use PhpDs\Ldap\Search\Vlv;

/**
 * The LDAP client.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class LdapClient
{
    /**
     * @var array
     */
    protected $options = [
        'version' => 3,
        'servers' => [],
        'port' => 389,
        'base_dn' => null,
        'page_size' => 1000,
        'use_ssl' => false,
        'use_tls' => false,
        'ssl_validate_cert' => true,
        'ssl_allow_self_signed' => null,
        'ssl_ca_cert' => null,
        'ssl_peer_name' => null,
        'timeout_connect' => 3,
        'timeout_read' => 15,
        'logger' => null,
    ];

    /**
     * @var ClientProtocolHandler
     */
    protected $handler;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = array_merge($this->options, $options);
        $this->handler = new ClientProtocolHandler($this->options);
    }

    /**
     * Bind to LDAP with a username and password.
     *
     * @param string $username
     * @param string $password
     * @return LdapMessageResponse
     * @throws \PhpDs\Ldap\Exception\BindException
     */
    public function bind(string $username, string $password)
    {
        return $this->handler->send(Operations::bind($username, $password)->setVersion($this->options['version']));
    }

    /**
     * Send a search response and return the entries.
     *
     * @param SearchRequest $request
     * @param Control[] ...$controls
     * @return \PhpDs\Ldap\Entry\Entry[]
     */
    public function search(SearchRequest $request, Control ...$controls)
    {
        /** @var \PhpDs\Ldap\Operation\Response\SearchResponse $response */
        $response = $this->send($request, ...$controls)->getResponse();

        return $response->getEntries();
    }

    /**
     * A helper for performing a paging based search.
     *
     * @param SearchRequest $search
     * @param int $size
     * @return Paging
     */
    public function paging(SearchRequest $search, ?int $size = null)
    {
        return new Paging($this, $search, $size ?? $this->options['page_size']);
    }

    /**
     * A helper for performing a VLV (Virtual List View) based search.
     *
     * @param SearchRequest $search
     * @param SortingControl|string|SortKey $sort
     * @param int $afterCount
     * @return Vlv
     */
    public function vlv(SearchRequest $search, $sort, int $afterCount)
    {
        return new Vlv($this, $search, $sort, $afterCount);
    }

    /**
     * Send a request operation to LDAP.
     *
     * @param RequestInterface $request
     * @param Control[] ...$controls
     * @return LdapMessageResponse
     */
    public function send(RequestInterface $request, Control ...$controls) : LdapMessageResponse
    {
        return $this->handler->send($request, ...$controls);
    }

    /**
     * Issue a startTLS to encrypt the LDAP connection.
     *
     * @return $this
     */
    public function startTls()
    {
        $this->handler->send(Operations::extended(ExtendedRequest::OID_START_TLS));

        return $this;
    }

    /**
     * Unbind and close the LDAP TCP connection.
     *
     * @return $this
     */
    public function unbind()
    {
        $this->handler->send(Operations::unbind());

        return $this;
    }

    /**
     * Perform a whoami request and get the returned value.
     *
     * @return string
     */
    public function whoami() : string
    {
        /** @var \PhpDs\Ldap\Operation\Response\ExtendedResponse $response */
        $response = $this->send(Operations::whoami())->getResponse();

        return $response->getValue();
    }

    /**
     * Access to add/set/remove/reset the controls to be used for each request. If you want request specific controls in
     * addition to these, then pass them as a parameter to the send() method.
     *
     * @return ControlBag
     */
    public function controls() : ControlBag
    {
        return $this->handler->controls();
    }

    /**
     * Get the options currently set.
     *
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * Merge a set of options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param ClientProtocolHandler $handler
     * @return $this
     */
    public function setProtocolHandler(ClientProtocolHandler $handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Try to clean-up if needed.
     */
    public function __destruct()
    {
        if ($this->handler && $this->handler->getTcpClient() !== null && $this->handler->getTcpClient()->isOpen()) {
            $this->unbind();
        }
    }
}
