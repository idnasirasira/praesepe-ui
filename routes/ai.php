<?php

declare(strict_types=1);

use App\Mcp\Servers\PraesepeUiServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::local('praesepe-ui', PraesepeUiServer::class);

Mcp::web('/mcp/praesepe-ui', PraesepeUiServer::class)
    ->middleware(['throttle:mcp']);
