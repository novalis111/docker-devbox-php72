# PHP Devbox

docker stack with nginx, php7.2-fpm (based on debian-stretch:slim) and mysql:latest

## Installation
1. Copy .env.example to .env and adjust as needed
2. Adjust nginx.conf if needed
3. Run 'docker-compose up' and wait
4. Open http://devbox.localhost/ in your browser (or other URL if you changed nginx.conf)
