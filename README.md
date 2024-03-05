# Shopify New Order Notification Webhook Setup

This README provides instructions on setting up a webhook in Shopify to send notifications of new orders to an external server. The webhook will target a PHP script (`new-order-api.php`) that must be hosted externally. This setup is useful for integrating Shopify order notifications with external systems for order processing, analytics, or custom notifications.

## Prerequisites

- Access to a Shopify admin account
- An external web server with PHP support
- Basic understanding of webhooks and PHP scripting

## Step 1: Upload the PHP Script

1. **Prepare `new-order-api.php`**: Ensure your `new-order-api.php` script is ready for handling incoming webhook requests. The script should be capable of parsing JSON data sent by Shopify.

2. **Upload the Script**: Upload `new-order-api.php` to your external server. Choose a directory that is accessible from the web but secure enough to prevent unauthorized access.

   Example path: `https://yourserver.com/webhooks/new-order-api.php`

3. **Test Script Accessibility**: Ensure that the URL to your PHP script is accessible from the internet. You can test this by accessing the URL from a web browser or using a tool like `curl`.

## Step 2: Create a Webhook in Shopify

1. **Log in to Shopify Admin**: Access your Shopify admin dashboard by logging in to your account.

2. **Navigate to Webhooks**:
   - Go to `Settings` > `Notifications`.
   - Scroll down to the `Webhooks` section at the bottom of the page.

3. **Create a New Webhook**:
   - Click the `Create webhook` button.
   - For the **Event**, select `Order creation`.
   - In the **Format** field, choose `JSON`.
   - In the **URL** field, enter the URL where you uploaded `new-order-api.php`. (e.g., `https://yourserver.com/webhooks/new-order-api.php`)
   - Set the **Webhook API version** to the latest available version.
   - Click `Save webhook`.

## Step 3: Test the Webhook

1. **Create a Test Order**: Place a test order on your Shopify store to trigger the webhook. You can do this by creating a manual order or using a test payment method if your store is not yet live.

2. **Verify Incoming Data**: Check your external server logs or the functionality within your `new-order-api.php` script to ensure it receives the data correctly. Adjust your script as necessary to handle the data format sent by Shopify.

## Troubleshooting

- **Webhook Not Triggering**: Ensure the webhook is set correctly in Shopify and that the URL is correctly pointing to your external script.
- **Script Not Receiving Data**: Verify that your server's firewall or .htaccess file isn't blocking incoming requests. Check PHP error logs for any server-side issues.

## Security Considerations

- **Validate Requests**: Ensure your script validates incoming requests to confirm they are from Shopify. Use Shopify's webhook verification techniques to secure your endpoint.
- **SSL Certificate**: Use HTTPS for your webhook URL to ensure data is transmitted securely.

For more detailed information on webhooks and securing your endpoint, refer to Shopify's official documentation.
