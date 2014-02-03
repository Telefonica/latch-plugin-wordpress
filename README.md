===LATCH PLUGIN INSTALLATION IN WORDPRESS===

==PREREQUISITES ==

*WordPress version 1.5 or later.

*Curl extensions active in PHP (uncomment "extension=php_curl.dll" or" extension=curl.so" in Windows or Linux php.ini respectively.

*To get the "Application ID" and "Secret", (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in Latch's website: https://latch.elevenpaths.com. On the upper right side, click on "Developer area".

==GETTING THE PLUGIN FOR WORDPRESS==

*When the account is activated, the user will be able to create applications with Latch and access to developer documentation, including existing SDKs and plugins. The user has to access again to "Developer area" (https://latch.elevenpaths.com/www/developerArea), and browse his applications from "My applications" section in the side menu.

*When creating an application, two fundamental fields are shown: "Application ID" and "Secret", keep these for later use. There are some additional parameters to be chosen, as the application icon (that will be shown in Latch) and whether the application will support OTP  (One Time Password) or not.

*From the side menu in developers area, the user can access the "Documentation & SDKs" section. Inside it, there is a "SDKs and Plugins" menu. Links to different SDKs in different programming languages and plugins developed so far, are shown.

==NSTALLING THE MODULE IN WORDPRESS==

*Once the administrator has downloaded the plugin, it has to be added as a module in its administration panel in WordPress. Click on "Plugins" and "Add new". It will show a form where you can browse and select previously downloaded ZIP file.

*Go to "Latch settings", inside "Settings" and introduce "Application ID" and "Secret" previously generated. The administrator can now save the changes clicking on "Save". If everything is ok, a confirmation message will be received.

*From now on, on user's profile, a new textbox will appear, inside "Profile" menu, where the token generated from the app should be introduced.

