# Blog-Post-Permalink
A simple blog posting script using HTML, JavaScript, and PHP. The script allows users to create and post blog entries.

To get started:
1. Import the 'import_this_in_database.sql' file into your database. This file contains the necessary table structure for storing the blog posts after they are submitted.
2. Modify the database connection details in the 'php/config.php' file to match your actual database configuration. This ensures that the script can connect to your database successfully.

How the script works:
1. When the submit button is pressed, a JSON request is sent to the 'php/blog_post_permalink.php' file. The request is made using JavaScript and prevents the page from being reloaded.
2. The 'php/blog_post_permalink.php' file receives all the POST data from the request.
3. The PHP code in 'php/blog_post_permalink.php' inserts the blog post data into the database. If the insertion is successful, it adds the permalink to the '.htaccess' file, replacing the existing link.

By following these steps, users can create and publish their blog posts, and the script will handle the database insertion and permalink generation for each post.
