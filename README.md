Subjectsplus Shortcodes for Wordpress
========================================

This Wordpress plugin enables shortcodes that can be used to display data 
from the subjectsplus API. 

Setup
----------------------------------------

1. Download the files and place them in your Wordpress plugins folder
2. Edit the main file subjectsplus.php and include your API key and the url for your subjectsplus installation
3. Activate the plugin in the Wordpress plugin settings
4. Use the shortcodes 


Shortcode usage
-----------------------------------------

The shortcodes use a simple syntax. Each subjectsplus shortcode starts begins with sp:
	[sp]

To query the api, you need to choose a service. Currently, subjectsplus has 5 available services. This plugin currently allows you to get staff, guides, and database information. 

	[sp service='staff']

or

	[sp service='database']

Staff shortcodes
-------------------------------------------
This shortcode returns information about a single staff member and displays it without using a table:

	[sp service='staff' email='someone@miami.edu' display='plain']
This shortcode returns information about an entire department and displays it as a table:

	[sp service='staff department='99' display='table']
	
	
Guide shortcodes
--------------------------------------------
This short code returns information about subject guides by subject id:

	[sp service="guides" subject_id="2"]

Return by shortform:

	[sp service="guides" short_form="nursing"]
	

Database shortcodes
--------------------------------------------
This shortcode searches for databases that contain philosophy in the title: 

	[sp service='database' search='Philosophy']

This shortcode returns all the databases that being with A:

	[sp service='database' letter='A']

The results can limited by using attributes:

	[sp service='database' letter='A' max='5']

