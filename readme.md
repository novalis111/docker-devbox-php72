# PHP Devbox

docker stack with nginx, php7.2-fpm (based on debian-stretch:slim) and mysql:latest

## Installation
1. Copy .env.example to .env and adjust as needed
2. Adjust nginx.conf if needed
3. Create or symlink folder "app", for testing you can copy provided index.php into it
4. Run 'docker-compose up' and wait
5. Open http://devbox.localhost/ in your browser (or other URL if you changed nginx.conf)

## Config
In your IDE set xdebug Port to 9000 and in your browser set IDE Key to "PHPSTORM". Enable listening in your IDE and reload the page. Your IDE should pick up the connection and complain about no defined server.
Add a server with name "docker", host "localhost" and port "80" with xdebug. Set up path mappings if needed and start debugging.

For Mac there is an additional step to handle port bindings and IP resolution because docker runs in a VM. See the links below.

## Links
- https://www.arroyolabs.com/2016/10/docker-xdebug/
