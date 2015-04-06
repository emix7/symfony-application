<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WsseBundle\Service;

class HeaderService
{
    /**
     * Creates a X-WSSE header.
     *
     * @param $username
     * @param $secret
     *
     * @return string
     */
    public function create($username, $secret)
    {
        $nonce = md5(uniqid('', true));
        $created = date('Y-m-d H:i:s');

        $digest = base64_encode(sha1(base64_decode($nonce).$created.$secret, true));

        return 'UsernameToken Username="'.$username.'", PasswordDigest="'.$digest.'", Nonce="'.$nonce.'", Created="'.$created.'"';
    }
}
