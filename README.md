#LATCH INSTALLATION GUIDE FOR WORDPRESS


##PREREQUISITES
 * WordPress version 1.5 or later.

 * Curl extensions active in PHP (uncomment **"extension=php_curl.dll"** or"** extension=curl.so"** in Windows or Linux php.ini respectively.

 * To get the **"Application ID"** and **"Secret"**, (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in [Latch's website](https://latch.elevenpaths.com"https://latch.elevenpaths.com"). On the upper right side, click on **"Developer area"**.


##DOWNLOADING THE WORDPRESS PLUGIN
 * When the account is activated, the user will be able to create applications with Latch and access to developer documentation, including existing SDKs and plugins. The user has to access again to [Developer area](https://latch.elevenpaths.com/www/developerArea"https://latch.elevenpaths.com/www/developerArea"), and browse his applications from **"My applications"** section in the side menu.

* When creating an application, two fundamental fields are shown: **"Application ID"** and **"Secret"**, keep these for later use. There are some additional parameters to be chosen, as the application icon (that will be shown in Latch) and whether the application will support OTP  (One Time Password) or not.

* From the side menu in developers area, the user can access the **"Documentation & SDKs"** section. Inside it, there is a **"SDKs and Plugins"** menu. Links to different SDKs in different programming languages and plugins developed so far, are shown.


##INSTALLING THE PLUGIN IN WORDPRESS
* Once the administrator has downloaded the plugin, it has to be added as a plugin in its administration panel in WordPress. Click on **"Plugins"** and **"Add new"**. It will show a form where you can browse and select previously downloaded ZIP file.

* Go to **"Latch settings"**, inside **"Settings"** and introduce **"Application ID"** and **"Secret"** previously generated. The administrator can now save the changes clicking on **"Save"**. If everything is ok, a confirmation message will be received.

* From now on, on user's profile, a new textbox will appear, inside **"Profile"** menu, where the token generated from the app should be introduced.


##UNINSTALLING THE PLUGIN IN WORDPRESS
* To remove the plugin, the administrator has to click on **"Plugins"** and press the **"Deactivate"** link below the **"Latch"** plugin, and then press the link “Delete”.


##USE OF LATCH MODULE FOR THE USERS
**Latch does not affect in any case or in any way the usual operations with an account. It just allows or denies actions over it, acting as an independent extra layer of security that, once removed or without effect, will have no effect over the accounts, that will remain with its original state.**

###Pairing a user in WordPress
The user needs the Latch application installed on the phone, and follow these steps:

* **Step 1:** Logged in your own  WordPress account and go to **"Profile"**.

* **Step 2:** From the Latch app on the phone, the user has to generate the token, pressing on **“Add a new service"** at the bottom of the application, and pressing **"Generate new code"** will take the user to a new screen where the pairing code will be displayed.

* **Step 3:** The user has to type the characters generated on the phone into the text box displayed on the web page. Click on **"Update Profile"** button.

* **Step 4:** Now the user may lock and unlock the account, preventing any unauthorized access.

###Unpairing a user in WordPress
* The user should access their WordPress account and under the **“Profile”** section tick the **“Stop using Latch”** box, then tap the **“Update Profile”** button. He will receive a notification indicating that the service has been unpaired.



##RESOURCES
- You can access Latch´s use and installation manuals, together with a list of all available plugins here: [https://latch.elevenpaths.com/www/developers/resources](https://latch.elevenpaths.com/www/developers/resources)

- Further information on de Latch´s API can be found here: [https://latch.elevenpaths.com/www/developers/doc_api](https://latch.elevenpaths.com/www/developers/doc_api)

- For more information about how to use Latch and testing more free features, please refer to the user guide in Spanish and English:
	1. [English version](https://latch.elevenpaths.com/www/public/documents/howToUseLatchNevele_EN.pdf)
	1. [Spanish version](https://latch.elevenpaths.com/www/public/documents/howToUseLatchNevele_ES.pdf)

