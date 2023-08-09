<?php

namespace apo\expertcodes\controllers;

use apo\expertcodes\parsers\ParserFactory;
use awsm\wp\libraries\utilities\UploadUtils;
use awsm\wp\libraries\utilities\RedirectBack;
use apo\expertcodes\roles\ExpertCodeManagerRole;

class ExpertCodesController
{

    use UploadUtils, RedirectBack;

    /**
     * Reference to the global $wpdb instance.
     *
     * @var wpdb
     */
    protected $wpdb;

    /**
     * The uploaded file name from the input field
     */
    protected $file = 'apo_expertcodes_file';

    /**
     * ExpertCodesController constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    /**
     * Initialize the controller actions.
     */
    public function init()
    {
        add_action('admin_post_apo_expertcodes_form', [$this, 'update']);
    }

    /**
     * Handle an incoming POST request.
     */
    public function update()
    {
        if (!current_user_can(ExpertCodeManagerRole::MANAGE_CAPABILITY)) {
            $this->redirectBack(['errors' => [__('Your user role have not the necessary capability for this action', 'apo-pun')]]);
        }

        if (!$this->hasValidNonce()) {
            $this->redirectBack(['errors' => [__('Invalid nonce. Try re-submitting the form.', 'apovoice-expert-codes')]]);
        }

        if (($message = $this->validateUploadedFile()) !== true) {
            $this->redirectBack(['errors' => [$message]]);
        }

        header('Content-Type: text/plain');

        $values = $this->parseUploadedFile();

        if (count($values) === 0) {
            $this->redirectBack(['infos' => [__('No new expert codes have been imported. Everything is up to date.', 'apovoice-expert-codes')]]);
        }

        $salesReps = $this->getSalesReps();
        $existingExpertCodes = $this->getExpertCodes();
        $existingExpertCodesOnly = $this->getOnlyExpertCodes();
        $newExpertCodes = [];
        $countUpdated = 0;

        foreach ($values as $item) {
            if ($this->isExistingExpertCode($item, $existingExpertCodesOnly)) {
                if ($this->hasExpertCodeChanged($item, $existingExpertCodes, $salesReps)) {
                    $this->updateExpertCode($item, $salesReps);

                    $countUpdated++;
                }
            } else {
                $newExpertCodes[] = $item;
            }
        }

        $countAdded = $this->addNewExpertCodes($newExpertCodes, $salesReps);
        $messages = [];

        if ($countAdded > 0) {
            $messages = ['infos' => [__(sprintf('%d new expert codes have been added.', $countAdded), 'apovoice-expert-codes')]];
        }

        if ($countUpdated > 0) {
            $messages = array_merge($messages, ['infos' => [__(sprintf('%d expert codes have been updated.', $countUpdated), 'apovoice-expert-codes')]]);
        }

        if (count($messages) > 0) {
            $this->redirectBack($messages);
        }

        $this->redirectBack(['infos' => [__('No new expert codes have been imported. Everything is up to date.', 'apovoice-expert-codes')]]);
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_expertcodes_save_settings_nonce'] ?? false;

        return wp_verify_nonce(wp_unslash($nonce), 'apo_expertcodes_save_settings');
    }

    /**
     * Parse the uploaded file from the request.
     *
     * @return array
     */
    protected function parseUploadedFile()
    {
        return ParserFactory::makeFromUpload($_FILES[$this->file])->parse();
    }

    /**
     * Get all sales rep users.
     *
     * @return array
     */
    protected function getSalesReps()
    {
        // TODO: Return only users that are considered as sales rep as soon as we have the permissions in place
        $sql = $this->wpdb->prepare("
            SELECT 
                   `ID`,
                   `user_email`
            FROM
                `wp_users`
        ", []);

        return $this->wpdb->get_results($sql);
    }

    /**
     * Get all existing expert codes.
     *
     * @return array
     */
    protected function getExpertCodes()
    {
        return $this->wpdb->get_results("
            SELECT
                `expert_code`,
                `sales_rep_user_id`,
                `usages`
            FROM
                `{$this->wpdb->prefix}expert_codes`;
        ");
    }


    /**
     * Get all existing expert codes.
     *
     * @return array
     */
    protected function getOnlyExpertCodes()
    {
        $result = $this->wpdb->get_results("
            SELECT
                `expert_code`
            FROM
                `{$this->wpdb->prefix}expert_codes`;
        ", ARRAY_A);

        return array_column($result, 'expert_code');
    }

    /**
     * Check if the given item is an existing expert code.
     *
     * @param  array  $item
     * @param  array  $existingExpertCodes
     *
     * @return bool
     */
    protected function isExistingExpertCode(array $item, array $existingExpertCodes)
    {
        return in_array($item['expert_code'], $existingExpertCodes);
    }

    /**
     * Check if the given item is an update to an existing expert code.
     *
     * @param  array  $item
     * @param  array  $existingExpertCodes
     * @param  array  $salesReps
     *
     * @return bool
     */
    protected function hasExpertCodeChanged(array $item, array $existingExpertCodes, array $salesReps)
    {
        foreach ($existingExpertCodes as $expertCode) {
            if ($expertCode->expert_code == $item['expert_code']) {
                $salesRepUserId = $this->findSalesRepUserId($item['email'], $salesReps);

                if ($salesRepUserId != $expertCode->sales_rep_user_id) {
                    return true;
                }

                $usages = empty($item['usages']) ? null : (int) $item['usages'];

                if ($usages !== $expertCode->usages) {
                    return true;
                }

                return false;
            }
        }

        return false;
    }

    /**
     * Add the given expert codes to the database.
     *
     * @param  array  $items
     * @param  array  $salesReps
     *
     * @return int
     */
    protected function addNewExpertCodes(array $items, array $salesReps)
    {
        $values = array_map(function (array $item) use ($salesReps) {
            $salesRepUserId = $this->findSalesRepUserId($item['email'], $salesReps);
            if ($salesRepUserId != 0) {
                $expertCodeName = "";

                if ($salesRepUserId === null)
                    $expertCodeName = $item['email'];

                $hasUnlimitedUsages = empty($item['usages']);
                $tokens = [
                    '%s',   // Expert Code
                    '%d',   // Sales Rep User ID
                    '%s',   // expert Code Name
                ];
                $substitutions = [
                    $item['expert_code'],
                    $salesRepUserId,
                    $expertCodeName,
                ];

                if ($hasUnlimitedUsages) {
                    $tokens[] = 'NULL';
                } else {
                    $tokens[] = '%d';
                    $substitutions[] = (int) $item['usages'];
                }

                $tokens[] = '%d';
                $substitutions[] = 0;
                $tokens[] = 'NOW()';
                $tokens[] = 'NOW()';

                return $this->wpdb->prepare(
                    '( ' . implode(', ', $tokens) . ' )',
                    $substitutions
                );
            }
        }, $items);

        $values = array_filter($values);

        $sql = "
            INSERT INTO
                `{$this->wpdb->prefix}expert_codes`
            (
                `expert_code`,
                `sales_rep_user_id`,
                `expert_code_name`,
                `usages`,
                `used`,
                `created_at`,
                `updated_at`
            ) VALUES
        " . implode(', ', $values);

        $this->wpdb->query($sql);

        return count($values);
    }

    /**
     * Update the given expert code.
     *
     * @param  array  $item
     * @param  array  $salesReps
     */
    protected function updateExpertCode(array $item, array $salesReps)
    {
        $salesRepUserId = $this->findSalesRepUserId($item['email'], $salesReps);
        $usages = empty($item['usages']) ? null : (int) $item['usages'];
        $substitutions = [$salesRepUserId];

        $expertCodeName = "";

        if ($salesRepUserId === null)
            $expertCodeName = $item['email'];

        $substitutions[] = $expertCodeName;

        if (!is_null($usages)) {
            $substitutions[] = $usages;
        }

        $substitutions[] = $item['expert_code'];

        $sql = $this->wpdb->prepare("
            UPDATE
                `{$this->wpdb->prefix}expert_codes`
            SET
                `sales_rep_user_id` = %d,
                `expert_code_name` = %s,
                `usages` = " . (is_null($usages) ? 'NULL' : '%d') . ",
                `updated_at` = NOW()
            WHERE
                `expert_code` = %s
        ", $substitutions);

        $this->wpdb->query($sql);
    }

    /**
     * Find the sales rep user id by the given email.
     *
     * @param  string  $email
     * @param  array  $salesReps
     *
     * @return int|null
     */
    protected function findSalesRepUserId($email, array $salesReps)
    {
        foreach ($salesReps as $salesRep) {
            if ($salesRep->user_email == $email) {
                return $salesRep->ID;
            }
        }

        return null;
    }
}
