echo "Docker container has been started"

# Setup a cron schedule
echo "*/2 * * * * /run.sh >> /var/log/cron.log 2>&1
# This extra line makes it a valid cron" > scheduler.txt

crontab scheduler.txt
cron -f