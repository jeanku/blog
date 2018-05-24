<?php

namespace App\Util\lib\Factory;

use App\Util\lib\Transport\TTransport;

class TTransportFactory
{
    /**
     * @static
     * @param TTransport $transport
     * @return TTransport
     */
    public static function getTransport(TTransport $transport)
    {
        return $transport;
    }
}
