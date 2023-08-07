#!/bin/bash
export $(cat /var/www/html/.env | xargs) &> /dev/null
/usr/local/bin/wp --path=/var/www/html/ eval-file /var/www/html/wp-content/plugins/apo-reporting/crons/daily-statistics.php --allow-root >> /var/log/apo-reporting/daily_statistics_cron.log 2>&1