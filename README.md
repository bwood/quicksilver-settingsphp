# quicksilver-settingsphp
## Use Case
In our repository we commited sites/default/settings.php and then in a subsequent commit we added this file to .gitignore.  The result is that when we spin-up
a new Pantheon site from our upstream we get our version-controlled settings.php containing our domain-normalization code template.  The site builder can then
commit the custom domain normalization code needed for the site without causing git conflicts when we apply updates in the future.
 
Now we want to change the settings.php code in our upstream respository. If we do this it will result in git conflicts when we apply updates to our existing sites
which have customizations in their settings.php files. 

These [Quicksilver](https://pantheon.io/docs/articles/sites/quicksilver/) scripts are an experimental workaround for this problem. The idea was to backup the 
customized settings.php file using `sync_code: before` and then restore the customized settings.php using `sync_code: after`.  The hope was to acheive the following:

* Changes to settings.php exist in the upstream repo.
* pantheon.yml and the private directory are manually commited  to each individual site.  *These files are not committed to our upstream repo.*
* The site has a customizationations to the settings.php that was originally commited to the upstream repo.
* We apply updates with "Auto resolve conflicts" (-Xtheirs) checked.
* The backup_settings.php script gets triggered by `sync_code: before` and the customized settings.php is backed up to a safe, temporary location.
* The git merge overwrites the site's customized settigns.php
* The restore_settings.php script gets triggered by `sync_code: after` and the customized settings.php is restored, overwriting the new file that was merged from the upstream repository.

This enables the following smooth process for cutting existing sites over to the new settings.php code:

* Any new site we spin up will have the latest settings.php code.
* Existing sites will continue using their existing settings.php code until they can be manually cutover to the new code. (A gitignored config file needs to be created for these sites.)

[Here's an issue for discussion of the big flaw with this plan](https://github.com/bwood/quicksilver-settingsphp/issues/1).

### Manual cutover of existing sites

FYI, here's how sites that were spun up before this code was added would be
cutover to use this code:

1. The new settings.php will be
copied, commited and pushed to the individual site repository. This file will be identical to the
current settings.php in the upstream repo.
2. The site's pantheon.yml will be removed thereby disabling Quicksilver. The next time updates are applied, we will not see conflicts related to settings.php.
