<?php

namespace App\Service;

use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;


class TokenService
{
    public function generateToken(string $uid): string
    {
        $now   = new DateTimeImmutable();
        $algorithm = new Sha256();
        $tokenBuilder = new Builder(new JoseEncoder(), ChainedFormatter::default());
        $signingKey   = InMemory::plainText(random_bytes(32));
        $token = $tokenBuilder->withClaim('uid', $uid)
            ->expiresAt($now->add(new DateInterval('P90D')))
            ->getToken($algorithm, $signingKey);

        return $token->toString();
    }
}