# Reverb Walkthrough

This is a walkthrough of how to configure Laravel Reverb for production using services like Laravel Forge or Ploi. The first step is nginx configuration changes, then .env changes and finally spinning up your Reverb server.

## 1. Configuring Nginx

Ensure your nginx site configuration has the following inside the server block:

```
    location /app {
    proxy_http_version 1.1;
    proxy_set_header Host $http_host;
    proxy_set_header Scheme $scheme;
    proxy_set_header SERVER_PORT $server_port;
    proxy_set_header REMOTE_ADDR $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "Upgrade";

    proxy_pass http://0.0.0.0:8080;
}
```

The /app is the path for Reverb and is not your application path, do not change it. Pasting this block of code inside your nginx site configuration file should be good enough.

**Note**: The port '8080' here is the port that Reverb listens on, it is 8080 by default and should be okay unless you have multiple Laravel apps on the same server using Reverb. Adjust if necessary.


## 2. Updating your .env

Your .env file is pretty important and should contain the following configuration options at minimum in order to configure Reverb.

```
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=set-a-key-here
REVERB_APP_SECRET=set-a-secret
REVERB_HOST=site.com
REVERB_PORT=443
REVERB_SCHEME=https
REVERB_SERVER_HOST=127.0.0.1
REVERB_SERVER_PORT=8080
BROADCAST_CONNECTION=reverb

### DO NOT REMOVE ###
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
# If you remove this, Reverb will break.
```

The notes below contain more information so please read them. 

**Note**: The `REVERB_HOST` variable should match your site url, so laravel.com etc. No HTTP/HTTPS needed. Ensure you set your app id, key and secret. 

**Note 2**: Please ensure the port number matches the one specified in your nginx site configuration file.

**Note 3**: Please ensure your broadcasting connection is set to Reverb, this escaped me for an hour! 

**Note 4**: I have included the VITE variables here for completeness sake. Your app may not use VITE but if it does, make sure you've got these variables included otherwise it will complain about a pusher key.

## 3. Spawning Reverb's Server

I use Ploi which has a one-click button, however as long as you're able to create a daemon on your server that's all you need. My Reverb server command looks like:

```
php /home/ploi/site.com/artisan reverb:start --host=127.0.0.1 --port=8080 --no-interaction
```

Adjust the file path to your site but keep the --host and port parameters consistent. You may use the `--debug` option as well should you wish.


This should be everything needed to get Laravel Reverb working in production, this was made from the installation of my app with working Reverb. 

Please ensure your port number is consistent throughout otherwise there will be issues.
