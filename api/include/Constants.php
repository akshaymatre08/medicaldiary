<?php

///////////////////////////////////////////////////// CHANGED INFORMATION /////////////////////////////////////////////////////

//Database Connection
define('DB_NAME','stockmanagement');   //your database username
define('DB_USER', 'root');          //your database name
define('DB_PASS', '');              //your database password
define('DB_HOST', 'localhost');     //your database host name


define('WEBSITE_DOMAIN', 'http://localhost/medicaldiary/api/public/');
define('WEBSITE_EMAIL', 'socialcodia@gmail.com');                    //your email address
define('WEBSITE_EMAIL_PASSWORD', 'PASSWORD');                        //your email password
define('WEBSITE_EMAIL_FROM', 'Social Codia');                        // your website name here
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', '587');
define('SMTP_SECURE', 'tls');


define('FIREBASE_AUTHORIZATION_KEY', 'AAAAifxv0SQ:APA91bH1jvGIQNyavWc8TxjAfj1XXVQxHKLI6K7s-HKZ3JRoNJzoNWXZICc0EIaO5yKA5ou2tmmKCXdncTegw8GyRaM1POyvy0697eunFENRlyLNeDnIjZgzIw7P_F9G_FKxxD77d59q');	// Change to your firebase key.

define('FIREBASE_URL', 'https://fcm.googleapis.com/fcm/send'); 	//Don't Change It.


define('WEBSITE_NAME', 'Stock Management');                              //your website name here
define('WEBSITE_OWNER_NAME', 'Umair Farooqui');                      //your name, or anyones name, we will send this name with email verification mail.

//This information will be used to genrate the invoice

define('COMPANY_NAME', 'Stock Management');
define('COMPANY_SLOGAN', 'ANDROID, WEB & SOFTWARE DEVELOPMENT');
define('COMPANY_SHORT_NAME', 'STM');			// Define the company short name that the will print with the invoice number
define('CUSTOMER_INVOICE_SHORT_NAME', 'STM');
define('COMPANY_EMAIL', 'info@socialcodia.com');
define('COMPANY_CONTACT_NUMBER', '+91 9867503256');
define('COMPANY_ADDRESS', 'Shop No 21, Ground Floor, Nadkar Complex, Tanwar Nagar, Kausa,
Mumbra, Dist. Thane - 400612');



define('DEFAULT_USER_IMAGE', 'uploads/api/user.png');

define('JWT_SECRET_KEY', 'SocialCodia');  							//your jwt secret key, Please use a very dificult secret key, which no one can guess it.
define('JWT_ADMIN_SECRET_KEY', 'SocialCodiaAdmin');  							//your jwt secret 


/*These two const are the admin's position, you can change and add the position id and position name.

NOTE : if you have created an admin with the position "admin" the value which will goes to database server is 1, for manager value will go to database
server is 2.

After adding the admin, if you change the position of the data, suppose if swap the any below value, the we will return the info as per the position, again suppose if you change the admin to manager and manager to admin, the script will show to the the admin position in web app different, for e.g the position of admin will show manager and the position of manager show the admin, but this will not effect any server side process. only you get wrong information to your web app and android app.
-Thanks
*/
define('ADMIN_POSITIONS_ID', array('1','2','3'));	
define('ADMIN_POSITIONS_NAME', array('Admin','Manager','Helper'));	





/*****************************************************************************************************************************/

//Stock Management System

define('EMAIL_NOT_VALID', 'Invalid Email Address');
define('PASSWORD_CHANGED', 'Password Has Been Changed');
define('PASSWORD_CHANGE_FAILED', 'Failed To Change The Password');
define('PASSWORD_UPDATED', 'Password Has Been Updated');



define('BARCODE_NOT_EXIST', 'Bar Code Not Found In Database');


define('USER_NOT_FOUND', "User Not Found");
define('LOGIN_SUCCESSFULL', "Login Successfull");
define('PASSWORD_WRONG', "Wrong Password");
define('UNAUTH_ACCESS', "Unauthorised Access");

define('SALE_RECORD_DELETED', 'Sale Record Deleted');
define('SALE_RECORD_DELETE_FAILED', 'Failed To Delete This Sale Record');
define('SALE_NOT_EXIST', 'No Sale Record Found');

define('SALE_UPDATED', 'Sale Record Updated');
define('SALE_UPDATE_FAILED', 'Failed To Update Sale Record');

define('SELL_PRODUCT', 'Sale Record Added');
define('SELL_PRODUCT_FAILED', 'Failed To Add This Sale Record');
define('PRODUCT_QUANTITY_LOW', 'Product Not Available');

define('PRODUCT_ADDED', 'Product Added');
define('PRODUCT_ADDED_FAILED', 'Failed To Add Product');

define('SELLER_INFORMATION_ADDED', 'Seller Information Added');
define('SELLER_INFORMATION_ADD_FAILED', 'Failed To Add Seller Information');

define('SELLER_LIST_FOUND', 'Sellers List Found');
define('SELLER_NOT_FOUND', 'No Seller Found');

define('SALES_LIST_FOUND', 'Sales List Found');
define('SALES_NOT_FOUND', 'No Sales Record Found');

define('BRAND_ADDED', 'Brand Added');
define('BRAND_ADD_FAILED', 'Failed To Add Brand');
define('BRAND_LIST_FOUND', 'Brand List Found');
define('BRAND_NOT_FOUND', 'No Brands Found');

define('PAYMENT_AMOUNT_INCREASE', 'Please Increase The Payment Amount');
define('PAYMENT_FAILED', 'Payment Failed');
define('PAYMENT_AMOUNT_GREATER', 'Amount Could Not Be Greater Than Invoice Amount');
define('PAYMENT_FOUND', 'Payment Found');
define('PAYMENT_NOT_FOUND', 'Payment Not Found');

define('INVOICE_ADDED', 'Invoice Added');
define('INVOICE_ADD_FAILED', 'Failed To Add Invoice');
define('INVOICE_LIST_FOUND', 'Invoices List Found');
define('INVOICE_FOUND_NEW', 'New Invoice Found');
define('INVOICE_FOUND', 'Invoice Found');
define('INVOICE_NOT_FOUND', 'No Invoice Found');

define('SALES_RECORD_NOT_FOUND', 'No Sales Record Found');



define('CT', 'Content-Type');
define('AJ', 'application/json');
define('USERID', 'userId');
define('COMMENTS', 'comments');
define('USER', 'user');

define('USERS', 'users');
define('EMAIL', 'email');

define('UPDATES', 'updates');
define('TOKEN', 'token');
define('SWW', 'Something Went Wrong');



define('MESSAGE', 'message');
define('ERROR', 'error');

//////////////////////////// END WARNING DON'T CHANGE PLEASE /////////////////////////////

//For JWT 
define('JWT_TOKEN_ERROR', 402);
define('JWT_TOKEN_FINE', 403);
define('JWT_USER_NOT_FOUND', 404);


///////////////////////////////////////////////////// END DON'T TOUCH THIS /////////////////////////////////////////////////////


