# Codebase Notifications via Notify.io

This repository contains a script to translate a HTTP JSON Post from your [Codebase](http://codebasehq.com) account to your [Notify.io](http://notify.io) account.

You can get desktop notifications for Notify.io by installing the [desktop client](http://www.notify.io/getstarted).

Author: Nick Jones (<http://www.nicksays.co.uk>)

## Example

On Mac, you'll get little notifications like this:

![Ticket Creation](http://dl.dropbox.com/u/192363/github/codebase-notifyio/new_ticket.png)
![Ticket Update](http://dl.dropbox.com/u/192363/github/codebase-notifyio/updated_ticket.png)
![Git Push](http://dl.dropbox.com/u/192363/github/codebase-notifyio/git_push.png)
![Deployment](http://dl.dropbox.com/u/192363/github/codebase-notifyio/deployment.png)

## Configuration

You'll need to set up notifications from your Codebase account in the "Notifications" tab when viewing your global dashboard.

There are four class variables that you need to set in the `Config.php` file:

* `$CODEBASE_HTTP_USER`: The HTTP Basic username you entered when you set up your notifications within Codebase.
* `$CODEBASE_HTTP_PASS`: The HTTP Basic password you entered at the same time as the username.  Note, these aren't your Codebase details.
* `$NIO_EMAIL_ADDRESS`: An email address attached to your Notify.io account.
* `$NIO_API_KEY`: Your Notify.io API key, which can be found in your Notify.io account on [http://notify.io](http://notify.io).
