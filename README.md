# France Transition

```
# Install and start the services (database, cache, queue, ...)
docker-compose up -d

# Install PHP dependencies
composer install

# Install JS dependencies
yarn install

# Build JS dev files
yarn dev

# Start the local webserver (add -d to run in the background)
symfony serve

# Access on the URL given
# Services are automatically wired using Docker-Compose integration
```
