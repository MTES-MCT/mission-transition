# Debugging

---

## Notes debugging - 2023-04-28 - local development

With Cedric Merouini & Julien Paris

Goal : debugging local development setup


### Docker

Notes :

```bash
# check containers
docker ps

# remove containers
docker compose down # deletes containers
docker compose stop # just stops containers without removing them
```

Needs to override default config

```bash
# run docker compose with override
docker compose -f ./docker-compose.yml -f ./docker-compose.override.yml up
```

$\to$ success : resolves the problem



### Caddy

Notes :

- Light server (similar to NGINX)
- ref https://www.atlantic.net/vps-hosting/how-to-install-and-configure-caddy-web-server-with-php-on-rocky-linux-8/

Error :

```
mission-transition-caddy-1     | Error: adapting config using caddyfile: parsing caddyfile tokens for 'servers': /etc/caddy/Caddyfile:7 - Error during parsing: unrecognized protocol option 'experimental_http3' 
```

Debug cause : `experimental_http3` causing problem
$\to$ comment corresponding lines in CaddyFile (config file for Caddy server)

```
# ./docker/caddy/CaddyFile

# {
#     # Debug
#     {$DEBUG}
#     # HTTP/3 support
#     servers {
#         protocol {
#             experimental_http3
#         }
#     }
# }
```

### Php 

Error 

```bash
mission-transition-php-1       | setfacl: var: Not supported
mission-transition-php-1       | setfacl: var/cache: Not supported
mission-transition-php-1       | setfacl: var/log: Not supported
```

Done : comment lines in `docker/php/docker-entrypoint.sh`
Check : https://discussions.apple.com/thread/4805409

```sh
  # setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
  # setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

  # TO DO : change setfacl to chmod commands
```

Fix temporarily but then another error :

```
docker compose exec php yarn encore dev
yarn run v1.22.19
$ /srv/api/node_modules/.bin/encore dev
Running webpack ...

node:internal/crypto/hash:71
  this[kHandle] = new _Hash(algorithm, xofLen);
                  ^

Error: error:0308010C:digital envelope routines::unsupported
    at new Hash (node:internal/crypto/hash:71:19)
    at Object.createHash (node:crypto:133:10)
    at module.exports (/srv/api/node_modules/webpack/lib/util/createHash.js:135:53)
    at NormalModule._initBuildHash (/srv/api/node_modules/webpack/lib/NormalModule.js:417:16)
    at handleParseError (/srv/api/node_modules/webpack/lib/NormalModule.js:471:10)
    at /srv/api/node_modules/webpack/lib/NormalModule.js:503:5
    at /srv/api/node_modules/webpack/lib/NormalModule.js:358:12
    at /srv/api/node_modules/loader-runner/lib/LoaderRunner.js:373:3
    at iterateNormalLoaders (/srv/api/node_modules/loader-runner/lib/LoaderRunner.js:214:10)
    at Array.<anonymous> (/srv/api/node_modules/loader-runner/lib/LoaderRunner.js:205:4)
    at Storage.finished (/srv/api/node_modules/enhanced-resolve/lib/CachedInputFileSystem.js:55:16)
    at /srv/api/node_modules/enhanced-resolve/lib/CachedInputFileSystem.js:91:9
    at /srv/api/node_modules/graceful-fs/graceful-fs.js:123:16
    at FSReqCallback.readFileAfterClose [as oncomplete] (node:internal/fs/read_file_context:68:3) {
  opensslErrorStack: [ 'error:03000086:digital envelope routines::initialization error' ],
  library: 'digital envelope routines',
  reason: 'unsupported',
  code: 'ERR_OSSL_EVP_UNSUPPORTED'
}

Node.js v18.14.2
error Command failed with exit code 1.
info Visit https://yarnpkg.com/en/docs/cli/run for documentation about this command.
make: *** [front-build-dev] Error 1
```

This is a webpack error

Leads : 

- https://github.com/webpack/webpack/issues/14532
- https://symfony.com/doc/current/frontend/encore/installation.html

```bash
# reinstall webpack-encore
docker compose exec php composer remove symfony/webpack-encore-bundle
docker compose exec php composer require symfony/webpack-encore-bundle

# then restore previous files (changed due to reinstalling webpack)
git status # to check changed files
git restore assets/app.js composer.json composer.lock config/bundles.php symfony.lock yarn.lock package.json config/packages/webpack_encore.yaml

```

Then add `NODE_OPTION` as env var in `docker-compose-override.yaml`

```yaml
    ...
    environment:
      APP_ENV: dev
      NODE_OPTIONS: --openssl-legacy-provider
    ...
```

```bash
# check if env is correctly set
docker compose exec php env | grep OPTIONS 

# should return
NODE_OPTIONS=--openssl-legacy-provider
```

### Populate DB & run 

```bash
# cf ./Makefile

make build
make install

# Another way to go
make build
make start
make front-install
make front-build-dev

# Populate db with fake data
make fixture
make db

# Populate db with fake user
docker compose exec php bin/console app:create-admin --help
docker compose exec php bin/console app:create-admin email@email.com 12345

# Populate db with real data
docker compose exec php bin/console app:import-data-from-at --help
docker compose exec php bin/console app:import-data-from-at


```

All those steps should do the trick, you should see the app on :

```bash
# check in browser
http://localhost

# or the admin page
http://localhost/admin
```

### Other questions

#### Scalingo

- Continuous deployment ? $\to$ no, needs Scalingo CLI to redeploy (check Scalingo doc)
- Preprod URL ? $\to$ no, check Scalingo
- Sandbox URL ? $\to$ no, check Scalingo

Notes :

- Possible to add a sclingo git user for continous deployment
- cf doc scalingo > documentation > how to deploy
