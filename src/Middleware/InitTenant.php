<?php

namespace LaraZeus\Tartarus\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use LaraZeus\Tartarus\TartarusPlugin;
use Symfony\Component\HttpFoundation\Response;

class InitTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $this->makeSubdomain($request->getHost());

        if ($subdomain === 'www') {
            return redirect()->away(config('zeus-tartarus.central_domain'));
        }
        $company = TartarusPlugin::getModel('Company')::where('subdomain', $subdomain)->first();

        abort_if($company === null, 404);

        $request->session()->put('company', $company);

        URL::defaults(['domain' => $subdomain]);

        return $next($request);
    }

    protected function makeSubdomain(string $hostname): string
    {
        return explode('.', $hostname)[0];
    }
}
