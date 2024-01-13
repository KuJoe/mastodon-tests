# mastodon-tests
This is a list of scripts I use to monitor my Mastodon instances.

### Installation
1) Edit the scripts with your server(s) information.
2) Upload the files to a webserver with PHP that can access your server(s) directly.
*OPTIONAL IF YOU WANT TO MONITOR WEB/PUMA STATS*
3) Edit your **/home/mastodon/live/config/puma.rb** file to allow for the stats output (see the notes in puma.php for those steps).

## PHP Modules Used
These are the list of PHP modules I needed to install to get all of these scripts to work:
- sqlite3
- xml
- zip
- mysqli
- intl
- mbstring
- pgsql
- curl
- redis

Here's the command I had to run to install these after configuring my server with PHP 8.2:
*apt install php8.2-sqlite3 php8.2-xml php8.2-zip php8.2-mysql php8.2-intl php8.2-mbstring php8.2-pgsql php8.2-curl php8.2-redis*

### Additional Notes
I have these scripts running on an nginx server (with php8.2-fpm installed) which is on a private network, these scripts may or may not work for you depending on your networking setup.

I had to edit some of the scripts slightly from what I'm using because I have multiple Sidekiq, Streaming, and Web servers so I removed all of the extra calls to those servers but these should work properly for single server instances. If you need to add more servers I will put together a separate document for that.

### Monitoring and Alerting

I monitor the output of these pages using [Uptime Kuma](https://github.com/louislam/uptime-kuma) with the following settings for each monitor:

Monitor Type: **HTTP(s) - Keyword**
Friendly Name: **<NAME_OF_SERVICE>**
URL: **http://<IP_OF_NGINX_SERVER>/<FILENAME>.php**
Keyword: **HEALTHY**

![A screenshot of an example Uptime Kuma monitor config](https://a.cdn9000.com/grIQca7hmOYRHTqC/2024-01-13124435.png "Uptime Kuma example")

For alerting, I have Uptime Kuma tied in with Pager Duty for easy management of my alerts.