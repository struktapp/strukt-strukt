# Strukt

The application skeleton for the `strukt4` package set. It ships almost
nothing of its own: a `composer.json` that pulls in
[`strukt/framework`](../framework) and a `post-create-project-cmd` hook that
scaffolds a runnable application through the framework console. Everything
under `app/`, `cfg/`, `templates/`, `lib/`, plus `index.php` and `.env`, is
generated and git-ignored.

## Getting started

```sh
composer create-project strukt/strukt --prefer-dist
```

The install hook prompts for an application name, then runs two commands for
you:

```sh
vendor/bin/strukt app:make              # prompts for the name; scaffolds app/src/<Name>/..., cfg/*.ini and templates/
vendor/bin/strukt app:reload            # lib/App/Loader.php, index.php, .env
```

The result is a ready-to-run project:

```
.
├── app/
│   └── src/
│       └── {{app}}/
│           ├── User.php
│           └── AuthModule/
│               ├── {{app}}AuthModule.php     # the module (alias "au")
│               ├── Controller/User.php       # scaffolded, see "Controller facet"
│               ├── Form/User.php
│               ├── Router/Index.php
│               └── Tests/UserTest.php
├── cfg/                                      # generated application config
│   └── app.ini
├── templates/                                # editable scaffolding templates
├── lib/
│   └── App/
│       └── Loader.php                        # generated, do not edit
├── index.php                                 # generated front controller
├── .env                                      # generated environment
├── composer.json
└── vendor/
```

## Run it

```sh
vendor/bin/strukt app:exec
# Serving on http://127.0.0.1:8080
```

Visit `http://127.0.0.1:8080/` and `http://127.0.0.1:8080/hello/ada` — the
generated `AuthModule` ships with a `welcome` and a `hello` route.

## Controller facet

`Controller/User.php` is scaffolded as a stub and is not routed by the generated
app — routes only come from `Router/` classes. It exists to illustrate the
controller facet, whose actions other facets reach through the module alias:

```php
// inside a router
return $this->get('au.ctr.User')->find($id);
```

The registrar indexes it as `nr.au.ctr.User`, and `core('au.ctr.User')` (or
`Core::get()`) resolves it through the `facet` provider. Real action classes can
either live here and be called this way, or sit directly in a router — the RBAC
routes in this skeleton take the latter approach for brevity.

## Working in the monorepo

The skeleton resolves `strukt/framework` and its siblings through Composer
`path` repositories (`../framework`, `../base`, …), so it installs against the
working copies next to it:

```sh
composer install
vendor/bin/strukt app:make {{app}}
vendor/bin/strukt app:reload
```

`bin/clear` resets the project back to its seed state by deleting every
generated artifact.

## Sessions

The generated `lib/App/Provider/Session.php` binds the router's native
`$_SESSION` store — all a single-server app needs:

```php
use Strukt\Contract\Http\SessionInterface;
use Strukt\Http\Session\Native;

router()->session(static fn (): SessionInterface => new Native());
router()->middleware('sess');
```

To share sessions across processes or servers, swap in the router's
cache-backed store, which writes through to a `strukt/cache` driver so any
worker can resume the session:

```php
use Strukt\Http\Session\Cache;

router()->session(static fn (): SessionInterface => new Cache(memc('sess')));
```

`memc()` is the cache package's memcached helper. Give each client its own
namespace (`memc('sess_' . $sid)`) to keep sessions isolated. See the router's
[HTTP layer](../router/docs/http-layer.md#session-store) and
[authentication](../router/docs/authentication.md) docs for the full set of
stores.

## Common commands

| Command | Purpose |
| --- | --- |
| `app:make [<name>]` | Scaffold an application (`app/src/<Name>`, `cfg/app.ini`). Prompts for the name when omitted. |
| `app:reload` | Regenerate `lib/App/Loader.php`, `index.php`, `.env`. |
| `app:exec` | Serve the application with the PHP built-in server. |
| `module:make <app> <module> <alias>` | Add a module to an application. |
| `route:make [<module>] [<name>] [<route>]` | Scaffold or extend a router. |
| `route:ls` | List registered routes. |
| `shell:exec` | Open the interactive console. |

## Documentation

The framework documentation lives in [`../framework/docs`](../framework/docs):
[getting started](../framework/docs/getting-started.md),
[routing](../framework/docs/routing.md),
[forms and validation](../framework/docs/forms-and-validation.md),
[console](../framework/docs/console.md),
[configuration](../framework/docs/configuration.md), and
[extensions](../framework/docs/extensions.md).

## License

MIT. See [LICENSE](LICENSE).
