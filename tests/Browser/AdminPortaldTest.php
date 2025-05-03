<?php

namespace Tests\Browser;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;

// test comment
// ok
use Tests\DuskTestCase;

class AdminPortaldTest extends DuskTestCase
{

    const APP_URL = "https://wasla-jo.laravel.cloud";
    /**
     * Log in to the application.
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit( self::APP_URL.'/admin/login')
                ->type('email', 'dev@wasla.com') // Type your email
                ->type('password', 'wasla2@25')      // Type your password
                ->press('#login-button')                           // Press the login button
                ->waitForLocation('/dashboard');
        });
    }
    /**
     * Test to verify the sidebar menu items are displayed correctly:
     * - Checks for presence of all essential sidebar links
     */
    public function testSidebarMenuItemsVisibility()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->waitFor('.sidebar')
                ->assertSee('Dashboard')
                ->assertSee('Uncompleted Orders')
                ->assertSee('Admins')
                ->assertSee('Advertising')
                ->assertSee('Drivers')
                ->assertSee('Loyalty Points')
                ->assertSee('Orders')
                ->assertSee('Customers')
                ->assertSee('Push Notifications')
                ->assertSee('System Settings');
        });
    }




    /**
 * Test to verify the dashboard page functionalities:
 * - Checks if dashboard loads with all key sections and cards
 */
    public function testDashboardPageContentAndRefresh()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point

            $browser
                ->assertSee('Dashboard')
                ->assertSee('Update Data')
                ->waitFor('.card-body')  // Wait for the cards to load
                ->assertSeeIn('.card-label', 'TOTAL ORDERS TODAY')
                ->assertSee('ACTIVE ORDERS')
                ->assertSee('COMPLETED ORDERS')
                ->assertSee('NEW CUSTOMERS (WEEK)')
                ->assertSee('AVG. ORDER VALUE')
                ->assertSee('COMPLETED ORDERS THIS YEAR')
                ->assertSee('REVENUE TODAY')
                ->assertSee('AVAILABLE DRIVERS')
                ->assertSee('IN PROGRESS ORDERS')
                ->assertSee('PENDING ORDERS')
                ->assertSee('CANCELED ORDERS')
                ->assertSee('ACTIVE STATUS DRIVERS')
                ->assertSee('Completed')
                ->assertSee('Offer Accepted')
                ->assertSee('Driver Started')
                ->assertSee('Unknown Status')
                ->assertSee('Weekly Order Trend')
                ->assertSee('Daily Revenue (Last 7 Days)')
                ->assertSee('Top Regions by Order Volume')
                ->assertSee('Orders by Status')
                ->assertSee('Weekly Order Trend')
                ->assertSee('Daily Revenue (Last 7 Days)')
                ->assertSee('Top Regions by Order Volume')

                ->click('#btn-dashboard-refresh')//Tests the dashboard data refresh button and its confirmation message
                ->assertSee('Dashboard data has been refreshed successfully.')

            ;
        });
    }


    /**
 * Test to check the "Uncompleted Orders" page.
 * Verifies the "No Uncompleted Orders" message.
 */
    public function testUncompletedOrders()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->press('#UncompletedOrders')
                ->assertSee('Uncompleted Orders')

            ;
        });
    }



    /**
 * Test the Admins page functionality:
 * - Verifies elements on the page like filters, admin list, and admin actions.
 * - Confirms the display of different roles and statuses.
 */
    public function testAdminsPage()
    {
        $this->browse(function (Browser $browser) {
            $browser
                // Verify that the main headings are displayed on the page
                ->press('#Admins')
                ->assertSee('Admins')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')
                ->assertSee('Add New Admin')
                ->assertSee('Search')



                // Verify that the Role filter is displayed
                ->assertSee('Filter by Role')
                ->press('#roleFilter')
                ->assertSee('All Role')
                ->assertSee('General Manager')
                ->assertSee('Operation Manager')
                ->assertSee('Developer')
                ->assertSee('Reset All Filters')



                // Verify that the Status filter is displayed
                ->assertSee('Filter by Status')
                ->assertSee('All')
                ->assertSee('Active')
                ->assertSee('Inactive')

                // Verify that the Admins List with necessary columns is shown
                ->assertSee('Admins List')
                ->assertSee('Id')
                ->assertSee('Name')
                ->assertSee('Email')
                ->assertSee('Mobile')
                ->assertSee('Role')
                ->assertSee('Status')
                ->assertSee('Actions')

                // Verify that pagination elements are visible
                ->assertSee('records')
                ->assertSee('Previous')
                ->assertSee('Next')
            ;
        });
    }

          // * Test for creating a new admin user
    public function testCreateAdmin()
    {

        $this->browse(function (Browser $browser) {
           // Generate random email and mobile for testing purposes
            $randomEmail = 'rania' . Str::random(5) . '@wasla.com';
            $randomMobile = '078' . rand(1000000, 9999999);

            $browser

                ->press('#btn-add-new-admin')
                ->waitForLocation('/admin/create')

                ->assertSee('Admin Panel')
                ->assertSee('Admin Information')
                ->assertSee('Name')
                ->assertSee('Email')
                ->assertSee('Password')
                ->assertSee('Confirm Password')
                ->assertSee('Mobile')
                ->assertSee('Role')
                ->assertSee('Create Admin')
                ->assertSee('Back to List')
                ->assertSee('Add New Admin')


                // Fill in valid data for the new admin
                ->type('name', 'rania')
                ->type('email', $randomEmail)
                ->type('password', 'r1234567')
                ->type('password_confirmation', 'r1234567')
                ->type('mobile', $randomMobile)
                ->select('role_id', '1') // Assigning 'General Manager' role (role_id = 1)
                ->press('#btn-create-admin')


                ->waitForLocation('/admin')
                ->waitForText('Admin created successfully')
                ->assertSee('Admin created successfully')


                //عيديه
                //Try creating an admin with an already taken email
                ->press('#btn-add-new-admin')
                ->waitForLocation('/admin/create')
                ->type('name', 'rania')
                ->type('email', 'ran@wasla.com')
                ->type('password', 'r1234567')
                ->type('password_confirmation', 'r1234567j')
                ->type('mobile', '0786742345')
                ->select('role_id', '1')
                ->press('#btn-create-admin')

                ->assertSee('The email has already been taken.')
                ->assertSee('The password field confirmation does not match.')


                ->press('#btn-back-to-admin-list')
                ->type('#globalSearch', 'ran@wasla.com') // Search for the admin using the email
                // ->assertSee('rania')
                // ->assertSee('General Manager')
                //  ->press('#btn-admin-actions-3')

            ;
        });
    }




/*Test for the advertising page and image upload:
 * - Checks key elements on the advertising page
 * - Verifies navigation to the image upload page*/

    public function testAdvertisingPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(self::APP_URL.'/advertising')
                ->waitForLocation('/advertising')
                ->assertSee('Advertising')
                ->assertSee('Advertising Images')
                ->assertSee('Upload New Image')

                ->press('#btn-upload-new-image')
                ->waitForLocation('/advertising/create')
                ->assertSee('Upload Advertising Image')
                ->assertSee('Select Image')
                ->assertSee('Upload Image')
                ->assertSee('Cancel') ;
        });
    }


    public function testDriversPageAndNotification()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit(self::APP_URL.'/admin/drivers')
                ->waitForLocation('/admin/drivers')


                // Verify presence of key elements
                ->assertSee('Drivers')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')
                ->assertSee('Search')

                // Check filter options for driver status
                ->assertSee('Filter by Status')
                ->press('#statusFilter')
                ->assertSee('All Statuses')
                ->assertSee('Pending')
                ->assertSee('Active')
                ->assertSee('Inactive')
                ->assertSee('Rejected')
                ->assertSee('Blocked')
                ->assertSee('Deleted')

                // Verify account status filters
                ->assertSee('Pending Accounts')
                ->assertSee('Active Accounts')

                 // Verify quick filters and reset button
                ->assertSee('Quick Filters:')
                ->assertSee('Reset All Filters')

                // Verify driver list headers
                ->assertSee('Drivers List')
                ->assertSee('ID')
                ->assertSee('Name')
                ->assertSee('Availability')
                ->assertSee('Mobile')
                ->assertSee('Account Actions')
                ->assertSee('Account Status')
                ->assertSee('View')
                ->assertSee('Previous')
                ->assertSee('Next')

                ->check('#select-all')


                // Verify notification options
                ->assertSee('Send Notification')
                ->assertSee('Notify about Order')
                ->assertSee('Clear')
                ->assertSee('drivers selected')


                // Trigger order notification
                ->press('#orderOverlayBtn')
                ->waitForText('Notify Drivers about Order')
                ->assertSee('Order ID')
                ->assertSee('Cancel');
        });
    }



    public function testLoyaltyPointsPageAndRequestManagement()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit(self::APP_URL.'/admin/point-convert-requests')
                ->waitForLocation('/admin/point-convert-requests')
                ->assertSee('Loyalty Points')

                ->assertSee('Manage Loyalty Points Requests')

                // Check filtering options for loyalty points requests
                ->press('#statusFilter')
                ->assertSee('Pending')
                ->assertSee('All')
                ->assertSee('Approved')
                ->assertSee('Rejected')


                ->assertSee('Search:')
                ->assertSee('Filter by Status')
                ->assertSee('ID')
                ->assertSee('Driver Name')
                ->assertSee('Points')
                ->assertSee('Request Date')
                ->assertSee('Status')
                ->assertSee('Note')
                ->assertSee('Actions')


                ->assertSee('Next')
                ->assertSee('Previous')
                ->assertSee('Showing')
                ->assertSee('to')
                ->assertSee('of')
                ->assertSee('entries')
            ;
        });
    }


    public function testOrdersPageAndFilters()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit(self::APP_URL.'/admin/orders')
                ->waitForLocation('/admin/orders')

                ->assertSee('Orders')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')
                ->assertSee('Search')

                ->assertSee('Filter by Status')
                ->press('#statusFilter')
                // Check status filter options
                ->assertSee('All Statuses')
                ->assertSee('Open to offers')
                ->assertSee('Accepted offer')
                ->assertSee('Driver start')
                ->assertSee('Driver in area')
                ->assertSee('Driver on the way')
                ->assertSee('Driver on the start point')
                ->assertSee('Driver inprogress')
                ->assertSee('Arrived at the destination')
                ->assertSee('Driver completed')
                ->assertSee('Completed')
                ->assertSee('Not completed driver')
                ->assertSee('Not completed customer')
                ->assertSee('Canceled before accepted')
                ->assertSee('Cancel by driver')
                ->assertSee('Cancel by customer')
                ->assertSee('Cancel by system')
                ->assertSeeIn('#statusFilter', 'Cancel by admin')



                ->assertSee('Reset All Filter')

                ->assertSee('Orders List')
                ->assertSee('records')
                ->assertSee('Orders List')
                ->assertSee('ID')
                ->assertSee('Order Number')
                ->assertSee('Customer')
                ->assertSee('Cost')
                ->assertSee('Driver')
                ->assertSee('Status')
                ->assertSee('Created At')
                ->assertSee('Actions')
                ->assertSee('Showing')
                ->assertSee('entries')
                ->assertSee('Next')
                ->assertSee('Previous')
                ->assertSee('Showing')
                ->assertSee('to')
                ->assertSee('of')
                ->assertSee('entries')
            ;
        });
    }





    /**
 * Test adding a new customer:
 * - Checks customer page and filters
 * - Opens add customer form
 * - Fills and submits the form
 * - Confirms success message
 */

    public function testAddNewCustomer()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(self::APP_URL.'/admin/customers')
                ->waitForLocation('/admin/customers')
                ->assertSee('Customers')
                ->assertSee('Customers Management')
                ->assertSee('Search')
                ->assertSee('Search & Filters')
                ->assertSee('Toggle Filters')

                // Check status filter options
                ->assertSee('Filter by Status')
                ->press('#statusFilter')
                ->assertSee('All Statuses')
                ->assertSee('Active')
                ->assertSee('Blocked')

                // Check table headers and controls
                ->assertSee('Customers List')
                ->assertSee('ID')
                ->assertSee('Name')
                ->assertSee('Mobile')
                ->assertSee('View')
                ->assertSee('Status')
                ->assertSee('Note')
                ->assertSee('Actions')
                ->assertSee('Next')
                ->assertSee('Previous')
                ->assertSee('Showing')
                ->assertSee('entries')
                ->assertSee('Add New Customer')


                // Navigate to Add New Customer page
                ->press('#btn-add-new-customer')
                ->waitForLocation('/admin/customers/create')
                ->assertSee('Add New Customer')
                ->assertSee('Customer Information')
                ->assertSee('Full Name')
                ->assertSee('Mobile Number')
                ->assertSee('Status ')
                ->assertSee('Create Customer')
                ->assertSee('Back to List')

                ->type('#full_name', 'rania')
                ->type('#mobile', '0786453425')
                ->press('#btn-create-customer')

                ->waitForText('Customer created successfully')
                /*
                                        ->assertSee('rania')
                                        ->assertSee('0786453425')
                                        */



            ;
        });
    }

    /**
     * Test to verify the push notifications page functionalities:
     * - Checks if page loads with required elements
     * - Verifies dropdown options
     * - Sends a sample notification
     * - Asserts confirmation message after sending
     */
    public function testPushNotificationsPageAndSendFunctionality()
    {
        $this->browse(function (Browser $browser) {
            // Visit push notifications page
            $browser->visit(self::APP_URL.'/notifications')
                ->waitForLocation('/notifications')
                ->waitForText('Push Notifications')
                ->assertSee('Push Notifications')
                ->assertSee('Send Push Notification')

                // Check for available audience options
                ->assertSee('Target Audience')
                ->press('#topic')
                ->waitForText('Select Topic')
                ->assertSee('Select Topic')
                ->assertSee('Driver Topic')
                ->assertSee('Customer Topic')
                ->assertSee('Unregistered Users')
                ->assertSee('Registered Users')
                ->assertSee('App Downloader')

                // Check notification form fields
                ->assertSee('Notification Title')
                ->assertSee('Notification Body')
                ->assertSee('Send Notification')

                // Fill and send notification
                ->type('#title', 'Hi')
                ->type('#body', 'Hi')
                ->select('#topic', 'driver_topic')

                // Wait for button to be visible before clicking to avoid stale element
                ->waitFor('#btn-send-notification')
                ->press('#btn-send-notification')

                // Confirm success message appears
                ->waitForText('Notification has been queued for sending.')
                ->assertSee('Notification has been queued for sending.');
        });
    }


    /**
 * Test system settings page:
 * - Checks main settings
 * - Opens and verifies update confirmation modal
 */

    public function testSystemSettingsPage()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $browser->visit(self::APP_URL.'/admin/system-settings')
                ->waitForLocation('/admin/system-settings')
                ->assertsee('Admin Panel')
                ->assertsee('System Settings')
                ->assertsee('Online Payment')
                ->assertsee('Maintenance Mode')
                ->assertsee('App Version')
                ->assertsee('Apple API Link')
                ->assertsee('Google Play API Link')
                ->assertsee('WhatsApp Link')
                ->assertsee('Facebook Page Link')
                ->assertsee('Instagram Page Link')
                ->assertsee('Update Settings')
                ->assertsee('Developer Tools')
                ->assertsee('Telescope')
                ->assertsee('Swagger')

                ->press('#btn-open-update-modal')
                ->pause(1000)
                ->assertsee('Are you sure you want to update these system settings?')
                ->assertsee('Confirm Update')
                ->assertsee('This action cannot be undone.')
                ->assertsee('Cancel')
                ->assertsee('Confirm')

            ;
        });
    }
}
