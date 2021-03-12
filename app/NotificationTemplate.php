<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Retrives notification template from database
     *
     * @param  int  $business_id
     * @param  string  $template_for
     * @return array $template
     */
    public static function getTemplate($business_id, $template_for)
    {
        $notif_template = NotificationTemplate::where('business_id', $business_id)
                                                        ->where('template_for', $template_for)
                                                        ->first();
        $template = [
            'subject' => !empty($notif_template->subject) ? $notif_template->subject : '',
            'sms_body' => !empty($notif_template->sms_body) ? $notif_template->sms_body : '',
            'email_body' => !empty($notif_template->email_body) ? $notif_template->email_body
                             : '',
            'template_for' => $template_for,
            'auto_send' => !empty($notif_template->auto_send) ? 1
                             : 0,
            'auto_send_sms' => !empty($notif_template->auto_send_sms) ? 1
                             : 0
        ];

        return $template;
    }

    public static function customerNotifications()
    {
        return [
            'new_sale' => ['name' => __('lang_v1.new_sale')],
            'payment_received' => ['name' => __('lang_v1.payment_received')],
            'payment_reminder' => ['name' =>  __('lang_v1.payment_reminder')],
            'new_booking' => [
                    'name' => __('lang_v1.new_booking'),
                    'extra_tags' => self::bookingNotificationTags()
                ],
        ];
    }

    public static function supplierNotifications()
    {
        return [
            'new_order' => ['name' => __('lang_v1.new_order')],
            'payment_paid' => ['name' => __('lang_v1.payment_paid')],
            'items_received' => ['name' =>  __('lang_v1.items_received')],
            'items_pending' => ['name' => __('lang_v1.items_pending')],
        ];
    }

    public static function notificationTags()
    {
        return ['{contact_name}', '{invoice_number}', '{total_amount}',
        '{paid_amount}', '{due_amount}', '{business_name}', '{business_logo}'];
    }

    public static function bookingNotificationTags()
    {
        return ['{contact_name}', '{table}', '{start_time}',
        '{end_time}', '{location}', '{service_staff}', '{correspondent}', '{business_name}', '{business_logo}'];
    }

    public static function defaultNotificationTemplates($business_id)
    {
        $notification_template_data = [
            [
                'business_id' => $business_id,
                'template_for' => 'new_sale',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>Your invoice number is {invoice_number}<br />
                    Total amount: {total_amount}<br />
                    Paid amount: {paid_amount}</p>

                    <p>Thank you for shopping with us.</p>

                    <p>{business_logo}</p>

                    <p>&nbsp;</p>',
                'sms_body' => 'Dear {contact_name}, Thank you for shopping with us. {business_name}',
                'subject' => 'Thank you from {business_name}',
                'auto_send' => '0'
            ],

            [
                'business_id' => $business_id,
                'template_for' => 'payment_received',
                'email_body' => '<p>Dear {contact_name},</p>

                <p>We have received a payment of {paid_amount}</p>

                <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, We have received a payment of {paid_amount}. {business_name}',
                'subject' => 'Payment Received, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'payment_reminder',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>This is to remind you that you have pending payment of {due_amount}. Kindly pay it as soon as possible.</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, You have pending payment of {due_amount}. Kindly pay it as soon as possible. {business_name}',
                'subject' => 'Payment Reminder, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'new_booking',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>Your booking is confirmed</p>

                    <p>Date: {start_time} to {end_time}</p>

                    <p>Table: {table}</p>

                    <p>Location: {location}</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, Your booking is confirmed. Date: {start_time} to {end_time}, Table: {table}, Location: {location}','subject' => 'Booking Confirmed - {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'new_order',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have a new order with reference number {invoice_number}. Kindly process the products as soon as possible.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, We have a new order with reference number {invoice_number}. Kindly process the products as soon as possible. {business_name}',
                'subject' => 'New Order, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'payment_paid',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have paid amount {paid_amount} again invoice number {invoice_number}.<br />
                    Kindly note it down.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'We have paid amount {paid_amount} again invoice number {invoice_number}.
                    Kindly note it down. {business_name}',
                'subject' => 'Payment Paid, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'items_received',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have received all items from invoice reference number {invoice_number}. Thank you for processing it.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'We have received all items from invoice reference number {invoice_number}. Thank you for processing it. {business_name}',
                'subject' => 'Items received, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'items_pending',
                'email_body' => '<p>Dear {contact_name},<br />
                    This is to remind you that we have not yet received some items from invoice reference number {invoice_number}. Please process it as soon as possible.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'This is to remind you that we have not yet received some items from invoice reference number {invoice_number} . Please process it as soon as possible.{business_name}',
                'subject' => 'Items Pending, from {business_name}',
                'auto_send' => '0'
            ]
        ];

        return $notification_template_data;
    }
}
