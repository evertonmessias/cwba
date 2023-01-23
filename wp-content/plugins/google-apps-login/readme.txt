=== Login for Google Apps ===
Contributors: lionsher, nathansingh, chrisakelley
Tags: login, google, authentication, oauth, google login, google apps, Google Workspace, sso, single-sign-on, auth, intranet, g suite
Requires at least: 5.0.0
Tested up to: 6.1.0
Stable tag: 3.4.5
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Simple secure login and user management through your Google Workspace for WordPress
(uses secure OAuth2, and MFA if enabled)

== Description ==

Login for Google Apps allows existing WordPress user accounts to login to your website using Google to securely authenticate their account. This means that if they are already logged into Gmail for example, they can simply click their way through the WordPress login screen - no username or password is explicitly required!

Login for Google Apps uses the latest **secure OAuth2 authentication recommended by Google**, including 2-factor Auth if enabled for your Google Workspace (formerly known asÂ Google AppsÂ andÂ G Suite) accounts.

This is far simpler to configure than the older SAML protocol.

Login for Google Apps is trusted by thousands of organizations from schools to large public companies. Login for Google Apps for WordPress is the most popular enterprise grade plugin enabling login and user management based on your Google Workspace domain.

Its plugin setup requires you to have admin access to any Google Workspace domain, or a regular Gmail account, to register and obtain two simple codes from Google.

= Support and Premium features =

Full support and premium features are also available for purchase:

Eliminate the need for Google Workspace (previous calledÂ Google AppsÂ andÂ G Suite) domain admins to separately manage WordPress user accounts, and get peace of mind only authorized employees have access to your organizations's websites and intranet.

**See [our website at wp-glogin.com](https://wp-glogin.com/glogin/?utm_source=Login%20Readme%20Top&utm_medium=freemium&utm_campaign=Freemium) for more details.**

The Premium version allows everyone in your Google Workspace (Google Apps / G Suite) domain to login to WordPress - an account will be automatically created in WordPress if one doesn't already exist.

Our Enterprise version goes further, allowing you to specify granular access and role controls based on Google Group or Organizational Unit membership.

You can also see logs of accounts created and roles changed by the plugin.

= Extensible Platform =

Login for Google Apps allows you to centralize your site's Google functionality and build your own extensions, or use third-party extensions, which require no configuration themselves and share the same user authentication and permissions that users already allowed for Login for Google Apps itself.

Using our platform, your website appears to Google accounts as one unified 'web application', making it more secure and easier to manage.

[Google Drive Embedder](https://wp-glogin.com/wpgoogledriveembedder) is an extension plugin allowing
users to browse for Google Drive documents to embed directly in their posts or pages.

[Google Apps Directory](https://wp-glogin.com/wpgoogleappsdirectory) is an extension plugin allowing
logged-in users to search your Google Apps employee directory from a widget on your intranet or client site.

[Google Profile Avatars](https://wp-glogin.com/avatars/?utm_source=Login%20Readme%20Avatars&utm_medium=freemium&utm_campaign=Freemium)
is available on our website. It displays users' Google profile photos in place of their avatars throughout your site.

Login for Google Apps works on single or multisite WordPress websites or private intranets.

= Requirements =

One-click login will work for the following domains and user accounts:

*  Google Workspace Starter
*  Google Workspace Business Standard
*  Google Workspace Business Plus
*  Google Workspace Enterprise
*  Google Workspace for Nonprofits
*  Google Workspace for Government
*  Google Classroom (Google Workspace for Education)
*  Personal gmail.com and googlemail.com emails

Login for Google Apps uses the latest secure OAuth2 authentication recommended by Google. Other 3rd party authentication plugins may allow you to use your Google username and password to login, but they do not do this securely unless they also use OAuth2. This is discussed further in the [FAQ](https://wordpress.org/plugins/google-apps-login/#faq).

= Translations =

This plugin currently operates in the following languages:

* English - default
* French (fr_FR) - translated by Lucien Ntumba of [GPC.solutions](http://gpcsolutions.fr/)
* Spanish (es_ES) - translated by David Perez of [Closemarketing](https://www.closemarketing.es/)
* Danish (da_DK) - translated by Alexander Leo-Hansen of [alexanderleohansen.dk](http://alexanderleohansen.dk/)
* Serbo-Croatian (sr_RS) - translated by Borisa Djuraskovic of [Web Hosting Hub](http://www.webhostinghub.com/)
* Arabic (ar_SA) - translated by [Jeremy Varnham](http://profiles.wordpress.org/jvarn13)
* Ukrainian (uk_UA) - translated by Serj Kondrashov
* Dutch (nl_NL) - translated by Noell Taravati of [Peppix](http://www.peppix.nl/)
* Swedish (sv_SE) - translated by Johan Linde of [S/Y ELLEN](http://syellen.se/)
* Italian (it_IT) - translated by Giorgio Draghetti of [tipinoncomuni](http://tipinoncomuni.it/)
* Persian (fa_IR) - translated by [Saeed1000](https://profiles.wordpress.org/saeed1000/)
* Belarussian (be_BY) - translated by Natasha Dyatko of [UStarCash](https://www.ustarcash.com/)
* Indonesian (id_ID) - translated by Jordan Silaen of [ChameleonJohn.com](http://ChameleonJohn.com/)

We welcome volunteers to translate into their own language. If you would like to contribute a translation, please click Translate under Contributors & Developers below.

= Website and Upgrades =

Please see our website [https://wp-glogin.com/](https://wp-glogin.com/?utm_source=Login%20Readme%20Website&utm_medium=freemium&utm_campaign=Freemium) for more information about this free plugin and extra features available in our Premium and Enterprise upgrades, plus support details, other plugins, and useful guides for admins of WordPress sites and Google Apps.

The [Premium and Enterprise versions](https://wp-glogin.com/glogin/?utm_source=Login%20Readme%20PremEnt&utm_medium=freemium&utm_campaign=Freemium) eliminate the need to manage user accounts in your WordPress site - everything is synced from Google Apps instead.

If you are building your organization's intranet on WordPress, try out our [All-In-One Intranet plugin](https://wp-glogin.com/intranet/?utm_source=Login%20Readme%20AIOI&utm_medium=freemium&utm_campaign=Freemium).

== Screenshots ==

1. User will get different styles options for login with google button
2. User login screen can work as normal or via Google's authentication system
3. Login to Google account - only if not already logged in to Google within the browser
4. Admin obtains two simple codes from Google to set up - easy instructions to follow

== Frequently Asked Questions ==

= How can I obtain support for this product? =

Full support is available if you purchase the appropriate license from the author via: [https://wp-glogin.com/glogin/](https://wp-glogin.com/glogin/?utm_source=Login%20Readme%20Premium&utm_medium=freemium&utm_campaign=Freemium)

Please feel free to email [contact@wp-glogin.com](mailto:contact@wp-glogin.com) with any questions, as we may be able to help, but you may be required to purchase a support license if the problem is specific to your installation or requirements.

We may occasionally be able to respond to support queries posted on the 'Support' forum here on the wordpress.org plugin page, but we recommend sending us an email instead if possible.

= Is login restricted to the Google Workspace domain I use to set up the plugin? =

No, once you set up the plugin, any WordPress accounts whose email address corresponds to *any* Google account, whether on a different Google Workspace domain or even a personal gmail.com account, will be able to use 'Login with Google' to easily connect to your WordPress site.

However, our [premium plugin](https://wp-glogin.com/glogin/?utm_source=Login%20Readme%20FAQ&utm_medium=freemium&utm_campaign=Freemium) has features that greatly simplify your WordPress user management if your WordPress users are mostly on the same Google Workspace domain(s).

= Does the plugin work with HTTP or HTTPS login pages? =

The plugin will work whether your site is configured for HTTP or HTTPS.

However, you may have configured your site to run so that the login pages can be accessed by *either* HTTP *or* HTTPS. In that case, you may run into problems.

We recommend that you set [FORCE_SSL_ADMIN](http://codex.wordpress.org/Administration_Over_SSL)
to true. This will ensure that all users are consistently using HTTPS for login.

You may then need to ensure the Redirect URL and Web Origin in the Google Cloud Console are set as HTTPS (this will make sense if you follow the installation instructions again).

If for some reason you cannot set FORCE_SSL_ADMIN, then instead you can add two URLs to the Google Cloud Console for each entry, e.g. Redirect URL = http://wpexample.com/wp-login.php, and then add another one for https://wpexample.com/wp-login.php. Same idea for Web Origin.

= Does the plugin work on Multisite? =

It is written, tested, and secure for multisite WordPress, both for subdirectories and subdomains, and *must* be activated network-wide for security reasons.

There are many different possible configurations of multisite WordPress, however, so you must test carefully if you have any other plugins or special setup.

In a multisite setup, you will see an extra option in Settings -> Login for Google Apps, named 'Use sub-site specific callback from Google'. Read details in the configuration instructions (linked from the Settings page). This setting will need to be ON if you are using any domain mapping plugin, and extra Redirect URIs will need to be registered in Google Cloud Console.

= Is it secure? =

Yes, and depending on your setup, it can be much more secure than just using WordPress usernames and passwords.

However, the author does not accept liability or offer any guarantee, and it is your responsibility to ensure that your site is secure in the way you require.

In particular, other plugins may conflict with each other, and different WordPress versions and configurations may render your site insecure.

= Does it conflict with any other plugins? =

Sometimes conflicts can arise. We have built workarounds for some problems, and would always appreciate your feedback to resolve any issues you might encounter yourself.

One known issue is with iThemes Security: the settings 'filter suspicious query strings' and 'filter long URL strings' can both cause intermittent conflicts and should be turned off if you are happy with the implications.

My Private Site - Try setting the My Private Site option "Omit ?redirect_to= from URL (this option is recommended for Custom Login pages)".

WP Email Login - incompatible with Login for Google Apps

= How does it compare to other 3rd party auth plugins? =

Login for Google Apps uses the latest secure OAuth2 authentication recommended by Google. Other 3rd party authentication plugins may allow you to use your Google username and password to login, but they do not always do this securely:

*  Other plugins: Users' passwords may be handled by your blog's server, potentially unencrypted. If these are compromised, hackers would be able to gain access to your Google email accounts! This includes all
[Google Workspace apps](https://workspace.google.com/features/) (Gmail, Drive, Calendar etc), and any other services which use your Google account to login.

*  This plugin: Users' passwords are only ever submitted to Google itself, then Google is asked to authenticate the user to your WordPress site. This means Multi-factor Authentication can still be used (if set up on your Google account).
Your website only requires permission to authenticate the user and obtain basic profile data - it can never have access to your emails and other data.

= What are the system requirements? =

*  PHP 5.2.x or higher with JSON extensions
*  WordPress 3.5 or above

And you will need a Google account to set up the plugin.


== Installation ==

To set up the plugin, you will need access to a Google Workspace (formally Google Apps / G Suite) domain as an administrator, or just a regular Gmail account.

Easiest way:

1. Go to your WordPress admin control panel's plugin page
1. Search for 'Login for Google Apps'
1. Click Install
1. Click Activate on the plugin
1. Go to 'Login for Google Apps' under Settings in your WordPress admin area
1. Follow the instructions on that page to obtain two codes from Google, and also submit two URLs back to Google

If you cannot install from the WordPress plugins directory for any reason, and need to install from ZIP file:

1. Upload `googleappslogin` directory and contents to the `/wp-content/plugins/` directory, or upload the ZIP file directly in the Plugins section of your WordPress admin
1. Follow the instructions from step 4 above

Personalized instructions to configure the plugin by registering your site with Google Apps are linked from
the WordPress admin panel once you have activated the plugin. For a (non-personalized) preview of these instructions please [click here](https://wp-glogin.com/installing-google-apps-login/basic-setup/).

== Changelog ==

= 3.4.5 =

Updated: Plugin name.
Fixed: Admin escaping

= 3.4.4 =

Updated compatibility with the WordPress 5.7 release.
Login with the google button removed static images generated same button using HTML code and use google svg icon
Bug fixed for header already sent

= 3.4.3 =

Updated compatibility with the WordPress 5.6 release.

= 3.4.2 =

Added missing alt attribute in image tag.
Set httponly flag in cookie.
Added custom text support for login with google button.

= 3.4.1 =

Bug fixing for PHP Notice: Undefined index: approval_prompt.
Bug Fixing for PHP Deprecated: Array and string offset access syntax with curly braces is deprecated.

= 3.4 =

Bug fixing for Invalid parameter value for approval_prompt: 'auto'.
Updated compatibility with the WordPress 5.4 release.


= 3.3 =

Added permission check functionality
Added Google Drive Embedder insufficient permission error fixes
Added Login With Google buttons branding
Updated compatibility with the WordPress 5.3.1 release

= 3.2 =

Added workaround for incompatibility with WPMU Defender plugin's new 2FA feature.
Updated compatibility with the upcoming WordPress 4.9 release.

= 3.0 =

Internal changes to Google Client library. Essential for the latest versions of some extension plugins such as Google Drive Embedder.

